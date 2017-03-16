

	
		
		<div id="newEventFormDiv" class="closed">
	
			<h3 id="newEventHeading">Add a new event</h3>
					<form enctype="multipart/form-data" id="newEventForm" >
                     
							<div class="formRow" id="newEventFormRow1">
									<div id="newEventPlaceDiv" class="formColumn">
									<label for="newEventPlace"><?php _e('Place','triperone');?><span class="required">*</span></label>
									<input  id="newEventPlace" class="glowStyle"  name="newEventPlace" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" placeholder="" type="text" aria-label="Use the arrow keys to pick a date">
								</div>
								<div id="newEventParticipantsDiv" class="formColumn">
									<label for="newEventParticipants"><?php _e('Participants (max)','triperone');?></label>
									<input  id="newEventParticipants" class="glowStyle"  name="newEventParticipants"  onfocus="this.placeholder = ''" onblur="this.placeholder = ''" placeholder="" type="number" aria-label="Use the arrow keys to pick a date" min="1">
								</div>
							</div>	
							<div class="formRow" id="newEventFormRow2">
								<div class="formColumn" id="eventSearchDateStartDiv">
									<label for="newEventDateStart"><?php _e('Date','triperone');?><span class="required">*</span></label>
									<input  id="newEventDateStart" class="glowStyle" name="newEventDateStart" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" placeholder=""  aria-label="Use the arrow keys to pick a date">
								</div>
								<div class="formColumn" id="eventSearchTimeStartDiv">
									<label for="newEventTimeStart"><?php _e('Time (hh:mm)','triperone');?><span class="required">*</span></label>
									<input  id="newEventTimeStart" class="glowStyle" name="newEventTimeStart" type="time" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" placeholder=""  aria-label="Use the arrow keys to pick a date">
								</div>
								<div id="newEventCategory" class="selectInspiration">
									<select id="newEventCategorySelection" name="newEventCategorySelection" class="categorySelection cs-select cs-skin-elastic">
											<option class="requiredstar" value="" disabled selected><?php _e('Categories','triperone');?><span class="required">*</span></option>
											<option value="art-design"><?php _e('Art & Design','triperone');?></option>
											<option value="cooking-dining"><?php _e('Cooking & Dining','triperone');?></option>
											<option value="fun-nightlife"><?php _e('Fun & Nightlife','triperone');?></option>
											<option value="history-architecture"><?php _e('History & Architecture','triperone');?></option>
											<option value="outdoor-sport"><?php _e('Outdoor & Sport','triperone');?></option>
									</select>
								</div>
							</div>
							<!--
							<label for="newEventTimeTill">Till: 00:00</label>
							<input  id="newEventTimeTill" class="glowStyle" name="newEventTimeTill" type="time" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" placeholder=""  aria-label="Use the arrow keys to pick a date">-->
							
							<label for="newEventTitle"><?php _e('Title','triperone');?><span class="required">*</span></label>
							<input class="glowStyle"  name="newEventTitle" id="newEventTitle" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" placeholder="" type="text"></input>
						
							<label for="newEventDescription"><?php _e('Description','triperone');?><span class="required">*</span></label>
							<textarea  class="glowStyle"  name="newEventDescription" id="newEventDescription" onfocus="this.placeholder = ''" onblur="this.placeholder = ''" placeholder="" cols="30" rows="5"></textarea>
							<div id="newEventImageDiv" class="flex justifyStart">
								<label for="image-input"><?php _e('Upload an image: ','triperone');?></label> 
								<input name="image-input" id="image-input" type="file"> 
							</div>
							<div id="newEventindexTabNavi">
								<button id="cancelNewEvent" class="simpleButton" type="button">Cancel</button>
								<input id="newEventSubmit"  class="simpleButton" type="submit" value="Submit">
							</div>
					</form>
					<form name="image-form" id="image-form"> 
					

					</form> 
					
					
					<p id="newEventFormMessage"></p>
			</div>
