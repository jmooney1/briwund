jQuery.noConflict();
jQuery(document).ready(function() {
    tshowcase_enhance_filter_process();
});
jQuery(document).ajaxSuccess(function() {
    tshowcase_enhance_filter_process();
});

function tshowcase_enhance_filter_process() {

    jQuery("div[id*='tshowcase_id_']").each(function(index) {

    		var container = jQuery(this);

            //finds all menus and adds the current class to 'all' option
		    var menuscontainer = jQuery(this).find('.ts-enhance-filter-nav');
		    var menus = menuscontainer.children('ul');
		    
		    //searchs for all li entries and set the onclick
		    menus.each(function(){

		      var thismenu = jQuery(this);
		      
		      if(thismenu.find('.ts-current-li').length==0){
		          thismenu.find('li.ts-all').addClass('ts-current-li');
		      }
		      
		      //main options
		      thismenu.children('li').on('click',function(){

		          thismenu.find('li').removeClass('ts-current-li');
		          jQuery(this).addClass('ts-current-li');

		          var filterValue = '';
		          menuscontainer.find('.ts-current-li').each(function(){
		              var val = jQuery(this).attr('data-filter');
		              if(val!='*') {
		                filterValue += val;
		              }
		           });

		           if(filterValue == ''){
		              filterValue = '*';
		           }

		           //stop propagation
		           jQuery(this).children('ul').click(function(e) {
		                e.stopPropagation();
		           });

		           console.log(filterValue);
		           ts_show_enhance(filterValue, container);
		      });

		      //submenus
		      thismenu.find('li > ul > li').on('click',function(){

		          thismenu.find('li').removeClass('ts-current-li');
		          
		          jQuery(this).addClass('ts-current-li');

		          var filterValue = '';
		          menuscontainer.find('.ts-current-li').each(function(){
		              var val = jQuery(this).attr('data-filter');
		              if(val!='*') {
		                filterValue += val;
		              }
		           });

		           if(filterValue == ''){
		              filterValue = '*';
		           }

		           //stop propagation
		           jQuery(this).parent().parent().click(function(e) {
		                e.stopPropagation();
		           });

		           //add to parent the current li style only after filter ran
		           jQuery(this).parent().parent().addClass('ts-current-li');

		           console.log(filterValue);
		           ts_show_enhance(filterValue, container);
		      });
		    
		    });

            

            //Load specific category via url hash

            var start_filter = ts_get_hash()["show"];
            if (start_filter != '') {
                jQuery('#' + start_filter).click();

            }
        });

    }


    //In case you want all entries to hide when the page loads
    //jQuery('.ts-05_project-5').hide();	
    //To load a particular category
    //jQuery('#ts-01-sales-team').click();
    //jQuery('#ts-id-3').click();

    

    //FILTER CODE
    function ts_show_enhance(selector, container) {

        console.log(selector);

        if (selector == "*") {
        	container.find('.tshowcase-filter-active').addClass('ts-current').removeClass('ts-not-current');
        } else {

			container.find(selector).addClass('ts-current').removeClass('ts-not-current'); 
			container.find('.tshowcase-filter-active:not('+ selector +')').addClass('ts-not-current').removeClass('ts-current');

			//to display first entry on pager layouts
            container.find('.tshowcase-pager-thumbnail'+selector+' a').click();
        }

        //hack to solve menu left open on touch devices
        /*

        	jQuery('ul li ul li.ts-current-li')
        	.parent()
        	.hide()
        	.parent()
        	.on('click', function(){ 
        		jQuery(this).addClass('ts-current-li')
        		.children().show(); 
        	});

        */
    }




    function ts_get_hash() {
        var vars = [],
            hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('#') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

