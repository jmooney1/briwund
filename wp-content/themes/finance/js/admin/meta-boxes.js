jQuery( function ( $ )
{
    checkboxToggle();
    show_hide_controls();
    themesflat_color_picker();
    togglePostFormatMetaBoxes();    
    ImagePicker('.themesflat-options-control-image-control');
    Metaboxes();
    SingleImagePicker('.themesflat-options-control-single-image-control');
    // ImagePicker('themesflat-options-control-image-control');

    /**
     * Show, hide a <div> based on a checkbox
     *
     * @return void
     * @since 1.0
     */
    function themesflat_color_picker(){

        if ( $().wpColorPicker ) {
            $('.flat-color-picker').wpColorPicker({
                change:function(event, ui) {
                $(this).parents(".themesflat-themesflat-options-control-inputs").find(".choose-color").trigger('change');
                }
            });
        }
    }

     function SingleImagePicker(element) {
            if($(element).length != 0) {
                var frame,
                metaBox = $(element), // Your meta box id here
                addImgLink = metaBox.find('a.browse-media'),
                delImgLinks = metaBox.find( 'a.remove'),
                delImgLink = metaBox.find('a.themesflat-remove-media'),
                imgContainer = metaBox.find( '.upload-preview'),
                imgIdInput = metaBox.find( '.image-value' );
                addImgLink.parent().show();
                var ids = [];

                // ADD IMAGE LINK
                addImgLink.on( 'click', function( event ){
                var _root = $(this).parents('li');
                imgContainer = _root.find( '.upload-preview'),
                imgIdInput = _root.find( '.image-value' );
                event.preventDefault();
    
                // If the media frame already exists, reopen it.
                if ( frame ) {
                  frame.open();
                  return;
                }
    
                // Create a new media frame
                frame = wp.media( {
                    title: 'Select or Upload Media Of Your Chosen Persuasion',
                      button: {
                        text: 'Use this media'
                      },
                    multiple: false  // Set to true to allow multiple files to be selected
                });

                // When an image is selected in the media frame...
                frame.on( 'select', function() {
      
                // Get media attachment details from the frame state
                var length = frame.state().get('selection').length;

                var images = frame.state().get("selection").models;
                var image_url;
                for(var iii = 0; iii < length; iii++) {
                    image_url = images[iii].changed.url;
                    imgContainer.html( '' );
                    imgContainer.append( '<li><img src="'+image_url+'" alt="" style="max-width:100%;"/><a href="#" id="'+images[iii].id+'" class="themesflat-remove-media" title="Remove"> <span class="dashicons dashicons-no-alt"></span> </a>' );
                    var image_caption = images[iii].changed.caption;
                    var image_title = images[iii].changed.title;
                }

                // Hide the add image link
                $(this).parent().hide();

                imgIdInput.val(image_url);

                // Unhide the remove image link
                    delImgLink.show();
                });

                // Finally, open the modal on click
                frame.open();
            });

 
        // DELETE IMAGE LINK
        metaBox.on( 'click', 'a.themesflat-remove-media',function( event ){
        event.preventDefault();
        var _root = $(this).parents('li');
        imgContainer = _root.find( '.upload-preview'),
        addImgLink = _root.find('a.browse-media'),
        imgIdInput = _root.find( '.image-value' );
        addImgLink.parent().show();
        imgIdInput.val('');
        imgContainer.html( '' );

      });

        delImgLinks.on( 'click', function( event ){
        var _root = $(this).parents('li');
        imgContainer = _root.find( '.upload-preview'),
        imgIdInput = _root.find( '.image-value' );
        event.preventDefault();

        // Clear out the preview image
        imgContainer.html( '' );

        // Un-hide the add image link
        addImgLink.parent().show();

        // Hide the delete image link
        delImgLink.hide();

        // Delete the image id from the hidden input
        imgIdInput.val( '' );
        ids =[];

      });
            }
        }
   

    function show_hide_controls() {
        $('.themesflat-options-container-content input[type=checkbox]').each(function(){
            var $this = $(this);
            if ( $this.attr('children').length > 2 ){
                if ($this.is(':checked')) {
                    $($this.attr('children')).show();
               }
               else {
                    $($this.attr('children')).hide();
               }
           }
       });
        $(document).on('change','.themesflat-options-container-content input[type=checkbox]',function(){
            var $this = $(this);
          if ($this.is(':checked')) {
                $($this.attr('children')).show();
                $this.parents("li").find('.themesflat-options-control-title').addClass('active');
           }
           else {
                $($this.attr('children')).hide();
                $this.parents("li").find('.themesflat-options-control-title').removeClass('active');
           }
            })
    }

    function checkboxToggle()
    {
        $( 'body' ).on( 'change', '.checkbox-toggle input', function()
        {
            var $this = $( this ),
                $toggle = $this.closest( '.checkbox-toggle' ),
                action;
            if ( !$toggle.hasClass( 'reverse' ) )
                action = $this.is( ':checked' ) ? 'slideDown' : 'slideUp';
            else
                action = $this.is( ':checked' ) ? 'slideUp' : 'slideDown';

            $toggle.next()[action]();
        } );
        $( '.checkbox-toggle input' ).trigger( 'change' );
    }

    function Metaboxes() {
    
        var args = {duration: 600};
        $('.flat-toggle .toggle-title.active').siblings('.toggle-content').show();

        $('.flat-toggle.enable .toggle-title').on('click', function() {
            $(this).closest('.flat-toggle').find('.toggle-content').slideToggle(args);
            $(this).toggleClass('active');
        }); // toggle 

        $('.flat-accordion .toggle-title').on('click', function () {
            if( !$(this).is('.active') ) {
                $(this).closest('.flat-accordion').find('.toggle-title.active').toggleClass('active').next().slideToggle(args);
                $(this).toggleClass('active');
                $(this).next().slideToggle(args);
            } else {
                $(this).toggleClass('active');
                $(this).next().slideToggle(args);
            }     
        }); 

      

    }

    /**
     * Show, hide post format meta boxes
     *
     * @return void
     * @since 1.0
     */
    function togglePostFormatMetaBoxes()
    {
        var $input = $( 'input[name=post_format]' ),
            $metaBoxes = $( '#blog-options [id^="themesflat-themesflat-options-control-"]' ).hide();

        // Don't show post format meta boxes for portfolio
        if ( $( '#post_type' ).val() == 'members' )
            return;

        if ( $( '#post_type' ).val() == 'food' )
            return;

        $input.change( function ()
        {
            $metaBoxes.hide();
            if ( $(this).val() == 'gallery' || $(this).val() == 'video' ) { 
                $( '[id*="themesflat-themesflat-options-control-' + $( this ).val()+ '"]').show();
            }
            else $('#themesflat-themesflat-options-control-blog_heading') .show();

        } );
        $input.filter( ':checked' ).trigger( 'change' );
    } 

    function delimg($del_val,$array) {
        var returnedData = $.grep($array, function($value){
          return $value != $del_val;
        });
        return returnedData;
    }
 

     function ImagePicker(element) {
        if($(element).length != 0) {
            var frame,
        metaBox = $(element), // Your meta box id here
        addImgLink = metaBox.find('a.browse-media'),
        delImgLinks = metaBox.find( 'a.remove'),
        delImgLink = metaBox.find('a.themesflat-remove-media'),
        imgContainer = metaBox.find( '.upload-preview'),
        imgIdInput = metaBox.find( '.image-value' );
        addImgLink.parent().show();
        var ids = [];

      

    // ADD IMAGE LINK
    addImgLink.on( 'click', function( event ){
    
    event.preventDefault();
    
    // If the media frame already exists, reopen it.
    if ( frame ) {
      frame.open();
      return;
    }
    
    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload Media Of Your Chosen Persuasion',
      button: {
        text: 'Use this media'
      },
      multiple: true  // Set to true to allow multiple files to be selected
    });
    if (imgIdInput.val() != ''){
        ids = JSON.parse(imgIdInput.val());
    }

    // When an image is selected in the media frame...
    frame.on( 'select', function() {
      
      // Get media attachment details from the frame state
    var length = frame.state().get('selection').length;

    var images = frame.state().get("selection").models;

        for(var iii = 0; iii < length; iii++)
        {
            var image_url = images[iii].changed.sizes.thumbnail.url;
            imgContainer.append( '<li><img src="'+image_url+'" alt="" style="max-width:100%;"/><a href="#" id="'+images[iii].id+'" class="themesflat-remove-media" title="Remove"> <span class="dashicons dashicons-no-alt"></span> </a>' );
            var image_caption = images[iii].changed.caption;
            var image_title = images[iii].changed.title;
            ids.push(images[iii].id);
        }

      // Hide the add image link

      imgIdInput.val(JSON.stringify(ids) );

      // Unhide the remove image link
      delImgLink.show();
    });

    // Finally, open the modal on click
    frame.open();
  });

  // DELETE IMAGE LINK
  metaBox.on( 'click', 'a.themesflat-remove-media',function( event ){
    event.preventDefault();
    ids = JSON.parse(imgIdInput.val());
    $(this).parent().remove();
    ids = delimg($(this).attr('id'),ids);
    if ( ids.length != 0 ) {
        imgIdInput.val(JSON.stringify(ids) );
    }
    else {
        addImgLink.parent().show();
        imgIdInput.val('');
    }
  });
  delImgLinks.on( 'click', function( event ){

    event.preventDefault();

    // Clear out the preview image
    imgContainer.html( '' );

    // Un-hide the add image link
    addImgLink.parent().show();

    // Hide the delete image link
    delImgLink.hide();

    // Delete the image id from the hidden input
    imgIdInput.val( '' );
    ids =[]

  });
            }
        } 

    
} );