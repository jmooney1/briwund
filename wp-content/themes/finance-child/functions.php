<?php
function custom_excerpt_length($length){
	return 1;
}
add_filter('excerpt_length', 'custom_excerpt_length', 99);

/**
* load our scripts when the theme is ready to accept them
* @return bool
*/
function AddScriptsAndCSS() { 
    //scripts
    wp_enqueue_script("jquery");
    wp_enqueue_script('my_prefix_script', '/wp-content/themes/finance-child/jquery.flexslider-min.js',array('jquery'), '0.1');
    wp_enqueue_script('slider_stuff', '/wp-content/themes/finance-child/slider.js',array('jquery'), '0.1');
    //styles
    wp_enqueue_style('slider_style','/wp-content/themes/finance-child/flexslider.css');
    wp_enqueue_style('slider_style','/wp-content/themes/finance-child/flexslider-rtl.css');
    return TRUE;
}
  
add_action( 'wp_enqueue_scripts', 'AddScriptsAndCSS' );


	function bottom_cover($atts, $content = null){
		$output = '<div class="top-cover"></div><div><div id="content-top-block" class="col-sm-12 col-md-offset-2 col-md-8"><h2><span>'.$atts['header'].'<span></h2><div id="content">'.$content.'</div></div></div><br/><br/>';
		return $output;
	}


	add_shortcode('bottom-cover', 'bottom_cover');



	function line_heading($atts, $content = null){
		
		if($atts['location'] == 'left'){
			$output = '<h3 class="left-line"><span>'.$content.'</span></h3>';
		}
		else if($atts['location'] == 'right'){
			$output = '<h3 class="right-line"><span>'.$content.'</span></h3>';
		}
		else if($atts ['location'] == 'center'){
			$output = '<h3 class="center-line"><span>'.$content.'</span></h3>';
		}
		else {
			$output = '<h3 class="left-line"><span>'.$content.'</span></h3>';
		}
		return $output;
	}
	add_shortcode('line-heading', 'line_heading');


// Styling for the framework.....


//Main Contain is mainly only for the homepage container
	function main_contain($atts, $content = null){
		$output = '<div class="container">'.do_shortcode($content).'</div>';
		return $output;
	}
	add_shortcode('main-container', 'main_contain');



	function size_and_attributes($atts, $content, $size){

		$all_attributes = '';
		$link = '';
		$link_end = '';

		if(isset($atts['padding'])){
			if($atts['padding'] == '1-left'){
				$all_attributes .= 'padding-left: 8.33333%; ';
			}
			else if($atts['padding'] == '1-right'){
				$all_attributes .= 'padding-right: 8.33333%; ';
			}
		}

		if(isset($atts['links'])){
			$links = $atts['links'];
			$link = '<a href="'.$links.'">';
			$link_end = '</a>';
		}
		if(isset($atts['border'])){
			$all_attributes .= ' border-'.$atts['border'].': 1px solid black;';
		}

		if($size == 'one_third'){
		return '<div id="small-center" class="col-xs-12 col-sm-12 col-md-12 col-lg-4" style="'.$all_attributes.'">'.$link
					.do_shortcode($content).$link_end.'</div>';
		}
		else if($size == 'two_thirds'){
			return '<div id="two-thirds" class="col-md-12 col-lg-8" style="display: inline-block;'.$all_attributes.'">'.$link
					.do_shortcode($content).$link_end.'</div>';
		}
		else if($size == 'one_fourth'){
			return '<div id="one-fourth" class="col-md-3 col-lg-3" style="display: inline-block; '.$all_attributes.'">'.$link
					.do_shortcode($content).$link_end.'</div>';
		}
		else if($size == 'three_fourths'){
			return '<div id="three-fourths" class="col-md-9 col-lg-9" style="display: inline-block;'.$all_attributes.'">'.$link
					.do_shortcode($content).$link_end.'</div>';
		}
		else{
			return '<div id="small-center" class="col-xs-12 col-sm-12 col-md-12 col-lg-4" style="'.$all_attributes.'">'.$link
					.do_shortcode($content).$link_end.'</div>';
		}
	}

	add_shortcode('read-more', 'read_more');

	function read_more($atts, $content = null){
		$output = '<a href="'.$atts['links'].'"><span class="read-more">Read More <img src="/wp-content/uploads/2018/06/read-more.png" /></span></a>';
		return $output;
	}


	//One third is for Boxes on the homepage
	add_shortcode('one-third', 'one_third');

	function one_third($atts, $content = null){

		$size = 'one_third';

		$output = size_and_attributes($atts, $content, $size);
		
		return $output;
	}

		//Two thirds for boxes on homepage
	function two_thirds($atts, $content = null){
		$size = 'two_thirds';
		$output = size_and_attributes($atts, $content, $size);
		
		return $output;
	}

	add_shortcode('two-thirds', 'two_thirds');

	//Two thirds for boxes on homepage
	function one_fourth($atts, $content = null){

		$size = 'one_fourth';
		
		$output = size_and_attributes($atts, $content, $size);
		
		return $output;
	}

	add_shortcode('one-fourth', 'one_fourth');


	//Two thirds for boxes on homepage
	function three_fourths($atts, $content = null){

		$size = 'three_fourths';
		
		$output = size_and_attributes($atts, $content, $size);
		
		return $output;
	}

	add_shortcode('three-fourths', 'three_fourths');

	//Full width is for the homepage boxes that covers the whole area
	function full_width($atts, $content=null){
		$output = '<div class="col-md-12" id="full">'.do_shortcode($content).'</div>';
		return $output;
	}

	add_shortcode('full', 'full_width');
	
	//half width works for the two thirds
	//two thirds has two parts one text and one image
	//half width helps split those two and decifer
	function half_width($atts, $content = null){
		$border = '';
		if(isset($atts['border']))
			{
			$border = "border ";
			};
		$output = '<div id="half" class="'.$border.'col-md-6">'.do_shortcode($content).'</div>';
		return $output;
	}

	add_shortcode('half','half_width');


	//Rows for homepage section
	function add_row($atts, $content = null){
		$output = '<div class="row">'.do_shortcode($content).'</div>';
		return $output;
	}

	add_shortcode('row', 'add_row');




	//This is for a text block on the homepage
	function text_block($atts, $content = null){
		$string = '';

		if(isset($atts['position'])){
			$val = $atts['position'];
			$string = $val.':0';
			$output = '<div id="text-block" class="col-md-12" style="float: left; padding: 0; margin: 0; background: white; padding: 10px; height: 344px; '.$string.'">'.do_shortcode($content) .'</div>';
		}
		else{

		$output = '<div id="text-block" class="col-md-6" style="float: left; background: white; position: relative; height:344px; width: 100%'.$string.'">'.do_shortcode($content) .'</div>';
	}
		return $output;
	}

	add_shortcode('text-block', 'text_block');

	//Category is the Textblock top font
	function category($atts, $content = null){
		$output = '<div class="category">'.do_shortcode($content).'</div>';
		return $output;
	}

	add_shortcode('category', 'category');

	//Headline is the title of the textblock 
	function headline($atts, $content = null){
		$output = '<h2 class="headline">'.do_shortcode($content).'</h2>';
		return $output;
	}
	add_shortcode('headline', 'headline');

	//Caption is the main text
	function caption($atts, $content = null){
		$output = '<div class="caption">'.do_shortcode($content).'</div>';
		return $output;
	}

	add_shortcode('caption', 'caption');


	//Image block for the homepage
	function image_block($atts, $content = null){
		$output = '<div id="image-block" class="col-md-12" style="float: left; padding: 0; margin: 0;">'.do_shortcode($content) .'</div>';
		return $output;
	}

	add_shortcode('image-block', 'image_block');


	//Bottom section for featured stories
	function featured_story($atts, $content = null){
		$output = '<div class="col-md-12" id="featured-story">'.do_shortcode($content).'</div>';
		return $output;
	}

	add_shortcode('featured-story','featured_story');


	function box($atts, $content = null){
		$color = $atts['color'];
		if($color == 'darkblue'){
			$color = 'background-color: #243168;';
		}
		if($color == 'blue'){
			$color = 'background-color: #8CAED2;';
		}
		$header = '<div class="col-md-offset-2 col-md-8" style="text-align: left;"><h2>'.$atts['header'].'</h2></div>';
		$output = '<div id="blue-box" class="col-md-12" style="'.$color.'">'.$header.'<div class="col-md-offset-2 col-md-8">'.do_shortcode($content).'</div></div>';
		return $output;
	}

	add_shortcode('box', 'box');

	function line($atts, $content = null){
		$color = $atts['color'];
		if($color == 'orange'){
			$color = 'background-color: rgb(235, 130, 45);';
		}
		$output = '<div class="line" style="'.$color.'"></div>';
		return $output;
	}

	add_shortcode('line','line');


		add_shortcode('learn-more', 'learn_more');

	function learn_more($atts, $content = null){
		$output = '<a href="'.$atts['links'].'"><span class="learn-more" style="color: #eb812d">Learn More <img src="/wp-content/uploads/2018/06/read-more.png" style="width: 12px"/></span></a>';
		return $output;
	}


	function table($atts, $content = null){
		$output = '<table>'.do_shortcode($content).'</table>';

		return $output;
	}

	add_shortcode('table', 'table');

	function t_head($atts, $content = null){
		$output = '<th>'.do_shortcode($content).'</th>';
		return $output;
	}

	add_shortcode('t-head', 't_head');

	function table_row($atts, $content = null){
		$output = '<tr>'.do_shortcode($content).'</tr>';
		return $output;
	}

	add_shortcode('table-row', 'table_row');

	function table_title($atts, $content = null){
		$output = '<td class="title">'.do_shortcode($content).'</td>';
		return $output;
	}

	add_shortcode('t-title', 'table_title');


	function t_row($atts, $content = null){
		$output = '<td>'.do_shortcode($content).'</td>';
		return $output;
	}

	add_shortcode('t-row', 't_row');


function get_featured_stories($atts, $content = null){
		$count = 5;
		$string = '';
		if(isset($atts['posts'])){
			$count = $atts['posts'];
		}
		$the_query = new WP_Query( array( 'category_name' => 'featured story', 'posts_per_page' => $count ));  
		// The Loop
if ( $the_query->have_posts() ) {
    $string .= '<div class="flexslider"><ul class="slides widget_recent_entries">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();

            if ( has_post_thumbnail() ) {

            $string .= '<li class="featured">';
            $string .= '<a href="' . get_the_permalink() .'" style="float: left; width: 50%; background: #9bc3e4; height: 100%" rel="bookmark">' . get_the_post_thumbnail($post_id, array( 600, 500) ).'</a><div class="boxed"><div class="featured-title"><h2>' .get_the_title() .'</h2></div><div class="featured-text">'.get_the_excerpt().'</div></div></li>';

            } 
            else { 
            // if no featured image is found
            $string .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a></li>';
            }
            }
    } 
    else {
    // no posts found
}
$string .= '</ul></div>';
 
return $string;
 
/* Restore original Post Data */
wp_reset_postdata();
}

	add_shortcode('get-category','get_featured_stories');



function get_recent_news($atts, $content = null){
		$count = 5;
		$string = '';
		if(isset($atts['posts'])){
			$count = $atts['posts'];
		}
		$the_query = new WP_Query( array( 'category_name' => 'recent news', 'posts_per_page' => $count ));  
		// The Loop
if ( $the_query->have_posts() ) {
    $string .= '<ul class="recent-news"><div class="recent-news-header">Recent News</div>';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();

$text = get_the_excerpt();

            $string .= '<li><a href="' . get_the_permalink() .'" rel="bookmark">' . get_the_title() .'</a><p>'.get_the_date().'</p></li>';
            }
            
    } 
    else {
    // no posts found
}
$string .= '</ul>';
 
return $string;
 
/* Restore original Post Data */
wp_reset_postdata();
}

add_shortcode('recent-news', 'get_recent_news');







function widget($atts) {
    
    global $wp_widget_factory;
    
    extract(shortcode_atts(array(
        'widget_name' => FALSE
    ), $atts));
    
    $widget_name = wp_specialchars($widget_name);
    
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
    ob_start();
    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id,
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => ''
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('widget','widget'); 





remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');



