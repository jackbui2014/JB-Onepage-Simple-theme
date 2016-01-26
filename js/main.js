(function(JB, $, Views, Backbone) {
	$(document).ready(function(){
		var PostItem = Views.PostItem.extend({
			tagName: 'li',
			className : 'post-item',
			template: _.template($('#post_item').html()),
			initialize: function ( options ) {
				this.options = _.extend( this, options );							
			}
		});		
		var ListPost = Views.ListPost.extend({
            tagName: 'ul',
            childView: PostItem,
            itemClass: 'post-item'
        });
        if ( $('.post_container #post_data').length > 0) {
            var postdata = JSON.parse($('.post_container #post_data').html()),
            collection = new JB.Collections.Posts(postdata);
        }else {
            var collection = new JB.Collections.Posts();
        }               
        list = new ListPost({
                childView: PostItem,
                collection: collection,
                el: $('.list_post')
            });
        list.render();
		var front = Backbone.View.extend({
			el: 'body',
			model: [],
			events: {
				
			},
			initialize: function(){
				//JB.pubsub.on('jb:upload:success', this.process, this);						
				JB.pubsub.on('jb:model:onEdit', this.editPost, this);
				JB.pubsub.on('jb:editImage:success', this.editImage, this);
				this.initScroll();
			},
			process: function(attachment, options){
				console.log(attachment);
				console.log(options);
			},
			filterPost: function(model){
				this.model.set('post_title', model.get('blogTitle'));				
			},
			editPost: function(model, target){
				var view = this;				
				view.model = model;
				console.log(target);
				//if( typeof inlineEditor !== 'undefined' ){
					var inlineEditor = new Views.inlineEditor({
						el: target,
						model: view.model

					});
				//}
				//if( typeof file_uploader !== 'undefined' ){
					var file_uploader = new Views.File_Uploader({
						el: target,						
						model: view.model,
						type: 'post'
					});	
				//}
			},
			initScroll: function(){
				$('.nav-scroll').find('a').attr('data-scroll', '');
				smoothScroll.init({
					speed: 1000,
					easing: 'easeInOutCubic',
					offset: 0,
					updateURL: true,
					callbackBefore: function ( toggle, anchor ) {},
					callbackAfter: function ( toggle, anchor ) {}
				});
			}
		});
		new front();

	});			
})(window.JB, jQuery, window.JB.Views, Backbone);