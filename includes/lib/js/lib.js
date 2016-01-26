// declare everything inside this object
window.JB = window.JB || {};
(function(JB, $, Backbone) {
    JB.Models = JB.Models || {};
    JB.Collections = JB.Collections || {};
    JB.Views = JB.Views || {};
    JB.Routers = JB.Routers || {};
    // the pub/sub object for managing event throughout the app
    JB.pubsub = JB.pubsub || {};
    _.extend(JB.pubsub, Backbone.Events);       
    // create a shorthand for our pubsub
    /**
     * override backbone sync function
     */
    Backbone.Model.prototype.sync = function(method, model, options) {
        var data = model.attributes;
        data.action = model.action || 'jb-sync';
        switch (method) {
            case 'create':
                data.method = 'create';
                break;
            case 'update':
                data.method = 'update';
                break;
            case 'delete':
                data.method = 'remove';
                break;
            case 'read':
                data.method = 'read';
                break;
        }
        var ajaxParams = {
            type: 'POST',
            dataType: 'json',
            data: data,
            url: jb_globals.ajaxURL,
            contentType: 'application/x-www-form-urlencoded;charset=UTF-8'
        };
        ajaxParams = _.extend(ajaxParams, options);
        if (options.beforeSend !== 'undefined') ajaxParams.beforeSend = options.beforeSend;
        ajaxParams.success = function(result, status, jqXHR) {
            JB.pubsub.trigger('jb:success', result, status, jqXHR);
            options.success(result, status, jqXHR);
        };
        ajaxParams.error = function(jqXHR, status, errorThrown) {
            JB.pubsub.trigger('jb:error', jqXHR, status, errorThrown);
            options.error(jqXHR, status, errorThrown);
        };
        $.ajax(ajaxParams);
    };
    /**
     * override backbone collection sync
     */
    Backbone.Collection.prototype.sync = function(method, collection, options) {
        var ajaxParams = {
            type: 'POST',
            dataType: 'json',
            data: {},
            url: jb_globals.ajaxURL,
            contentType: 'application/x-www-form-urlencoded;charset=UTF-8'
        };
        ajaxParams.data = _.extend(ajaxParams.data, options.data);
        if (typeof collection.action !== 'undefined') {
            ajaxParams.data.action = collection.action;
        }
        /**
         * add beforsend function
         */
        if (options.beforeSend !== 'undefined') ajaxParams.beforeSend = options.beforeSend;
        /**
         * success function
         */
        ajaxParams.success = function(result, status, jqXHR) {
            JB.pubsub.trigger('jb:success', result, status, jqXHR);
            options.success(result, status, jqXHR);
        };
        ajaxParams.error = function(jqXHR, status, errorThrown) {
            JB.pubsub.trigger('jb:error', jqXHR, status, errorThrown);
            options.error(jqXHR, status, errorThrown);
        };
        $.ajax(ajaxParams);
        // console.log(collection.getAction());
    }
    /**
     * override backbone model parse function
     */
    Backbone.Model.prototype.parse = function(result) {
        if (_.isObject(result.data)) {
            return result.data;
        } else {
            return result;
        }
    };
    /**
     * override backbone model parse function
     */
    Backbone.Collection.prototype.parse = function(result) {
        if (_.isObject(result) && _.isObject(result.data)) {
            return result.data;
        } else {
            return [];
        }
    };
})(window.JB, jQuery, Backbone);

// override underscore template tag
_.templateSettings = {
    evaluate: /\<\#(.+?)\#\>/g,
    interpolate: /\{\{=(.+?)\}\}/g,
    escape: /\{\{-(.+?)\}\}/g
};
(function(JB, $, Views, Backbone) {
	$(document).ready(function(){
		JB.Models.Post = Backbone.Model.extend({
        	action: 'jb-sync-post',
        	initialize: function() {}
    	});
        JB.Collections.Posts = Backbone.Collection.extend({
            model: JB.Models.Post,
            action: 'jb-fetch-posts',
            initialize: function() {
                this.paged = 1;
            }
        });
    	Views.PostItem = Backbone.Marionette.ItemView.extend({
            // view html tag
            tagName: "li",
            // view class
            className: 'post-item',
            /**
             * view events
             */
            events: {
                // user click on action button such as edit, archive, reject
                'click a.action': 'acting'
            },
            /**
             * list all model events
             */
            modelEvents: {
                "change": "modelChanged",
                "change:post_status": "statusChange"
            },
            /**
             * model in view change callback function
             * update model data to database
             */
            modelChanged: function(model) {
                this.render();
            },
            statusChange: function(model) {
                JB.pubsub.trigger('jb:model:statuschange', model);
            },              
            acting: function(e) {                
                e.preventDefault();
                var view = this;
               // console.log(view.$el);
                var target = $(e.currentTarget),
                    action = target.attr('data-action'),
                    view = this;                    
                switch (action) {
                    case 'edit':
                        //trigger an event will be catch by JB.App to open modal edit
                        JB.pubsub.trigger('jb:model:onEdit', this.model, view.$el);
                        break;
                    case 'delete':
                        if (confirm(jb_globals.confirm_message)) {
                            // archive a model
                            var view = this;
                            this.model.destroy();               
                        }
                        break;
                    case 'add': 
                    	view.render();
                    	break;
                    default:
                        //trigger an event will be catch by JB.App to open modal edit
                        JB.pubsub.trigger('jbe:model:on' + action, this.model);
                        break;
                }
            }
        });
        /**
         * view of posts list
         */
        Views.ListPost = Backbone.Marionette.CollectionView.extend({       
            constructor: function(options) {
                var view = this;
                Marionette.CollectionView.prototype.constructor.apply(this, arguments);
                if (typeof this.collection !== 'undefined') {
                    this.collection.each(function(pack, index, col) {
                        var el = view.$('.' + view.itemClass).eq(index);                        
                        itemView = view.getChildView(pack);
                        // this view is about to be added
                        view.triggerMethod("before:item:added", view);
                        view.children.add(new itemView({
                            el: el,
                            model: pack
                        }));
                        // this view was added
                        view.triggerMethod("after:item:added", view);
                    });
                }
            }
        });
    	/**
    	 * Uploader view 
    	 *
    	 */
    	Views.File_Uploader = Backbone.View.extend({
    		events: {
    			//'click .jb_uploader_button': 'openUploadModal',
                'click .jb_upload_button': 'openUploadMedia'
    		},
    		initialize: function(options){
    			var view = this;	                
    			view.options = 	options;	
    			view.model = view.options.model?view.options.model: {}
                view.type = view.options.type? view.options.type: 'post'
    		},			
    		//openUploadModal: function(e){
    		//	e.preventDefault();
    		//	var view = this;
    		//	var send_attachment_bkp = wp.media.editor.send.attachment;
    		//	var button = $(e.currentTarget);
    		//	// var id = button.attr('id').replace('_button', '');
    		//	_custom_media = true;
    		//	wp.media.editor.send.attachment = function(props, attachment){
    		//		if ( _custom_media ) {
             //           if( view.model && view.type == 'post'){
             //               view.model.set('featured_image', attachment.id);
             //               view.model.save('', '', {
             //                   beforeSend: function() {
             //
             //                   },
             //                   success: function(model, resp) {
             //                       JB.pubsub.trigger('jb:editImage:success', resp);
             //                   }
             //               });
             //           }
    		//		} else {
    		//			return _orig_send_attachment.apply( this, [props, attachment] );
    		//		};
    		//	}
    		//	wp.media.editor.open(button);
    		//	return false;
    		//},
            openUploadMedia: function(e){
                var view = this;
                e.preventDefault();
                // Set all variables to be used in scope
                var frame,
                    metaBox = $('#meta-box-id.postbox'), // Your meta box id here
                    addImgLink = metaBox.find('.upload-custom-img'),
                    delImgLink = metaBox.find( '.delete-custom-img');
                if ( frame ) {
                    frame.open();
                    return;
                }
                // Create a new media frame
                frame = wp.media({
                    title: 'Select or Upload Media Of Your Chosen Persuasion',
                    button: {
                        text: 'Use this media'
                    },
                    multiple: false  // Set to true to allow multiple files to be selected
                });
                // When an image is selected in the media frame...
                frame.on( 'select', function() {
                    // Get media attachment details from the frame state
                    var attachment = frame.state().get('selection').first().toJSON();
                    // Hide the add image link
                    addImgLink.addClass( 'hidden' );
                    // Unhide the remove image link
                    delImgLink.removeClass( 'hidden' );
                    if( view.model && view.type == 'post'){
                        view.model.set('featured_image', attachment.id);
                        view.model.save('', '', {
                            beforeSend: function() {
                            },
                            success: function(model, resp) {
                                JB.pubsub.trigger('jb:editImage:success', resp);
                            }
                        });
                    }

                });
                // Finally, open the modal on click
                frame.open();
            }
    	});
    	/**
    	 * Front-end editor 
    	 *
    	 */
    	Views.inlineEditor = Backbone.View.extend({
    		events: {
    			'click .jb_text_editor': 'jb_text_editor',
    			'change .jb_text_editor_field': 'jb_text_save_change',
    			'focusout .jb_text_editor_field': 'jb_text_un_save_change'
    		},
    		initialize: function(options){
    			var view = this;
    			view.options = options;
    			view.currentEl = '';	
    			view.model = view.options.model? view.options.model: {}	;
    		},
    		jb_text_editor: function(e){
    			var view = this;
    			e.preventDefault();
    			$target = $(e.currentTarget);
    			view.currentEl = $target;				
    			var type = 'input';
    			if( typeof $target.attr('data-type') !== 'undefined' ){
    				type = $target.attr('data-type');
    			}
    			var name = '';
    			if( typeof $target.attr('data-name') !== 'undefined' ){
    				name = $target.attr('data-name');
    			}
    			switch( type ){
    				case 'input': 
    					if( !$target.hasClass('jb_on_edit') ){
    						view.editInput($target, name);
    					}						
    					break;
    				case 'textarea':
    					if( !$target.hasClass('jb_on_edit') ){
    						view.editTextarea($target, name);
    					}	
    					break;
    				default:
    					if( !$target.hasClass('jb_on_edit') ){
    						view.editInput($target, name);
    					}						
    					break;
    			}				
    		},
    		editInput: function(target, name){
    			var html = '<input style="width:100%" class="jb_text_editor_field '+name+'_field" name="'+name+'" value="'+target.html()+'" />';
    			target.addClass('jb_on_edit');
    			target.html(html);
    			target.find('input').focus();				
    		},
    		editTextarea: function(target, name){
    			var height = target.height();
    			var html = '<textarea style="width:100%; height:'+height+'" class="jb_text_editor_field '+name+'_field" name="'+name+'">'+target.html()+'</textarea>';
    			target.addClass('jb_on_edit');
    			target.html(html);			
    			target.find('textarea').focus();					
    		},
    		jb_text_save_change: function(){
    			var view = this;
    			new_val = view.currentEl.find('.jb_text_editor_field').val();
    			field_name = view.currentEl.find('.jb_text_editor_field').attr('name');					
    			if( view.model ){                   
    				view.model.set(field_name, new_val);                    
    				view.model.save('', '', {
                        beforeSend: function() {
                            
                        },
                        success: function(model, resp) {                            
                        	JB.pubsub.trigger('jb:edit:success', resp);                        
    						view.currentEl.html(new_val);	
    						view.currentEl.removeClass('jb_on_edit');	
                        }
                    });	
    			}											
    		},
    		jb_text_un_save_change: function(){						
    			var view = this;
    			new_val = view.currentEl.find('.jb_text_editor_field').val();				
    			view.currentEl.html(new_val);	
    			view.currentEl.removeClass('jb_on_edit');											
    		}
    	});
	});			
})(window.JB, jQuery, window.JB.Views, Backbone);