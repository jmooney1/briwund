( function( $ ) {
  "use strict";
    var api = wp.customize,
    doc = $(document);   
   	var Typography = ( function() {
        function Typography( element, options ) {
        if ($(element).length != 0){
        if ($().choosen) {
        $(".select-choosen").chosen();
        }
            var root = $( element ),
                settingLink = root.find("#typography-value").attr('data-customize-setting-link');
            var data_variants = JSON.parse(root.find("#datas").attr('data_variants')),
                data_subsets = JSON.parse(root.find("#datas").attr('data_subsets'));
            root.find('.typography-font select').on('change', function() {
                var variants = $(this).find('option:selected').attr('data_variants'),
                    fontWeight = $(this).closest(element).find('.typography-style select'),
                    currentVariant = fontWeight.val();
                    fontWeight.empty();

                if (variants !== undefined) {
                    $.each(JSON.parse(variants), function(index, value) {
                        value = value.trim();
                        fontWeight.append($('<option />', { value: value }).text(
                            data_variants[value] !== undefined ? data_variants[value] : value
                        ));
                    });
                }

                fontWeight.val(currentVariant);

                var subsets = $(this).find('option:selected').attr('data_subsets'),
                    subset = $(this).closest(element).find('.typography-subsets .themesflat-options-control-inputs');
                    
                    // currentVariant = subset.val();
                    subset.empty();
                    var switcher_subset;

                if (subsets !== undefined) {
                    $.each(JSON.parse(subsets), function(index, value) {
                        value = value.trim();
                        var _value = data_subsets[value] !== undefined ? data_subsets[value] : value;
                         switcher_subset = '\
                        <label class="_options-switcher-subsets">\
                            <span class="themesflat-options-control-title">'+_value+'</span>\
                            <input type="checkbox" value="'+value+'" name="_themesflat-options-control-typography-'+settingLink+'[subsets]">\
                            <span class="themesflat-options-control-indicator">\
                                <span></span>\
                            </span>\
                        </label>';
                        subset.append(switcher_subset);
                    });
                }

            });

            var save_customize = function(a) {
                settingLink = a.find("#typography-value").attr('data-customize-setting-link');
                if (wp.customize && settingLink) {
                    var __subsets = [];
                    root.find('._options-switcher-subsets input[type="checkbox"]:checked').each(function(){
                        __subsets.push($(this).val());
                    });

                    wp.customize.instance(settingLink).set(JSON.stringify({
                        family: a.find('.typography-font select').val(),
                        size: a.find('.typography-size input').val(),
                        line_height: a.find('.typography-line_height input').val(),
                        style: a.find('.typography-style select').val(),
                        color: a.find('.typography-color .nah-color-picker').val(),
                        subsets: __subsets
                    }));
                }
            }

            root.on('change', 'select, input', function() {
                save_customize($(this).closest('.themesflat-options-control-typography'));
            });

        };

        };

        return Typography;
    } )();

    $(function() {        
        Typography('.themesflat-options-control-typography');
    })

} )(jQuery );

