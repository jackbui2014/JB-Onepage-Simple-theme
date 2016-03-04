/**
 * This file containt general element for wish section
 * @author nguyenvanduocit
 */
(
	function ( Views, Models, $, Marionette, Backbone, Collections ) {
		$( document ).ready( function () {
				Views.Installer = Marionette.View.extend( {
					ui: {
						adminmenuwrap: '#adminmenuwrap',
						adminmenuback: '#adminmenuback',
						wpadminbar: '#wpadminbar',
						wpcontent: '#wpcontent',
						wpbody_content:"#wpbody-content",
						step_name:'.step_name',
						percent:'.arrow3'
					},
					events: _.extend( {
						'click .site-open-button': 'togglePanel'
					}, Backbone.Marionette.View.prototype.events ),
					initialize: function ( options ) {
						this.options = _.extend( this, options );
						Backbone.Marionette.View.prototype.initialize.apply(options);

						this.$wpbody_content = $(this.ui.wpbody_content);
						//This line must be call before initContent().
						this.next_step = JSON.parse($('#we_install_first_step' ).html());
						//This line will be clean the $el and replace with template
						//Use for fast access
						this.$step_name = $(this.ui.step_name);
						this.$percent = $(this.ui.percent);
						//Start the installer
						this.startInstall(this.next_step);
					},
					startInstall:function(step){
						var view=this;
						var params = {
							url: ae_globals.ajaxURL,
							type: 'post',
							data: {
								action: 'installer-request',
								installer_action:installer_action, //this var was print in install page content
								step: step.step
							},
							beforeSend: function () {
								var name = step.name;
								view.$step_name.html(step.name);
							},
							success: function ( resp ) {
								if(resp.success){
									view.$percent.css('right', (100 - resp.percent) + "%");
									if(resp.is_final_step){
										setTimeout(function(){
											view.$step_name.html(resp.msg);
											document.location.href = resp.redirect;
										}, 500)
									}
									else{
										if(typeof resp.inputs != 'undefined')
										{
											console.log(resp.inputs);
											view.setupForm(resp.inputs);
											//view.startInstall( view.next_step );
										}
										else {
											view.next_step = resp.next_step;
											view.startInstall( resp.next_step );
										}
									}
								}
								else
								{
									view.$step_name.html(resp.msg);
								}
							}
						}
						$.ajax( params );
					},
					setupForm:function(inputs){
						var view = this;
						if(typeof view.input_template == 'undefined' ){
							view.input_template = $('#we_install_input' ).html();
						}
						if(typeof view.input_form =='undefined')
						{
							view.input_form = $('#input_form');
						}
						console.log(view.input_template);
						_.each(inputs, function(input){
							view.input_form.append( _.template(view.input_template, input));
						});
					}
				});
			var installer = new Views.Installer( {
				el: 'body'
			} );
		} );
	}
)( AE.Views, AE.Models, jQuery, Backbone.Marionette, Backbone, AE.Collections );