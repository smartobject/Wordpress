<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<?php if(theme_option('seo')!=2) { // New SEO options ?>
<?php if((is_home() && ($paged < 2 )) || is_single() || is_page()) { echo '<meta name="robots" content="index,follow" />'; } else { echo '<meta name="robots" content="noindex,follow" />'; } ?>

<?php if (is_single() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<meta name="description" content="<?php metaDesc(); ?>" />
<?php csv_tags(); ?>
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="<?php if(theme_option('site_description')) { echo trim(stripslashes(theme_option('site_description'))); } else { bloginfo('description'); } ?>" />

<?php endif; ?>
<?php } // end SEO options ?>
<title><? php wp_title(''); ?> </title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php child_header_css(); ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php echo THEME_URL; ?>/iestyles.css" />
<![endif]-->
<?php if(is_singular() && get_option('thread_comments')) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_enqueue_script('effects'); ?>
<?php wp_head(); ?>
<?php if(theme_option('google_analytics')) { echo stripslashes(theme_option('google_analytics')); } ?>

<script type="text/javascript" >
  var searchText = "Search..."; 

  function clearSearch(){
   var el = document.getElementById('s'); 

    if (el) {
    if (el.value==searchText) {
       el.value = '';
     }
  else
    if (el.value=='') {
       el.value = searchText;
     }
   }  // if el 
  }

</script>


</head>

<body <?php body_class(); ?>  onload="clearSearch();" >



<div id="mainwrapper">

<!-- begin header -->
<div id="header">
	<?php
    $headeralign = theme_option('logo_location');
	if($headeralign=="fl") $adfloat = ' class="fr"';
	if($headeralign=="fr") $adfloat = ' class="fl"';
	if($headeralign=="aligncenter") $adfloat = ' class="aligncenter"';
	$float = ' class="'.$headeralign.'"';
    ?>
	<?php if (theme_option('user_login') != "2") { ?>
	<div id="login">
    	<?php
			global $user_identity, $user_level;
			if (is_user_logged_in()) { ?>
            	<ul>
                <li><span style="float:left;"><?php _e("Logged in as:", "magazine-basic"); ?><strong> <?php echo $user_identity ?></strong></span></li>
				<li><a href="<?php echo admin_url(); ?>"><?php _e("Control Panel", "magazine-basic"); ?></a></li>
                <?php if ( $user_level >= 1 ) { ?>
                	<li class="dot"><a href="<?php echo admin_url('post-new.php'); ?>"><?php _e("Write", "magazine-basic"); ?></a></li>
				<?php } ?>
                <li class="dot"><a href="<?php echo admin_url('profile.php'); ?>"><?php _e("Profile", "magazine-basic"); ?></a></li>
				<li class="dot"><a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('Log Out', "magazine-basic") ?>"><?php _e('Log Out', "magazine-basic"); ?></a></li>
                </ul>
            <?php 
			} else {
				echo '<ul>';
				echo '<li><a href="'.wp_login_url( get_permalink() ).'">'.__('Log In', "magazine-basic").'</a></li>';
				if (get_option('users_can_register')) { ?>
					<li class="dot"><a href="<?php echo site_url('wp-login.php?action=register', 'login') ?>"><?php _e('Register', "magazine-basic") ?></a> </li>
                
            <?php 
				}
				echo "</ul>";
			} ?> 
    </div>
    <?php } ?>
    <?php if(theme_option('header_ad') == 'on') { ?>
		<?php if(theme_option('headerad_img')) { ?>
            <div id="headerad"<?php echo $adfloat; ?>>
                <a href="<?php echo theme_option('headerad_link'); ?>"><img src="<?php echo theme_option('headerad_img'); ?>" alt="" /></a>
            </div>
        <?php } else { ?>
            <div id="headerad"<?php echo $adfloat; ?>>
                <a href="http://themes.bavotasan.com"><img src="<?php echo THEME_URL; ?>/images/topbanner.png" alt="Themes by bavotasan.com" /></a>
            </div>
        <?php } ?>
    <?php } ?>
	<?php if(theme_option('logo_header')) { ?>
    	<a href="<?php echo home_url(); ?>/" class="headerimage"><img width="200" src="<?php echo theme_option('logo_header'); ?>" alt="Memphis Website Design"<?php echo $float; ?> /></a>
    <?php } else { ?>
    <div id="title"<?php echo $float; ?>>
    	<?php if(is_singular()) echo '<h2>'; else echo '<h1>'; ?><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> <?php if(is_singular()) echo '</h2>'; else echo '</h1>'; ?>    
    </div>
    <?php } ?>
    <div id="home" >
            <div id="topsearch"> 
                  <form method="get" action="" id="searchForm">
                   <div>
	             <input type="text" value="" name="s" id="s"  onfocus="clearSearch();" onblur="clearSearch();" /> 
                   </div>
                  </form> 
            </div>  <!-- topsearch --> 
         <a href="<?php echo home_url(); ?>/">
        <h1><?php bloginfo('name'); ?></h1>
        </a>
       <h2><?php bloginfo('description'); ?></h2>
    </div>     

    <?php
wp_nav_menu( array( 
    'menu' => 'MainMenu', 
    'container_class' => 'main-navigation', 
    'depth' => 3, 
    'menu_class' => 'sf-menu',
    'show_home' => false 
) );
?>

</div>
<!-- end header -->



<?php
	$loc = theme_option('sidebar_location');
	if($loc==1 || $loc==3 || $loc==5) {
		get_sidebar(); // calling the First Sidebar
	}
	if($loc==3) get_sidebar( "second" );
	?>
	<div id="leftcontent">
