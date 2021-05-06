<?php
get_header();
?>

<table id="main">
<tr>
<td class="leftmenu"></td>
<td rowspan="2" class="content">

<h1>Ooops - something went wrong</h1>

<p>The page you are trying to access either doesn&acute;t exist or has been
moved to a different location. Maybe you just typed a wrong URL into your browser&acute;s
address bar or clicked on a link that is not valid anymore.</p>
<p>Go to the <a href="<?php bloginfo('url'); ?>">Homepage</a> of our blog and try
from there to find what you are looking for.</p>

</td> <!-- end main content cell -->
<td class="rightmenu"></td>
</tr>

<tr>

<?php get_sidebar(); ?>

</tr>
</table>

<?php get_footer(); ?>