<?php if(!have_posts()) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1><?php _e( 'Not Found', "magazine-basic" ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'No results were found for your request.', "magazine-basic" ); ?></p>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php 
$x = 1;
if(is_home()) { 
	$options = get_option("widget_sideFeature");
 	$numberOf = $options['number'];
	$category = $options['category'];
	$category = "&cat=" . $category;
	$showposts = "posts_per_page=" . $numberOf . $category ;
	$featuredPosts = new WP_Query();
    $featuredPosts->query($showposts);
	while ($featuredPosts->have_posts()) : $featuredPosts->the_post(); 
		$notin[] = $post->ID;
	endwhile;
	
	$posts = theme_option('number_posts');
    if(empty($posts)) $posts = 6;
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if (is_active_widget('widget_myFeature')) {
        $args = array(
           'post__not_in'=>$notin,
           'posts_per_page'=>$posts,
           'paged'=>$paged
           );
    } else {
        $args = array(
           'posts_per_page'=>$posts,
           'paged'=>$paged
           );
    }       	
    query_posts($args);
	if(theme_option('latest_story')=="on" && $paged < 2) { echo '<h5 class="latest">'.__('Latest Story', "magazine-basic").'</h5>'; }
}
?>
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
	<h1 class="catheader"><?php single_cat_title(); ?></h1>
	<?php $catdesc = category_description(); if(stristr($catdesc,'<p>')) { echo '<div class="catdesc">'.$catdesc.'</div>'; } ?>   
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h1 class="catheader"><?php printf(__("Posts Tagged &#8216; %s &#8217;", "magazine-basic"), single_tag_title('',false)); ?></h1>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h1 class="catheader"><?php _e("Archive for ", "magazine-basic").the_time('F jS, Y'); ?></h1>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h1 class="catheader"><?php _e("Archive for ", "magazine-basic").the_time('F, Y'); ?></h1>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h1 class="catheader"><?php _e("Archive for ", "magazine-basic").the_time('Y'); ?></h1>
<?php /* If this is an author archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h1 class="catheader"><?php _e("Blog Archives", "magazine-basic"); ?></h1>
<?php } ?>

<?php 
if(is_search()) {
    $mySearch =& new WP_Query("s=$s & showposts=-1");
    $num = $mySearch->post_count;
    echo '<h1 class="catheader">'.$num. __(' search results for', "magazine-basic").' "'; the_search_query(); echo '"</h1>';
}
?>
<?php while ( have_posts() ) : the_post(); ?>
	<?php
	$optionlayout = theme_option('post_layout');
	$classes = '';
	$wordlimit = theme_option('excerpt_one');
	if($optionlayout==2 && $paged < 2 && is_home()) {
		if($x==2) { echo '<div id="twocol">'; $i=1; }
		if($x>1) {
			$classes = 'twopost twopost'; 
			if($i==5) { $i = 3; } 
			$classes .= $i; 
			$i++;
		}
		$wordlimit = theme_option('excerpt_two');
	}
	
	if($optionlayout==3 && $paged < 2 && is_home()) {
		if($x==2) { echo '<div id="twocol">'; $i=1; }
		if($x>1 && $x<4) {
			$classes = 'twopost twopost'; 
			if($i==5) { $i = 3; } 
			$classes .= $i; 
			$i++;
			$wordlimit = theme_option('excerpt_two');	
		}
		if($x==4) { echo '</div><div class="mainhr"></div><div id="threecol"><div id="threecol2">'; $i=1; }
		if($x>3) {
			$classes = 'threepost threepost'; 
			if($i==7) { $i = 4; }
			$classes .= $i; 
			$i++;
			$wordlimit = theme_option('excerpt_three');
		}
	}	

	if($optionlayout==4 && $paged < 2 && is_home()) {
		if($x==2) { echo '<div id="threecol"><div id="threecol2">'; $i=1; }
		if($x>1) {
			$classes = 'threepost threepost'; 
			if($i==7) { $i = 4; }
			$classes .= $i; 
			$i++;
			$wordlimit = theme_option('excerpt_three');
		}
	}
	?>
	<div id="post-<?php the_ID(); ?>" <?php post_class($classes); ?>>
		<?php 
		if(is_singular()) {
			if(function_exists('has_post_format') && has_post_format('aside')) { // new aside post format
				echo '<div class="entry">';
					the_content();
				echo '</div>';
			} else {
        		?>
<!--  ---------- Product Page Changes ----------- -->
                 <?php if (! $post->post_type == 'products-page') : ?>
                    <h1><?php the_title(); ?></h1>
                 <?php endif; ?>
               <?php
                echo '<div class="meta">';
                    if(theme_option('dates_posts')=='on'){echo '<div class="date">'; the_time(get_option('date_format')); echo '</div>';}
                    if(theme_option('authors_posts')=='on') {_e("By", "magazine-basic"); echo ' '; the_author_posts_link();}
                echo '</div>';
                echo '<div class="entry">';
//--------- Start plugin control ----------
                    $subtitle = get_post_meta($post->ID, 'subtitle', true);
                    if($subtitle) echo '<p class="sub">'.$subtitle.'</p>';

                    the_content(__('Read more &raquo;', "magazine-basic"));

                    wp_link_pages(array('before' => '<p><strong>'.__('Pages', "magazine-basic").':</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
                    the_tags(__('<p class="tags"><small><strong>Tags:</strong> ', "magazine-basic"), ', ', '</small></p>'); 
                echo '</div>';
			}
		} else { 
        	if(function_exists('has_post_format') && has_post_format('aside')) { // new aside post format
				echo '<div class="entry">';
					theme_excerpt($wordlimit);
				echo '</div>';
			} elseif(function_exists('has_post_format') && has_post_format('link')) { // new link post format
				echo '<div class="entry">';
					the_content(__('Read more &raquo;', "magazine-basic"));
				echo '</div>';
			} else {
				?>
				<h2><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', "magazine-basic" ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<?php
				echo '<div class="meta">';
				if(is_home()) {
					if(theme_option('authors_index') == 'on') { echo '<div class="date">'; the_time(get_option('date_format')); echo '</div>'; }
					if(theme_option('dates_index') == 'on') { _e("By", "magazine-basic"); echo ' '; the_author_posts_link(); }
				} else {
					if(theme_option('authors_cats') == 'on') { echo '<div class="date">'; the_time(get_option('date_format')); echo '</div>'; }
					if(theme_option('dates_cats') == 'on') { _e("By", "magazine-basic"); echo ' '; the_author_posts_link(); }
				}
				echo '</div>';
				echo '<div class="entry">';
				if(function_exists('has_post_format') && has_post_format('gallery')) { // new gallery post format
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
					if ( $images ) :
						$total_images = count( $images );
						$image = array_shift( $images );
						$image_img_tag = wp_get_attachment_image( $image->ID, 'full' );
					?>
					<a class="gallery-thumb" href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?></a>
					<p><em><?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, "magazine-basic" ),
							'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', "magazine-basic" ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
							number_format_i18n( $total_images )
						); ?></em>
					</p>
					<?php endif; ?>
					<?php 
				} else {
					if(function_exists('has_post_format') && (has_post_format('video') || has_post_format('image') || has_post_format('audio'))) { // new video || image || audio post format
                    	echo '<div class="pformat">';
						the_content(__('Read more &raquo;', "magazine-basic"));
						echo '</div>';
					} else {
						if(theme_option('excerpt_content')!=2) {
							if(function_exists('has_post_thumbnail') && has_post_thumbnail()) { 
								echo '<a href="'.get_permalink().'">';
								the_post_thumbnail('thumbnail', array('class' => 'alignleft'));
								echo '</a>';
							} else { 
								echo resize(get_option('thumbnail_size_w'),get_option('thumbnail_size_h')); 
							}
							theme_excerpt($wordlimit);
						} else {
							the_content(__('Read more &raquo;', "magazine-basic"));
						}
					}
				}
				echo '</div>';
			} 
		} 
		?>
	</div><!-- #post-## -->
      
   	<?php comments_template(); ?>
    <?php 
	$x++; // counter 
	?>   
<?php endwhile; ?>
<?php if(($optionlayout==2 || $optionlayout==3 || $optionlayout==4) && $x>1 && $paged < 2 && is_home()) echo '</div>'; ?>
<?php if($optionlayout==3 && $x>3 && $paged < 2 && is_home()) echo '</div>'; ?>
<?php if($optionlayout==4 && $x>1 && $paged < 2 && is_home()) echo '</div>'; ?>
<?php if(!is_single()) if(function_exists('pagination')) { pagination(); } ?>