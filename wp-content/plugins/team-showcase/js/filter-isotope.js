jQuery( window ).ready( function() {
  ts_isotope_process();
});

jQuery(document).ajaxSuccess(function() { 
  ts_isotope_process();
});

function ts_isotope_process(elmts) {

  var container = [];

  jQuery( "div[id*='tshowcase_id_']" ).each(function( index ) {
    
    // init Isotope
    container[index] = jQuery(this).find('.tshowcase-isotope-wrap').isotope({
      itemSelector: '.tshowcase-isotope',
      layoutMode: 'fitRows', 
      });

    // init Isotope

    // layout Isotope after each image loads
    container[index].imagesLoaded().progress( function() {
      container[index].isotope('layout');
    });

    //finds all menus and adds the current class to 'all' option
    var menuscontainer = jQuery(this).find('.ts-isotope-filter-nav');
    var menus = menuscontainer.children('ul');
    
    //searchs for all li entries and set the onclick
    menus.each(function(){

      var thismenu = jQuery(this);

      if(thismenu.find('.ts-current-li').length==0){
          thismenu.find('li.ts-all').addClass('ts-current-li');
      }
      
      //main options
      thismenu.children('li').on('click',function(ev){

          ev.stopPropagation();

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
           container[index].isotope({ filter: filterValue });

      });

      //submenus
      thismenu.find('li > ul > li').on('click',function(ev){

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
           container[index].isotope({ filter: filterValue });

           ev.stopPropagation();
      });
    
    });

    if(elmts){
          container[index].isotope( 'appended', elmts )
    }
  });
}

