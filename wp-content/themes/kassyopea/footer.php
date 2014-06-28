    <?php 
		global $actual_font, $font, $wp_query, $actual_font;
		
		$tmp_query = $wp_query;
		
		get_template_part( 'footer', get_option( 'bl_footer_type', 'big' ) ); 
		
		$wp_query = $tmp_query;
		
		wp_reset_postdata();
		
		wp_footer(); 
	?>                     
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39947818-1', 'downtoearth-tx.com');
  ga('send', 'pageview');

</script>
    <script type="text/javascript">                

    	<?php if( get_post_meta( get_current_ID(), '_slider_accordion_show', true ) ) : ?>
		jQuery(document).ready(function($) {                                               
			$(".accordion-slider").hrzAccordion({
				<?php do_action( 'yiw_add_accordion_team_option' ) ?>
				openOnLoad		   : 1,
				handlePosition     : "left",
				completeAction	   : function() {<?php if( $actual_font != 'none' ) : ?>
					Cufon.replace('.accordion-slider h5', {fontFamily: '<?php echo $actual_font ?>', fontSize: '<?php echo get_fontsize( $actual_font, 'h5' ) ?>px'});   
					Cufon.replace('ul.accordion-slider p.profile', 	{fontFamily: '<?php echo $actual_font ?>', fontSize: '<?php echo get_fontsize( $actual_font, 'profile-slider' ) ?>px'});       
				<?php endif ?>}
// 		 		containerClass     : "AccordionContainer",
// 		 		listItemClass      : "ListItem",					
// 		 		contentWrapper     : "AccordionWrap",
// 		 		contentInnerWrapper: "AccordionInnerWrap"
		//  		handleClass        : "Handle",
		//  		handleClassOver    : "HandleOver",
		//  		handleClassSelected: "HandleSelected"
			});
		});
		<?php endif; ?>       
        
        jQuery(document).ready(function($){
            $("a[rel^='prettyPhoto']").prettyPhoto({
                theme: '<?php echo get_option('bl_portfolio_skin_lightbox', 'pp_default') ?>'});
        });
    </script>           
    
    <?php if( $actual_font != 'default' ) : ?>
    <script type="text/javascript">   
        //<![CDATA[
        Cufon.now();  //]]>   
    </script> 
    <?php endif ?>
    
    <?php option_theme('bl_ga_code') ?>
</body>

</html>