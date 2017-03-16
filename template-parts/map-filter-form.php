		
<div id="filterForm" class="closed">
    <h3 id="filterHeading">Filter Options</h3>
	<form class="" id="searchEventForm" enctype="application/x-www-form-urlencoded" method="get">
        <div class="flex flexWrap">
             <div id="filterOptionsLeft" class="flex flexColumn flexOne ">
                 <div id="searchCitySearchForm" class="flex flexColumn">
                    <label class="textLeft" for="filterPlaceInput">Place</label>
                    <input id="filterPlaceInput"  class="glowStyle" name="place" type="text"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Place'" placeholder="City, Region, Country"  aria-label="Use the arrow keys to pick a date">
                </div>
                <div id="searchDatePickerFromDiv" class="flex flexColumn">
                    <label class="textLeft" for="searchDatePickerFrom">Date Range</label>
                    <input   id="searchDatePickerFrom" class="glowStyle" name="searchDatePickerFrom" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'From'" placeholder="From" aria-label="Use the arrow keys to pick a date">
                </div>

                <div id="searchDatePickerToDiv" class="flex flexColumn">
                    <input   id="searchDatePickerTo"  class="glowStyle" name="searchDatePickerTo" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'To'" placeholder="To"aria-label="Use the arrow keys to pick a date">
                </div>
            </div>

        <!--	<div class="selectInspiration">
                <select id="selectCategorySearchForm" name="category" class="categorySelection cs-select cs-skin-elastic" multiple>
                        <option value="" disabled selected>Categories</option>
                        <option value="art-design">Art & Design</option>
                        <option value="cooking-dining">Cooking & Dining</option>
                        <option value="fun-nightlife">Fun & Nightlife</option>
                        <option value="history-architecture">History & Architecture</option>
                        <option value="outdoor-sport">Outdoor & Sport</option>
                </select>
            </div>-->

            <div id="filterCategoryChexboxes" class="flexOne">
                <p class="textLeft"><?php _e('Categories','triperone');?>: </p>
                <ul class="flex flexWrap flexColumn">
                    <li class="flexOne"><input type="checkbox" class="filterCategoryCheckbox" value="art-design, cooking-dining, fun-nightlife, history-architecture, outdoor-sport" id="filterCategoryCheckboxAll"><label for="filterCategoryCheckboxAll">All</label></li>
                    <li class="flexOne"><input type="checkbox" class="filterCategoryCheckbox" value="art-design" id="filterCategoryCheckboxArt"><label for="filterCategoryCheckboxArt"><?php _e('Art & Design','triperone');?></label></li>
                    <li class="flexOne"><input type="checkbox" class="filterCategoryCheckbox" value="cooking-dining" id="filterCategoryCheckboxCooking"><label for="filterCategoryCheckboxCooking"><?php _e('Cooking & Dinging','triperone');?></label></li>
                    <li class="flexOne"><input type="checkbox" class="filterCategoryCheckbox" value="fun-nightlife" id="filterCategoryCheckboxFun"><label for="filterCategoryCheckboxFun">Fun & Nightlife</label></li>
                    <li class="flexOne"><input type="checkbox" class="filterCategoryCheckbox" value="history-architecture" id="filterCategoryCheckboxHistory"><label for="filterCategoryCheckboxHistory"><?php _e('History & Architecture','triperone');?></label></li>
                    <li class="flexOne"><input type="checkbox" class="filterCategoryCheckbox" value="outdoor-sport" id="filterCategoryCheckboxOutdoor"><label for="filterCategoryCheckboxOutdoor"><?php _e('Outdoor & Sport ','triperone');?></label></li>
                </ul>

            </div>
        </div>
	
		<button type="button" id="cancelFilter" class="simpleButton">Close</button>
		<input  class="" id="submitSearchEventForm" type="submit" value="Filter">
	</form>
</div>	
	