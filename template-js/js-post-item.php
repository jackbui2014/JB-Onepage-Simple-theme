<script type="text/template" id="post_item" class="post-item">
	<div class="image-avatar col-lg-4 col-md-4 col-sm-5 col-xs-12">
		<a href="{{= permalink }}">
			<img src="{{= the_post_thumbnail }}" alt="" class="img-responsive">
		</a>
	</div>
	<div class="info-items col-lg-8 col-md-8 col-sm-7 col-xs-12">
		<h2 class="post-title margin-bottom-20"><a href="{{= permalink }}">{{= post_title }}</a></h2>
		<p class="post-info margin-bottom-20">
			<i class="fa fa-user">{{= author_name }}</i>
			<i class="fa fa-calendar">{{= post_date }}</i>
			<i class="fa fa-comments-o">200</i><i class="fa fa-eye">3000	</i>
		</p>
		<div class="group-function">
			<p class="post-excerpt margin-bottom-20"><?php echo $current->post_excerpt; ?></p>
			<a href="{{= permalink }}" class="more"><?php _e('Read more', ET_DOMAIN); ?></a>
			<p class="total-comments">{{= comment_number }}</p>
		</div>
	</div>
</script>