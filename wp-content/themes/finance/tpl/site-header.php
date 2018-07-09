<?php 
$header_style = themesflat_choose_opt('header_style');
echo '<div class="flat_header_wrap '.esc_attr( themesflat_choose_opt('header_style') ).'" data-header_style="'.$header_style.'">';
switch ( $header_style ):
    case 'header-style1':
        get_template_part( 'tpl/header/header-style1');
        break;
    case 'header-style2':
        get_template_part( 'tpl/header/header-style2');
        break;
    case 'header-style3':
        get_template_part( 'tpl/header/header-style3');
        break;
    case 'header-style4':
        get_template_part( 'tpl/header/header-style4');
        break;    
endswitch;
echo '</div>';
?>


        


