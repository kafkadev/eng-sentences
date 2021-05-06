<?php
get_header();
?>

<table id="main">
<tr>
<td class="leftmenu"></td>
<td rowspan="2" class="content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="post">
	<h1><?php the_title(); ?></h1>

	<div class="storycontent">
		<?php the_content(); ?>
	</div><!-- end STORYCONTENT -->




</div>


<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>

<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?>

</td>
<td class="rightmenu"></td>
</tr>

<tr>

<?php get_sidebar(); ?>

</tr>
</table>

<?php get_footer(); ?>
