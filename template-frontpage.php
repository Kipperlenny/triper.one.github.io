<?php
/* Template Name: Startseite */

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
} ?>
				
</div><!-- #content -->	
	
<?php  get_footer(); ?>