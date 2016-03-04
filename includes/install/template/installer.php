
<section id="loading" class="installer_page">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">
				<div class="loadingContent all_bg font-playfair ">
					<h3 class="ourstory-title pull-left width-100p mg-t--15">
						<span class="color-mandy "><span class="dropcaps-first-1x5">W</span>edding<span class="dropcaps-first-1x5">E</span>ngine</span>
						<span class="color-waikawa_gray "><span class="dropcaps-first-1x5">I</span>nstaller</span>
					</h3>
					<div class="install-progress-bar">
						<span class="text-arrow"><i class="fa fa-refresh fa-spin"></i>&nbsp;<span class="step_name"></span></span>
						<svg version="1.1" id="Layer_1" x="0px" y="0px" width="310px" height="60px" viewBox="0 0 310 60" enable-background="new 0 0 310 60" xml:space="preserve">
                            <polygon class="bg_arrow01" points="310,60 0,60 0,0 310,0 290,30.4 "></polygon>
                        </svg>
						<div class="arrow3">
							<svg version="1.1" id="Layer_4" x="0px" y="0px" width="310px" height="60px" viewBox="0 0 310 60" enable-background="new 0 0 310 60" xml:space="preserve">
                            <polygon class="bg_arrow02" points="310,60 0,60 0,0 310,0 290,30.4 "></polygon>
                        </svg>
						</div>
					</div>
					<div class="bg_loading all_bg "></div>

				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/template" id="we_install_input">
	<#
		var tag_name = 'input';
		switch(type){
		case 'text':
		case 'email':
		case 'password':
		tag_name = 'input'
		}
		#>
		<div class="form-group">
			<div class="col-sm-6 controls mb-0">
				<label class="control-label">Bride's name</label>
				<{{=tag_name}} name="bride_name" type="text" class=""></{{=tag_name}}>
		</div>
		</div>
</script>