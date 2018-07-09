<?php
//UTILS

function tshowcase_strip_http($url) {	
	$url = preg_replace('#^https?://#', '', $url);
    return $url;
}

//To Show styled messages
function tshowcase_message($msg) { ?>
<div id="message" class="updated"><p><?php echo $msg; ?></p></div>
<?php	
}

function tshowcase_get_img_style($style) {
	
	global $ts_imgstyles;
	
	$css = "";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$ts_imgstyles)) {
		$css .= $ts_imgstyles[$st].' ';
		}
	}
	
	return $css;
}

function tshowcase_get_info_style($style) {
	
	global $ts_infostyles;
	
	$css = "";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$ts_infostyles)) {
		$css .= $ts_infostyles[$st].' ';
		}
	}
	
	return $css;
}


function tshowcase_get_box_style($style) {
	
	global $ts_boxstyles;
	
	$css = "";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$ts_boxstyles)) {
		$css .= $ts_boxstyles[$st].' ';
		}
	}
	
	return $css;
}

function tshowcase_get_innerbox_style($style) {
	
	global $ts_innerboxstyles;
	
	$css = "";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$ts_innerboxstyles)) {
		$css .= $ts_innerboxstyles[$st].' ';
		}
	}
	
	return $css;
}


function tshowcase_get_wrap_style($style) {
	
	global $ts_wrapstyles;
	
	$css = "";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$ts_wrapstyles)) {
		$css .= $ts_wrapstyles[$st].' ';
		}
	}
	
	return $css;
}


function tshowcase_get_txt_style($style) {
	global $ts_txtstyles;
	
	$css = "";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$ts_txtstyles)) {
		$css .= $ts_txtstyles[$st].' ';
		}
	}
	
	return $css;
}

function tshowcase_get_pager_style($style) {
	global $ts_pagerstyles;
	
	$css = "";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$ts_pagerstyles)) {
		$css .= $ts_pagerstyles[$st].' ';
		}
	}
	
	return $css;
}

function tshowcase_get_pager_box_style($style) {
	global $ts_pagerboxstyles;
	
	$css = "";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$ts_pagerboxstyles)) {
		$css .= $ts_pagerboxstyles[$st].' ';
		}
	}
	
	return $css;
}

function tshowcase_get_themes($style,$layout) {
	global $ts_theme_names;
	
	$themearray = $ts_theme_names[$layout];
		
	$css = "default";
	$styles = explode(',',$style);
	
	foreach ($styles as $st) {
	if(array_key_exists($st,$themearray)) {
		$css = $themearray[$st]['key'];
		}
	}
		
	return $css;
}

//CREATE TEL LINKS
add_filter('tshowcase_filter_tel','tshowcase_tellink_filter');
function tshowcase_tellink_filter($string){
	$phone = preg_replace('/[^0-9+-]/', '', $string);	
	return '<a href="tel:'.$phone.'">'.$string.'</a>';
}


//CREATE MAILTO LINKS
function tshowcase_mailto_filter($str) {
    //$regex = '/(\S+@\S+\.\S+)/';
    //$replace = '<a href="mailto:$1">$1</a>';
	//return preg_replace($regex, $replace, $str);

	return "<a href='mailto:".$str."'>".$str."</a>";
	//return "<a href='mailto:".$str."'>email me</a>";
}

function tshowcase_mailto_filter_ico($str) {
    //$regex = '/(\S+@\S+\.\S+)/';
    //$replace = 'mailto:$1';
    //return preg_replace($regex, $replace, $str);
    return "mailto:".$str;
}

function tshowcase_pagination($loop) {

		global $ts_labels;

		$max_page = $loop->max_num_pages;
		$numbers = "";

		$ii = 1;
		while ($ii <= $max_page) {
			$current = (isset($_GET['tpage']) && $_GET['tpage'] == $ii) || (!isset($_GET['tpage']) && $ii == 1) ? 'tshowcase_current_page' : '';
			$numbers .= " <a class='tshowcase_page ".$current."' data-page-number='".$ii."' href='?tpage=".$ii."'>".$ii."</a> ";
			$ii++;
		}

		//close previous container divs
		//$html = "</div>";
		$html = "<div class='tshowcase_pager'>";

		if(isset($_GET['tpage']) && $_GET['tpage']!='1' && $_GET['tpage'] < $max_page){ 
			
			$next = intval($_GET['tpage']) + 1;
			$previous = intval($_GET['tpage'])-1;

			$html .= "<a class='tshowcase_previous' data-page-number='".$previous."' href='?tpage=".$previous."'>".$ts_labels['pagination']['previous_page']."</a>";
			$html .= $numbers;
			$html .= "<a class='tshowcase_next' data-page-number='".$next."' href='?tpage=".$next."'>".$ts_labels['pagination']['next_page']."</a>";

		} if(!isset($_GET['tpage']) || $_GET['tpage']=='1' ) {

			$html .= $numbers." <a data-page-number='2' class='tshowcase_next_page' href='?tpage=2'>".$ts_labels['pagination']['next_page']."</a>";
		
		}

		if(isset($_GET['tpage']) && $_GET['tpage']!='1' && $_GET['tpage']>=$max_page){ 
			
			
			$previous = intval($_GET['tpage'])-1;

			$html .= "<a class='tshowcase_previous_page' data-page-number='".$previous."' href='?tpage=".$previous."'>".$ts_labels['pagination']['previous_page']."</a>";
			$html .= $numbers;
			

		} 

		$html .= "</div>";

		//$html .= "<div>";

		return $html;

}


function tshowcase_loadmore($loop,$atts) {

		tshowcase_ajax_loadmore($atts);

		$options = get_option('tshowcase-settings');

		$loadmorelabel = isset($options['tshowcase_loadmore_label']) ? $options['tshowcase_loadmore_label'] : __('Load More','tshowcase');

		$max_page = $loop->max_num_pages;

		$html = '<div class="ts_load_more" id="ts_load_more" data-page-number="1" data-maximum-page-number="'.$max_page.'">'.$loadmorelabel.'</div>';

		return $html;

}

//To filter links
function tshowcase_custom_link( $url, $post ) {

	if ( 'tshowcase' == get_post_type( $post ) ) {

		$tsuser = get_post_meta( $post->ID , '_tspersonal', true );

		if($tsuser!='') {

			return $tsuser;

		}

		else {

			return $url;

		}

	}

	return $url;

}

function tshowcase_custom_link_empty( $url, $post ) {

	if ( 'tshowcase' == get_post_type( $post ) ) {

		$tsuser = get_post_meta( $post->ID , '_tspersonal', true );

		if($tsuser!='') {

			return $tsuser;

		}

		else {

			return '';

		}

	}

	return $url;

}

function tshowcase_author_link( $url, $post ) {

	if ( 'tshowcase' == get_post_type( $post ) ) {

		$tsuser = get_post_meta( $post->ID , '_tsuser', true );

		if($tsuser!='0') {

			$tsuser = intval($tsuser);
			return get_author_posts_url($tsuser);
			//$file = home_url( '/' );
        	//$link = $file . '?author=' . $tsuser;
        	//$link = apply_filters( 'author_link', $link, $tsuser );
        	return $link;

		}

		else {

			return $url;

		}

	}

	return $url;

}

//To order by last name
function tshowcase_posts_orderby_lastname ($orderby_statement) 
{
	
  	$orderby_statement = "RIGHT(post_title, LOCATE(' ', REVERSE(post_title)) - 1) DESC";
    return $orderby_statement;
}


//Custom CSS

function tshowcase_custom_css () {
	$options = get_option( 'tshowcase-settings' );
	$css = $options['tshowcase_custom_css'];
	if($css!=''){
		echo '
		<!-- Custom Styles for Team Showcase -->
		<style type="text/css">
		'.$css.'
		</style>';
	}
	$js = $options['tshowcase_custom_js'];
	if($js!=''){
		echo "
		<!-- Custom Javascript for Team Showcase -->
		<script type='text/javascript'>
		".$js."
		</script>";
	}
}


function tshowcase_get_information($id,$show,$display=array(),$singular=false) {
	
		$options = get_option('tshowcase-settings');
		$html='';
		
    $title = false;
		$smallicons = in_array('smallicons',$display);
    $displaygroups = in_array('groups',$display);
    $displaytax = (in_array('taxonomy',$display) || in_array('groups2',$display)) && isset($options['tshowcase_second_tax']) ? true : false;
    $displayctax = in_array('ctaxonomy',$display) && isset($options['tshowcase_third_tax']) ? true : false;
	$displaydtax = in_array('dtaxonomy',$display) && isset($options['tshowcase_fourth_tax']) ? true : false;
	
		if($singular) {

      $title = isset($options['tshowcase_single_show_title']);
			$smallicons = isset($options['tshowcase_single_show_smallicons']);
      $displaygroups = isset($options['tshowcase_single_show_groups']);
      $displaytax = isset($options['tshowcase_single_show_taxonomy']) && isset($options['tshowcase_second_tax']) ? true : false;
      $displayctax = isset($options['tshowcase_single_show_ctaxonomy']) && isset($options['tshowcase_third_tax']) ? true : false;
	  $displaydtax = isset($options['tshowcase_single_show_dtaxonomy']) && isset($options['tshowcase_fourth_tax']) ? true : false;
	
			if($smallicons) {
				tshowcase_add_smallicons_css();
			}
			
		}
	
	//first tax	
    $tsgroups = '';
    $taxonomy = 'tshowcase-categories';
    
    $terms = wp_get_post_terms( $id, $taxonomy, array("fields" => "all","orderby"=>"slug") );  
    

    foreach ($terms as $term) {

      if(strstr($term->description, 'http')) {

        $tsgroups .= '<a href="'.$term->description.'">'.$term->name.'</a>, ';
      
      }
      else {

        $tsgroups .= $term->name.', ';

      }
    }
    $tsgroups = rtrim($tsgroups, ", ");

    //for second taxonomy
    $tstax = '';
    if($displaytax) {
      $taxonomy2 = 'tshowcase-taxonomy';
      $terms = wp_get_post_terms( $id, $taxonomy2, array("fields" => "all","orderby"=>"slug") );  
      foreach ($terms as $term) {
        $tstax .= $term->name.', ';
      }
      $tstax = rtrim($tstax, ", ");
    }

    //for third taxonomy
    $tsctax = '';
    if($displayctax) {
      $taxonomy3 = 'tshowcase-ctaxonomy';
      $terms = wp_get_post_terms( $id, $taxonomy3, array("fields" => "all","orderby"=>"slug") );  
      foreach ($terms as $term) {
        $tsctax .= $term->name.', ';
      }
      $tsctax = rtrim($tsctax, ", ");
    }
    
    //for fourth taxonomy
    $tsdtax = '';
    if($displaydtax) {
      $taxonomy4 = 'tshowcase-dtaxonomy';
      $terms = wp_get_post_terms( $id, $taxonomy4, array("fields" => "all","orderby"=>"slug") );  
      foreach ($terms as $term) {
        $tsdtax .= $term->name.', ';
      }
      $tsdtax = rtrim($tsdtax, ", ");
    }
    

		
		$ts_small_icons = apply_filters('tshowcase_default_icons',array());
		
		if($smallicons) {
      		$icontitle = '<i class="'.$ts_small_icons['title'].'"></i>';
      		$icongroups = '<i class="'.$ts_small_icons['groups'].'"></i>';
      		$icontax = '<i class="'.$ts_small_icons['taxonomy'].'"></i>';
      		$iconctax = '<i class="'.$ts_small_icons['ctaxonomy'].'"></i>';
      		$icondtax = '<i class="'.$ts_small_icons['dtaxonomy'].'"></i>';
		} else {
      		$icontitle = '';
      		$icongroups = '';
      		$icontax = '';
      		$iconctax = '';
      		$icondtax = '';
		}
		
		$info_array = array();

    if(($title)) { 
    	$info_array['title'] = '<div class="tshowcase-single-title" itemprop="name">'.$icontitle.get_the_title($id).'</div>'.$html;
    } 

    if($displaygroups && $tsgroups != '') {

      $info_array['groups'] = '<div class="tshowcase-single-groups">'.$icongroups.$tsgroups.'</div>';

    }

    if($displaytax && $tstax != '') {

      $info_array['taxonomy'] = '<div class="tshowcase-single-taxonomy">'.$icontax.$tstax.'</div>';

    }

    if($displayctax && $tsctax != '') {

      $info_array['ctaxonomy'] = '<div class="tshowcase-single-ctaxonomy">'.$iconctax.$tsctax.'</div>';

    }

     if($displaydtax && $tsdtax != '') {

      $info_array['dtaxonomy'] = '<div class="tshowcase-single-dtaxonomy">'.$icondtax.$tsdtax.'</div>';

    }
	
    //ADDITIONAL INFO FIELDS

    $fields = apply_filters('tshowcase_custom_fields',array());
    foreach ($fields as $key => $value) {

      $value['icon'] = isset($value['icon']) ? '<i class="'.$value['icon'].'"></i>' : '';

      if(($singular && isset($options['tshowcase_single_show_'.$key])) || (!$singular && in_array($key,$display))){

        if(!isset($value['hide'])){

          $metavalue = get_post_meta( $id, $value['key'], true );
          if($metavalue==false || $metavalue==''){
            continue;
          }

          if(isset($value['format']) && $value['format']=='email'){

            $tsemail = get_post_meta( $id, $value['key'], true );
            $mailto = isset($options['tshowcase_mailto']);
            if($mailto){ 
              $tsemail = tshowcase_mailto_filter($tsemail);
            } 
            //to avoid spam bots, we replace the @ with with html code
            $tsemail = str_replace("@", "&#64;", $tsemail);
            $thisval = $smallicons ? $value['icon'].' '.$tsemail : $tsemail;
              if(isset($value['container'])){
                $info_array[$key] = sprintf($value['container'],$thisval);
              } else {
                $info_array[$key] = '<div class="tshowcase-single-'.$key.'">'.$thisval.'</div>';
              }

          }

          else if(isset($value['format']) && $value['format']=='tel'){
            $tstel = get_post_meta( $id, $value['key'], true );
            $tellink = isset($options['tshowcase_tellink']);
            if($tellink) {
              //$tstel = tshowcase_tellink_filter($tstel);
            	$tstel = apply_filters('tshowcase_filter_tel',$tstel);
            } 
            $thisval = $smallicons ? $value['icon'].$tstel : $tstel;
            if(isset($value['container'])){
              $info_array[$key] = sprintf($value['container'],$thisval);
            } else {
              $info_array[$key] = '<div class="tshowcase-single-'.$key.'">'.$thisval.'</div>';
            }
          }

          else if(isset($value['format']) && $value['format']=='url'){

            $url = get_post_meta( $id, $value['key'], true );
            if(isset($value['anchor'])){
              $anchor = get_post_meta( $id, $fields[$value['anchor']]['key'], true );
              if($anchor){
                $url = '<a href="'.$url.'" target="_blank">'.$anchor.'</a>';
              } else {
                $url = '<a href="'.$url.'" target="_blank">'.$url.'</a>';
              }
            }

            $thisval = $smallicons ? $value['icon'].$url : $url;
            if(isset($value['container'])){
              $info_array[$key] = sprintf($value['container'],$thisval);
            } else {
              $info_array[$key] = '<div class="tshowcase-single-'.$key.'">'.$thisval.'</div>';
            }

          }

          else {

          	  $metavalue = do_shortcode($metavalue);

              $thisval = $smallicons ? $value['icon'].$metavalue : $metavalue;
              if(isset($value['container'])){
                $info_array[$key] = sprintf($value['container'],$thisval);
              } else {
                $info_array[$key] = '<div class="tshowcase-single-'.$key.'">'.$thisval.'</div>';
              }
          }
        }

      }
    }



		
		//ordering
    //first we check if there is an order chosen
    
		$ts_content_order = apply_filters('tshowcase_content_order', array());
		foreach ($ts_content_order as $info) {
			if(isset($info_array[$info])) {
			$html.=$info_array[$info];
      unset($info_array[$info]);
			}
		}
    
    //the remaining itens go at the end
    foreach ($info_array as $key => $value) {
      $html.=$value;
    }
    
		
		//Grab other custom fields
		//$html .= '<div>'.get_post_meta( $id, 'your_custom_field_name', true ).'</div>';

    //Display Date
    //$html .= 'Birthday: '.get_the_date('Y-m-d', $id);
		
		//place the title before the info
		//$html = '<div class="tshowcase-single-title">'.get_the_title($id).'</div>'.$html;

    //add a click here link
    //if(!$singular) {$html .= '<a href="'.get_permalink($id).'">Click for more info</a>'; }

    return $html;
		
}


function tshowcase_get_social($id,$show) {
	
		$html="";    
    	$ts_social_networks = apply_filters('tshowcase_social_networks',array());

		
		if($show) {
			
			$options = get_option('tshowcase-settings');		

      $nofollow = '';
      if(isset($options['tshowcase_nofollow'])) {
        $nofollow = "rel='nofollow'";
      }		
		
			$tsemailico = get_post_meta( $id, '_tsemailico', true );

      if($tsemailico!=""){ 

          $options = get_option('tshowcase-settings');
          $mailto = isset($options['tshowcase_mailto']);

          if($mailto){ 

            $tsemailico = tshowcase_mailto_filter_ico($tsemailico);
            $tsemailico = str_replace("@", "&#64;", $tsemailico); 

          } 

      }
			
			$folder = isset($options['tshowcase_single_social_icons']) ? $options['tshowcase_single_social_icons'] : 'font';
			
			$social_array=array();

      //icon images where discontinued, so we make the option revert to 'font'
      if($folder!='font' && $folder!='font-gray'  ) {
        $folder='font';
      }

			if($folder=='font' || $folder=='font-gray'  ) {

				tshowcase_add_smallicons_css();

        $fontsize = isset($options['tshowcase_single_social_icons_size']) ? $options['tshowcase_single_social_icons_size'] : 'fa-lg';

				//other options: 'fa-lg','fa-2x', 'fa-3x' or none '';

        if($tsemailico!=""){ $html .=   "<a href='".$tsemailico."' ".$nofollow." target='_blank'><i class='fas fa-envelope ".$fontsize."'></i></a>"; }

        foreach ($ts_social_networks as $snkey => $sn) {
          if(get_post_meta( $id, '_ts'.$sn[0], true )!='') {
            $html .= "<a href='".get_post_meta( $id, '_ts'.$sn[0], true )."' ".$nofollow." target='_blank'><i class='".$sn[2]." ".$fontsize."'></i></a>";
          }
        }

			}

	}
	
	if(isset($folder) && $folder == 'font-gray') {
		$html = '<div class="ts-social-gray">'.$html.'</div>';
	}

	return $html;
	
}

//Structured Data JSON-LD
function tshowcase_get_structured_data($id,$wrap = true){


	$properties = array(
		'@context'  => 'http://schema.org',
		'@type' 	=> 'Person',
		'name'		=> get_the_title($id),
		);

	//Image
	if (has_post_thumbnail($id)) {     
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );	
		$properties['image'] = $image[0];
	}

	//Information Fields
	$fields = apply_filters('tshowcase_custom_fields',array());
    foreach ($fields as $key => $value) {
 	    if(isset($value['property'])){
          $metavalue = get_post_meta( $id, $value['key'], true );
          if($metavalue){
          	$properties[$value['property']] = $metavalue;
          }
        }
    }


    //Social Networks
    $socialurls = array();
    $ts_social_networks = apply_filters('tshowcase_social_networks',array());
    foreach ($ts_social_networks as $snkey => $sn) {
      $social = get_post_meta( $id, '_ts'.$sn[0], true );
      if($social!='') {
        array_push($socialurls, $social);
      }
    }
    if(!empty($socialurls)){
    	$properties['sameAs'] = $socialurls;
    }

	$html = json_encode($properties);

	if($wrap){

		$html = '<script type="application/ld+json">'.$html.'</script>';

	}

	return $html;


}

function ts__($value,$context) {

	if(function_exists('icl_t')){

		return icl_t($context,'Settings Field: '.$value,$value);

	} else {
		return __($value,$context);
	}

}


?>