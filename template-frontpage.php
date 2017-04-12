<?php
/* Template Name: Startseite */

get_header(); ?>
   
<div class="middle_wrap">
 <div id="map"></div>
 <div id="map_search" class="shadowdown">
    <form id="startsearch" enctype="application/x-www-form-urlencoded" method="get">
        <ul>
         	<li id="search_outdoor"><img src="/wp-content/themes/triperone/images/button_outdoor.png" alt="" width="40" height="40" />Outdoor &amp; Sport</li>
         	<li id="search_music"><img src="/wp-content/themes/triperone/images/button_music.png" alt="" width="40" height="40" />Fun &amp; Nightlife</li>
         	<li id="search_art"><img src="/wp-content/themes/triperone/images/button_art.png" alt="" width="40" height="40" />Art &amp; Design</li>
         	<li id="search_history"><img src="/wp-content/themes/triperone/images/button_architektur.png" alt="" width="40" height="40" />History &amp; Architecture</li>
         	<li id="search_cooking"><img src="/wp-content/themes/triperone/images/button_cooking.png" alt="" width="40" height="40" />Cooking &amp; Dining</li>
        </ul>
        <input id="search_city" class="text" maxlength="50" name="Region" type="text" value="" placeholder="City / Region" /><select name="personen">
        <option disabled="disabled" selected="selected" value="">Persons</option>
        <option value="1">1 person</option>
        <option value="2">2 persons</option>
        <option value="3">3 persons</option>
        <option value="4">4 persons</option>
        <option value="8">until 8 persons</option>
        </select>
        <input id="search_from" class="datum" type="text" placeholder="From" /><input id="search_to" class="datum" type="text" placeholder="To" /> <button id="search_today" type="button">Today</button> <button id="search_reset" type="button">Reset</button><button id="search_random" type="button">Quick Host</button>
    </form>
</div>
 
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