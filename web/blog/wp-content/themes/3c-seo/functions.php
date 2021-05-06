<?php

if ( function_exists('register_sidebars') )
	register_sidebars(2, array('name'=>'Sidebar %d'));

if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

function widget_ewt_search() {
?>
 <li id="search"><h4>Search Form</h4>
	<form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
	<div>
	<input type="text" name="s" id="s" size="15" />
	<input type="submit" value="Search" />
	</div>
    </form>
  </li>
<?php
}


function widget_ewt_subscribe() {
?>
 <li id="meta"><h4>Subscribe</h4>
 	<ul>
		<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/images/xml.gif" alt="XML" /></a> | <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>">Comments RSS</a></li>
		<li><a href="http://my.msn.com/addtomymsn.armx?id=rss&amp;ut=<?php bloginfo('rss2_url'); ?>&amp;ru=<?php bloginfo('rss2_url'); ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/images/addmymsn.gif" alt="Subscribe to MyMSN" align="middle" style="border: none;" /></a></li>
		<li><a href="http://add.my.yahoo.com/rss?url=<?php bloginfo('rss2_url'); ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/images/addmyyahoo.gif" alt="Subscribe to MyYahoo!" align="middle" style="border: none;" /></a></li>
		<li><a href="http://www.google.com/reader/preview/*/feed/<?php bloginfo('rss2_url'); ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/images/addgoogle.gif" alt="Subscribe to Google Reader" align="middle" style="border: none;" /></a></li>
		<li><a href="http://www.bloglines.com/sub/<?php bloginfo('rss2_url'); ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/images/addbloglines.gif" alt="Subscribe to Bloglines" align="middle" style="border: none;" /></a></li>
		<li><a href="http://www.newsgator.com/ngs/subscriber/subext.aspx?url=<?php bloginfo('rss2_url'); ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/images/addnewsgator.gif" alt="Subscribe to Newsgator" align="middle" style="border: none;" /></a></li>
		<li><a href="http://www.feedster.com/myfeedster.php?action=addrss&amp;rssurl=<?php bloginfo('rss2_url'); ?>&amp;confirm=no" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/images/addmyfeedster.gif" alt="Subscribe to Feedster" align="middle" style="border: none;" /></a></li>
		<li><a href="http://www.newsisfree.com/user/sub/?url=<?php bloginfo('rss2_url'); ?>" rel="nofollow"><img src="<?php bloginfo('template_directory'); ?>/images/addnewsisfree.gif" alt="Subscribe to NewsIsFree" align="middle" style="border: none;" /></a></li>
	</ul>
 </li>
<?php
}


function widget_ewt_5recent() {
?>
  <li id="latest"><h4>Latest Posts</h4>
	<ul><?php get_archives('postbypost','5'); ?></ul>
  </li>
<?php
}


function widget_ewt_15recent() {
?>
  <li id="latest"><h4>Latest Posts</h4>
	<ul><?php get_archives('postbypost','15'); ?></ul>
  </li>
<?php
}

function widget_ewt_authors() {
?>
 <li id="authors"><h4><?php _e('Authors'); ?></h4>
	<ul>
	<?php wp_list_authors('optioncount=1&exclude_admin=0'); ?>
	</ul>
 </li>
<?php
}

register_sidebar_widget(__('EWT Search'), 'widget_ewt_search');
register_sidebar_widget(__('EWT Subscribe'), 'widget_ewt_subscribe');
register_sidebar_widget(__('EWT 5 Recent Posts'), 'widget_ewt_5recent');
register_sidebar_widget(__('EWT 15 Recent Posts'), 'widget_ewt_15recent');
register_sidebar_widget(__('EWT Authors'), 'widget_ewt_authors');

?>