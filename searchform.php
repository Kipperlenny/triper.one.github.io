<form method="get" class="searchform themeform" action="<?php echo home_url(); ?>">
	<div>
		<input type="text" class="search" name="s" onblur="if(this.value=='')this.value='<?php _e('Search and hit Enter','triperone'); ?>';" onfocus="if(this.value=='<?php _e('Search and hit Enter','hueman'); ?>')this.value='';" value="<?php _e('Search and hit Enter','triperone'); ?>" />
	</div>
</form>