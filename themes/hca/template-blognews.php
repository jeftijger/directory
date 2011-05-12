<?php
/*
Template Name: blog news
*/
?>

<?php get_header() ?>
<?php locate_template( array( '/includes/components/sectionheaders.php' ), true ); ?>
<div id="content-wrapper">
<div id="content"><!-- start #content -->
	<div class="padder">
		<div class="page" id="blog-latest"><!-- start #blog-latest -->
			<?php wpmu_blogpageloop(); ?>
			<?php locate_template( array( '/includes/components/pagination.php' ), true ); ?>
		</div><!-- end #blog-latest -->
	</div>
</div><!-- end #content -->
<div id="sidebar">
	Vestibulum mollis mauris enim. Morbi euismod magna ac lorem rutrum elementum. Donec viverra auctor lobortis. Pellentesque eu est a nulla placerat dignissim. Morbi a enim in magna semper bibendum. Etiam scelerisque, nunc ac egestas consequat, odio nibh euismod nulla, eget auctor orci nibh vel nisi. Aliquam erat volutpat. Mauris vel neque sit amet nunc gravida congue sed sit amet.
</div>
<div class="clear"></div>
</div>
<?php get_footer(); ?>