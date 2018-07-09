jQuery(document).ready(function(){

	var showcases = jQuery('[id^=tshowcase_id_]');
	showcases.each(function(){
		var selects = jQuery(this).find('.ts-dropdown-filter-nav');
		selects.find('select').each(function(){
			jQuery(this).on('change',function(){
				var chosen = '';
				selects.find('option:selected').each(function() {
					if(jQuery(this).val()!='ts-all'){
						chosen += '.'+jQuery(this).val();
					}
    			});

				if(chosen.length == 0){
					chosen = '.ts-all';
				}
				console.log(chosen);
    			ts_show(chosen);
			});
		});
	});


});


//FILTER CODE
function ts_show(category) {	 

	console.log(category);
	
	if (category == ".ts-all") {
        jQuery('.tshowcase-filter-active').show(1600,'easeInOutExpo');
		}
	
	else {
		
		jQuery(category).show(1600,'easeInOutExpo');
		jQuery('.tshowcase-filter-active:not('+ category+')').hide(1000,'easeInOutExpo');

		//to display first entry on pager layouts
		jQuery('.tshowcase-pager-wrap ' + category + ' a').click();
			
	}

	
}

//Transform Dropdown into inline options 
/*
jQuery('.ts-dropdown-filter-nav').prepend('<div id="ts_inline_menu"></div>');
jQuery('#tsdropdown-dtaxonomy').hide().find('option').each(function(index, element){

	if(index>0){

		var letter = jQuery('<div>');
		letter.addClass('ts-letter');
		var opt = jQuery(this);
		letter.html(opt.html()).on('click',function(){
			if(jQuery(this).hasClass('ts-selected-letter')){
				jQuery('#ts_inline_menu div').removeClass('ts-selected-letter');
				jQuery('#tsdropdown-dtaxonomy').val('*').change();
			} else {
				jQuery('#ts_inline_menu div').removeClass('ts-selected-letter');
				jQuery(this).addClass('ts-selected-letter');
				jQuery('#tsdropdown-dtaxonomy').val(opt.attr('value')).change();
			}
			
		});
		var lettercontainer = jQuery('<div>').addClass('ts-letter-container').html('<div class="ts-letter-divider"> | </div>').append(letter);
		jQuery('#ts_inline_menu').append(lettercontainer);
	}
});
*/
