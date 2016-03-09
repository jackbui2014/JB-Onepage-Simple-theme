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
        Views.BlockControl = Backbone.Marionette.View.extend({
            initialize: function(options) {
                _.bindAll(this, 'addPost', 'onModelChange');
                var view = this;
                this.page = 1;
                this.options = _.extend(this, options);
                this.blockUi = new Views.BlockUi();
                if (this.$('.jb_query').length > 0) {
                    this.query = JSON.parse(this.$('.jb_query').html());
                } else {
                    this.$('.paginations').remove();
                }
                // bind event add to collection
                this.collection.on('add', this.addPost, this);
                // bind event when model change
                JB.pubsub.on('ae:model:statuschange', this.onModelChange, this);
                // init grid view
                this.grid = (options.grid) ? options.grid : 'grid';
                this.searchDebounce = _.debounce(this.onSearchDebounce, 500);
                if (this.$('.skill-control').length > 0 && this.$('.skill_filter').val() != '') {
                    // init collection skill
                    this.post = new Models.Post();
                    this.skill_view = new Views.Skill_Control({
                        collection: this.skills,
                        model: this.post,
                        el: view.$('.skill-control')
                    });
                    // bind event collection skill change, add, remove filter
                    this.skills.on('add', this.filterSkill, this);
                    this.skills.on('remove', this.filterSkill, this);
                }
                view.triggerMethod("after:init");
            },
            filterSkill: function() {
                var skill = this.skills.toJSON();
                var view = this;
                var input_skill = $('.skill');
                //console.log(skill);
                skill = _.map(skill, function(element) {
                    return element['name'];
                });
                view.query['skill'] = skill;
                view.page = 1;
                view.fetch(input_skill);
            },
            events: {
                // ajax load more
                'click a.load-more-post': 'loadMore',
                // select a page in pagination list
                'click .paginations a.page-numbers': 'selectPage',
                // previous page
                'click .paginations a.prev': 'prev',
                // next page
                'click .paginations a.next': 'next',
                // filter
                'change select ': 'selectFilter',
                // order post list by date/rating
                'click a.orderby': 'order',
                // filter post_status
                'click a.click-type' : 'clickType',
                // switch view between grid and list
                'click .icon-view': 'changeView',
                // search post
                'keyup input.search': 'search',
                // Slider range drag
                'slideStop .slider-ranger': 'filterRange',
                'change .slider-ranger': 'filterRange',
                // Change date filer
                'changeDate .datepicker': 'filterDate',
            },
            /**
             * handle on change search field
             */
            search: function(event) {
                var target = $(event.currentTarget);
                this.searchDebounce(target);
            },
            /**
             * handle ajax search
             */
            onSearchDebounce: function($target) {
                var name = $target.attr('name'),
                    view = this;
                if (name !== 'undefined') {
                    // console.log(view.query);
                    view.query[name] = $target.val();
                    view.page = 1;
                    // fetch page
                    view.fetch($target);
                }
            },
            /**
             * catch event add post to collection and add current page to model
             */
            addPost: function(post, col, options) {
                post.set('page', this.page);
            },
            /**
             * load more places
             */
            loadMore: function(e) {
                e.preventDefault();
                var view = this,
                    $target = $(e.currentTarget);
                view.page++;
                // collection fetch
                view.collection.fetch({
                    remove: false,
                    data: {
                        query: view.query,
                        page: view.page,
                        paged: view.page,
                        action: 'jb-fetch-posts',
                        paginate: true,
                        thumbnail: view.thumbnail,
                        text: $target.text()
                    },
                    // get the thumbnail size of post and send to server
                    thumbnail: view.thumbnail,
                    beforeSend: function() {
                        view.blockUi.block($target);
                        view.triggerMethod("before:loadMore");
                    },
                    success: function(result, res, xhr) {
                        view.blockUi.unblock();
                        view.$('.paginations-wrapper').html(res.paginate);
                        AE.pubsub.trigger('aeBlockControl:after:loadMore', result, res);
                        if (res.max_num_pages == view.page || !res.success) {
                            $target.parents('.paginations').hide();
                            $target.remove();
                        }
                        view.switchTo();
                        view.triggerMethod("after:loadMore", result, res);
                    }
                });
            },
            selectFilter: function(event) {
                var $target = $(event.currentTarget),
                    name = $target.attr('name'),
                    view = this;
                if (name !== 'undefined') {
                    view.query[name] = $target.val();
                    view.page = 1;
                    // fetch page
                    view.fetch($target);
                }
            },
            clickType : function(event){
                event.preventDefault();
                var $target = $(event.currentTarget),
                    name = $target.attr('data-name'),
                    type = $target.attr('data-type'),
                    view = this;
                if ($target.hasClass('active')) return;

                if(name !== 'undefined'){
                    view.$el.find('.click-type').parent().removeClass('active');
                    $target.parent().addClass('active');
                    /**
                     * set post_status arg to query
                     */
                    view.query[name] = type;
                    view.page = 1;
                    //fetch post
                    view.fetch($target);
                }
            },
            order: function(event) {
                event.preventDefault();
                var $target = $(event.currentTarget),
                    name = $target.attr('data-sort'),
                    view = this;
                if (name !== 'undefined') {
                    view.$('.orderby').removeClass('active');
                    $target.addClass('active');
                    /**
                     * set orderby arg to query
                     */
                    view.query['orderby'] = name;
                    view.page = 1;
                    // fetch post
                    view.fetch($target);
                }
            },
            /**
             * toggle view between grid and list
             */
            changeView: function(event) {
                var $target = $(event.currentTarget),
                    view = this;
                // return if target is active
                if ($target.hasClass('active')) return;
                // add class active to current targets
                this.$('.icon-view').removeClass('active');
                $target.addClass('active');
                // update view grid
                if ($target.hasClass('grid-style')) {
                    view.grid = 'grid';
                } else {
                    view.grid = 'list';
                }
                // switch view
                view.switchTo();
                view.triggerMethod("after:changeView", $target );
            },
            /**
             * filer range for budget
             */
            filterRange: function(event) {
                event.preventDefault();
                var view = this,
                    $target = $(event.currentTarget),
                    name = $target.attr('name');
                view.query[name] = $target.val();
                view.page = 1;
                view.fetch($target);
            },
            /**
             *
             */
            filterDate: function(event) {
                event.preventDefault();
                var view = this,
                    $target = $(event.currentTarget),
                    name = $target.attr('name');
                view.query[name] = $target.val();
                $(event.currentTarget).datepicker('hide');
                view.fetch($target);
            },
            /**
             * select a page in paginate
             */
            selectPage: function(event) {
                event.preventDefault();
                var $target = $(event.currentTarget),
                    page = parseInt($target.text().replace(/,/g, '')),
                    view = this;
                if ($target.hasClass('current') || $target.hasClass('next') || $target.hasClass('prev')) return;
                view.page = page;
                // fetch posts
                view.fetch($target);
                //scroll to block control id
                $('html, body').animate({
                    scrollTop: view.$el.offset().top - 180
                }, 800);
            },
            // prev page
            prev: function(event) {
                event.preventDefault();
                var $target = $(event.currentTarget),
                    view = this;
                // descrease page
                view.page--;
                // fetch posts
                view.fetch($target);
            },
            // next page
            next: function(event) {
                event.preventDefault();
                var $target = $(event.currentTarget),
                    view = this;
                // increase page
                view.page = view.page + 1;
                view.fetch($target);
            },
            // fetch post
            fetch: function($target) {
                var view = this,
                    page = view.page;
                // displayParams = this.makeQuery(params);
                // if(typeof this.router !== 'undefined') {
                //     this.router.navigate('!filter/aaaaaaa');
                //     console.log('router');
                // }before:selectPlan
                view.collection.fetch({
                    wait: true,
                    remove: true,
                    reset: true,
                    data: {
                        query: view.query,
                        page: view.page,
                        paged: view.page,
                        paginate: view.query.paginate,
                        thumbnail: view.thumbnail,
                    },
                    beforeSend: function() {
                        if($target.hasClass('multi-tax-item') || $target.hasClass('is-chosen')) {
                            $blockTarget = $target.next('.chosen-container');
                            view.blockUi.block($blockTarget);
                        } else {
                            view.blockUi.block($target);
                        }

                        view.triggerMethod("before:fetch");
                    },
                    success: function(result, res, xhr) {
                        view.blockUi.unblock();
                        // view.collection.reset();
                        if (res && !res.success) {
                            //view.$('.paginations').remove();
                            view.$('.paginations-wrapper').hide();
                            view.$('.paginations').remove();
                            view.$('.found_post').html(0);
                            view.$('.plural').addClass('hide');
                            view.$('.singular').removeClass('hide');
                        } else {
                            view.$('.paginations-wrapper').show();
                            view.$('.paginations-wrapper').html(res.paginate);
                            $('#place-status').html(res.status);
                            view.$('.found_post').html(res.total);
                            if (res.total > 1) {
                                view.$('.plural').removeClass('hide');
                                view.$('.singular').addClass('hide');
                            } else {
                                view.$('.plural').addClass('hide');
                                view.$('.singular').removeClass('hide');
                            }
                            view.switchTo();
                        }
                        view.triggerMethod("after:fetch", result, res, $target);
                    }
                });
            },
            /**
             * on model change update collection
             */
            onModelChange: function(model) {
                var post_status = model.get('post_status');
                if (post_status === 'archive' || post_status === 'reject' || 'post_status' == 'trash') {
                    if( typeof model.get('is_author') === 'undefined' || !model.get('is_author') ) {
                        this.collection.remove(model);
                    }
                }
            },
            /**
             * switch between grid and list
             */
            switchTo: function() {
                if (this.$('.list-option-filter').length == 0) return;
                var view = this;
                if (view.grid == 'grid') {
                    view.$('ul > li').addClass('col-md-3 col-xs-6').removeClass('col-md-12');
                    // view.$('ul > li').addClass('col-md-4').removeClass('col-md-12');
                    view.$('ul').removeClass('fullwidth');
                } else {
                    view.$('ul > li').removeClass('col-md-3 col-xs-6').addClass('col-md-12');
                    // view.$('ul > li').removeClass('col-md-4').addClass('col-md-12');
                    view.$('ul').addClass('fullwidth');
                }
            }
        });
        /**
         * blockui view
         * block an Dom Element with loading image
         */
        JB.Views.BlockUi = Backbone.View.extend({
            defaults: {
                image: jb_globals.imgURL + '/loading.gif',
                opacity: '0.5',
                background_position: 'center center',
                background_color: '#ffffff'
            },
            isLoading: false,
            initialize: function(options) {
                //var defaults = _.clone(this.defaults);
                options = _.extend(_.clone(this.defaults), options);
                var loadingImg = options.image;
                this.overlay = $('<div class="loading-blur loading"><div class="loading-overlay"></div><div class="loading-img"></div></div>');
                this.overlay.find('.loading-img').css({
                    'background-image': 'url(' + options.image + ')',
                    'background-position': options.background_position
                });
                this.overlay.find('.loading-overlay').css({
                    'opacity': options.opacity,
                    'filter': 'alpha(opacity=' + options.opacity * 100 + ')',
                    'background-color': options.background_color
                });
                this.$el.html(this.overlay);
                this.isLoading = false;
            },
            render: function() {
                this.$el.html(this.overlay);
                return this;
            },
            block: function(element, caption) {
                var $ele = $(element);
                // if ( $ele.css('position') !== 'absolute' || $ele.css('position') !== 'relative'){
                //         $ele.css('position', 'relative');
                // }
                this.overlay.css({
                    'position': 'absolute',
                    'z-index': 20000,
                    'top': $ele.offset().top,
                    'left': $ele.offset().left,
                    'width': $ele.outerWidth(),
                    'height': $ele.outerHeight()
                });
                this.isLoading = true;
                this.render().$el.show().appendTo($('body'));
                if(caption){
                    this.$el.find('.loading-img' ).text(caption);
                }
            },
            setMessage:function(message){
                if(this.$el){
                    this.$el.find('.loading-img' ).text(message);
                }
            },
            unblock: function() {
                this.$el.remove();
                this.isLoading = false;
            },
            finish: function() {
                this.$el.fadeOut(500, function() {
                    $(this).remove();
                });
                this.isLoading = false;
            }
        });
	});			
})(window.JB, jQuery, window.JB.Views, Backbone);