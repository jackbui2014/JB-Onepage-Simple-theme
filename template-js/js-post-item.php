<script type="text/template" id="post_item" class="post-item">
<a class="action" data-action="edit" href="#" >edit</a>
	<# if(the_post_thumnail) { #>
	<div class="jb_uploader_container">
	<a href="#" class="img-place jb_uploader_button" title="{{= post_title }}">
	    <img src="{{= the_post_thumnail }}">
	</a>
	</div>
	<# } #>
	  <h1 class="jb_text_editor" data-name="post_title">{{= post_title }}</h1>
	  <div class="jb_text_editor" data-name="post_content" data-type="textarea">{{= post_content }}</div>
</script>