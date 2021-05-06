<td class="leftmenu">
<div class="nav">
<ul>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

<!-- Main Navigation -->
 <li><h4><?php _e('Main Navigation'); ?></h4>
	<ul>
	<!-- <li><a href="YourDomain">Homepage</a></li> -->
	<li><a href="<?php bloginfo('url') ?>">Blog Index</a></li>
	</ul>
 </li>


<!-- The Categories -->
 <li id="categories"><h4><?php _e('Categories'); ?></h4>
	<ul>
	<?php wp_list_cats(); ?>
	</ul>
 </li>


<!-- The Pages -->
<?php wp_list_pages('title_li=<h4>Pages</h4>' ); ?>







<?php endif; ?>
</ul>

</div>
</td>

<td class="rightmenu">
<div class="nav">

<ul>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>


<!-- The Search Box  -->
 <li id="search"><h4><?php _e('Search Form'); ?></h4>
   <form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
	<div>
		<input type="text" name="s" id="s" size="15" /><br />
		<input type="submit" name="submit" value="<?php _e('Search'); ?>" />
	</div>
	</form>
 </li>





<!-- Latest Posts -->
	<li><h4>Latest Posts</h4>
	<ul><?php get_archives('postbypost','10'); ?></ul>
	</li>


<?php endif; ?>
</ul>

</div>
</td>
