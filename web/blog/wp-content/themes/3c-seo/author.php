<?php
get_header();
?>

<table id="main">
<tr>
<td class="leftmenu"></td>
<td rowspan="2" class="content">

<?php
if(get_query_var('author_name')) :
$curauth = get_userdatabylogin(get_query_var('author_name'));
else :
$curauth = get_userdata(get_query_var('author'));
endif;
?>

<h1>Author: <?php echo $curauth->nickname; ?></h1>
<p><b>Real Name:</b> <?php echo $curauth->first_name; ?> <?php echo $curauth->last_name; ?>
<p><b>Profile:</b> <?php echo $curauth->user_description; ?></p>
<p><b>Website:</b> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>

<h2>Posts by <?php echo $curauth->nickname; ?></h2>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php the_date('','<p>','</p>'); ?>

<div class="post">
	<h2 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<div class="meta"><?php _e("Filed under:"); ?> <?php the_category(',') ?> - <?php the_time('d M Y'); ?>
	</div>

	<div class="storycontent">
		<?php
		// the_content(__('(more...)'));
		the_excerpt_reloaded(40, '<a><p><img><br><br />', 'excerpt', true, 'Continue Reading...', false, 1, true);
		?>
	</div>


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
