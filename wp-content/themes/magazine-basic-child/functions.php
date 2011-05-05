<?php

// Set up Magazine Basic information
$bavotasan_theme_data = get_theme_data(TEMPLATEPATH.'/style.css');
define('THEME_FILE', "magazine-basic");
define('CHILD_DIR', get_stylesheet_directory_uri() ); 

// setting up the $child_values
// Setting up the theme options CSS
$child_values = get_option(THEME_FILE);
$child_gutter = 10;
if($child_values['site_width']) {
	$child_site = $child_values['site_width'];
	$child_sidebar = $child_values['sidebar_width1'];	
	$child_secondsidebar =  $child_values['sidebar_width2'];
	$child_sidewidget = $child_sidebar - $child_gutter;
	$child_sidewidget2 = $child_secondsidebar - $child_gutter;
	if(empty($child_secondsidebar)) {
		$child_content =  $child_site - $child_sidebar - ($child_gutter * 3);
	} else {
		$child_content =  $child_site - $child_sidebar - $child_secondsidebar - ($child_gutter * 4);		
	}
	update_option('child_content_width', $child_content);
} else {
	$child_site = 800;
	$child_sidebar = 180;
	$child_sidewidget = 160;
	$child_content = 560;
}

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = $child_content;

function child_header_css() {
	global $child_site, $child_sidebar, $child_secondsidebar, $child_sidewidget, $child_sidewidget2, $child_content, $child_gutter;
?>
<style type="text/css">
#header { background: url( <?php echo CHILD_DIR.'/images/header_bg.png) repeat-x' ; ?> ;}
#mainwrapper { width: <?php echo $child_site-($child_gutter/2); ?>px; }
#sidebar { width: <?php echo $child_sidebar; ?>px; }
#sidebar .side-widget { width: <?php echo $child_sidewidget; ?>px; }
<?php if(!empty($child_secondsidebar)) { ?>
#secondsidebar { width: <?php echo $child_secondsidebar; ?>px; }
#secondsidebar .side-widget { width: <?php echo $child_sidewidget2; ?>px; }
<?php } ?>
#leftcontent, #twocol, #threecol, #threecol2, .commentlist { width: <?php echo $child_content; ?>px; }
#leftcontent img, .wp-caption { max-width: <?php echo $child_content; ?>px; }
#leftcontent .wp-caption img, #leftcontent .gallery-thumb img { max-width: <?php echo $child_content-12; ?>px; }
<!-- fix for IE & Safari -->
.threepost embed { width: <?php echo ($child_content*.29); ?>px !important; }
.twopost embed { width: <?php echo ($child_content*.46); ?>px !important; }
<!-- end fix for Safari -->
</style>
<?php
}

?>