<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package triperone
 */


get_header(); ?>
   
   
   
   <div class="middle_wrap">
<div id="map"></div>
 
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKw_vf18b0Ob0jHat29pK73OUAce48B7I&callback=initMap&libraries=places"
    async defer></script>-->


        <!-- old api-key
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7AqZ1vhsMI4OvKSXXHAxUm29vlrBG3Zo&callback=initMap&libraries=places">
</script>-->
    


   




<?php  
if(is_user_logged_in()){
	get_template_part('template-parts/user','main'); 
}
?>
				
	</div><!-- #content -->	
	
<?php  get_footer(); ?>