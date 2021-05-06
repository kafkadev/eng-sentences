<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php require_once get_template_directory()."/theme_functions.php"; ?>
<head profile="http://gmpg.org/xfn/11">

	<title><?php if ( is_single() ) { wp_title(' '); } else { bloginfo('name'); wp_title(); }?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>
  <!--

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
-->
	<?php wp_head(); ?>
</head>

<body>

<div id="wrapper">
<div id="header">
<p>
<span class="blogname"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></span><br />
<span class="blogslogan"><?php bloginfo('description'); ?></span>
</p>
</div>
