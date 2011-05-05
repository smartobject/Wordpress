	</div>
    <?php
		$loc = theme_option('sidebar_location');
		if($loc==2 || $loc==4) {
			get_sidebar(); // calling the First Sidebar
		}
		if(theme_option('sidebar_width2')!=0 && $loc!=3) get_sidebar( "second" ); // calling the Second Sidebar
	?>
<!-- begin footer -->
<div id="footer" >
    <?php printf(__("Copyright &copy; %d", "magazine-basic"), '2010'); ?> <a href="<?php echo home_url(); ?>"> <?php _e(theme_option('footer_text'), "magazine-basic"); ?> </a> <?php _e("All Rights Reserved", "magazine-basic"); ?> <br />
    <span ><?php echo THEME_NAME; ?></span> <?php _e("theme designed by", "magazine-basic"); ?> <a href="http://themes.bavotasan.com"><span >Themes by bavotasan.com</span></a>.<br />
    <?php _e("Child Theme/Website Design by", "magazine-basic"); ?> <a href="http://www.sheltonresearch.com">Shelton Research Group</a>
</div>
<?php wp_footer(); ?>


<div class="portfolio" >
<ul>
   <li><a href="http://www.sheltonresearch.com/fun-stuff/website-design/">Memphis Website Design Options</a></li>
   <li><a href="http://www.sheltonresearch.com/memphis-business/free-website-listing">Free Memphis Website Listing</a></li>
   <li><a href="http://www.sheltonresearch.com/memphis-website-security/">Website Security Services</a></li>
   <li><a href="http://www.sheltonresearch.com/memphis-website-seo/">Issues With Search Engine Optimization</a></li>
</ul>
</div>

</div>  <!-- Mainwrapper -->


</body>
</html>