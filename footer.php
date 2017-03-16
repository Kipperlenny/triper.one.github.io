<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package triperone
 */

?>
<!-- <script src="<?php  echo get_template_directory_uri() ?>/js/map.js"></script>-->	
 
<!--<script type="text/javascript"  src="<?php echo get_template_directory_uri() ?>/js/index.js"></script>
-->
<?php if (!is_user_logged_in() && is_page('landing-page')){ ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'triperone' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'triperone' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'triperone' ), 'triperone', '<a href="https://automattic.com/" rel="designer">Tech Nomad</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->
<?php  } ?>
<?php wp_footer(); ?>

<!--selectinspiration-->
<script>
    //callback function for select element inside filter form
    function onChangeFilterCategorySelection(el){
        // el === selection value
        console.log(el);
    }
    
    //callback function for select element inside new event form
    function onChangeNewEventCategorySelection(el){
        // el === selection value
        console.log(el);
    }
    
    // "select inspiration" init 
    (function() {

        var newEventCategorySelection = document.getElementById("newEventCategorySelection");
        new SelectFx(newEventCategorySelection,{onChange:onChangeNewEventCategorySelection});
    })();
</script>


<!--pikaday-->

<script>
    var pickerStart = new Pikaday({ field: document.getElementById('searchDatePickerTo') });
    var pickerEnd = new Pikaday({ field: document.getElementById('searchDatePickerFrom') });
    var newEventDateStart = new Pikaday({ field: document.getElementById('newEventDateStart') });
</script>
	


	<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  // tracker methods like "setCustomDimension" should be called before "trackPageView"
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//piwik.tech-nomad.de/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '6']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//piwik.tech-nomad.de/piwik.php?idsite=6&rec=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
</body>
</html>
