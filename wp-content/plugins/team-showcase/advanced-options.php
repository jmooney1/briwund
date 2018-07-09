<?php
//This file has stored global variables that the plugin uses.
//Altough they can be changed, don't forget to change them back if you upgrade this file.

//Ordering options won't affect table layout

//ORDER OF CONTENT 
//MAIN ORDER - name, details, social
$ts_display_order = apply_filters('tshowcase_display_order', array());
add_filter('tshowcase_display_order','tshowcase_default_display_order');
function tshowcase_default_display_order($order){

	$default = array(
		1 => 'name',
		2 => 'details',
		3 => 'social'	
	);

	$order = array_merge($order, $default);
	return $order;

}


//Social Networks
$ts_social_networks = apply_filters('tshowcase_social_networks',array());
add_filter('tshowcase_social_networks','tshowcase_default_social');
function tshowcase_default_social($social) {

	$default = array(

		0 => array('linkedin','Linkedin','fab fa-linkedin',''),
		1 => array('facebook','Facebook','fab fa-facebook'),
		2 => array('twitter','Twitter','fab fa-twitter-square'),
		3 => array('gplus','Google Plus','fab fa-google-plus-square'),
		4 => array('youtube','Youtube','fab fa-youtube-square'),
		5 => array('vimeo','Vimeo','fab fa-vimeo'),
		6 => array('yelp','yelp','fab fa-yelp'),
		7 => array('pinterest','Pinterest','fab fa-pinterest'),
		8 => array('instagram','Instagram','fab fa-instagram'),
		9 => array('tumblr','Tumblr','fab fa-tumblr'),
		10 => array('behance','Behance','fab fa-behance'),
		11 => array('soundcloud','Soundcloud','fab fa-soundcloud'),
		12 => array('mixcloud','Mixcloud','fab fa-mixcloud'),
		13 => array('deviantart','Deviantart','fab fa-deviantart'),
		14 => array('dribbble','Dribbble','fab fa-dribbble'),
		15 => array('flickr','Flickr','fab fa-flickr'),
		16 => array('twitch','Twitch','fab fa-twitch'),
		17 => array('steam','Steam','fab fa-steam'),
		18 => array('imdb','IMDB','fab fa-imdb'), 
		19 => array('whatsapp','Whatsapp','fab fa-whatsapp'), 
		20 => array('www','WWW','fas fa-external-link-square-alt'),

	);

	$social = array_merge($social, $default);

	//check if there are custom social networks added in settings
	$options = get_option('tshowcase-settings');
	if(isset($options['tshowcase_social_networks']) && $options['tshowcase_social_networks'] != ''){
		$newarray = str_getcsv($options['tshowcase_social_networks'],';');
		if(is_array($newarray)){
			$formatted = array();
			foreach ($newarray as $key => $value) {
				if($value!=''){
					$fieldinfo = str_getcsv($value,',');
					if(isset($fieldinfo[2])){
						$formatted[trim($fieldinfo[0])] = array(trim($fieldinfo[0]),$fieldinfo[1],$fieldinfo[2]);
					}
				}
			}


			$social = array_merge($social,$formatted);

		}
	}

	return $social;

}


//ICONS
//see more at http://fortawesome.github.io/Font-Awesome/icons/
$ts_small_icons = apply_filters('tshowcase_default_icons',array());
add_filter('tshowcase_default_icons','tshowcase_default_icons');
function tshowcase_default_icons($icons){

	$default = array(
		'title' => 'fas fa-user',
		'groups' => 'fas fa-align-justify',
		'taxonomy' => 'fas fa-align-justify',
		'ctaxonomy' => 'fas fa-align-justify',
		'dtaxonomy' => 'fas fa-align-justify',
	);

	return $default;
}


//Labels

$ts_labels = array (

	'titles' => array(
				'info' => __('Aditional Information','tshowcase'),
				'social' => __('Social Profile Links','tshowcase')	
				),
	'help' => array(
				'social' => __('Use the complete URL to the profile page. Example: http://www.facebook.com/profile','tshowcase')	
				),
	
	'html' => array (
				'key' => 'html',
				'meta_name' => '_tsbio',
				'label' => __('Free HTML','tshowcase'),
				'description' => __('Short bio or tag line. You can use HTML code here.','tshowcase')
				),
	

	'name' => array (
				'key' => 'name',
				'meta_name' => 'title',
				'label' => __('Name/Title','tshowcase'),
				'description' => __('Name of the entry.','tshowcase')
				),
	'photo' => array (
				'key' => 'photo',
				'meta_name' => 'featured_image',
				'label' => __('Photo/Image','tshowcase'),
				'description' => __('Featured Image of the entry.','tshowcase')
				),

	'photoshape' => array (
				'key' => 'photoshape',
				'meta_name' => 'imageshape',
				'label' => __('Image Shape','tshowcase'),
				'description' => __('Shape of Featured Image of the entry.','tshowcase')
				),

	'smallicons' => array (
				'key' => 'smallicons',
				'label' => __('Small Icons','tshowcase'),
				'description' => __('Small CSS Icons.','tshowcase')
				),
	'socialicons' => array (
				'key' => 'socialicons',
				'label' => __('Social Icons','tshowcase'),
				'description' => __('Social Icons.','tshowcase')
				),
	'filter' => array (
				'label' => __('Filter','tshowcase'),
				'all-entries-label' => __('All','tshowcase'),
	),
	'filter-source' => array (
				'label' => __('Filter Source','tshowcase'),
	),
	'search' => array (
				'all-taxonomies' => __('All','tshowcase'),
				'search' => __('Search','tshowcase'),
				'results-for' => __('Results for ','tshowcase')
		),
	'pagination' => array (
				'next_page' => __('Next Page >','tshowcase'),
				'previous_page' => __('< Previous Page','tshowcase'),
				
		)

);

//Change to false if you don't want the help text on the title input to be changed on the Add New Entry screen
$ts_change_default_title_en = false;


//array of styles for the images and text
//takes the corresponding shortcode code and the css class
//wrap styles for tables and grid should go here also

$ts_wrapstyles = array(
	'normal-float' => 'ts-normal-float-wrap',
	'1-columns' => 'ts-responsive-wrap',
	'2-columns' => 'ts-responsive-wrap',
	'3-columns' => 'ts-responsive-wrap',
	'4-columns' => 'ts-responsive-wrap',
	'5-columns' => 'ts-responsive-wrap',
	'6-columns' => 'ts-responsive-wrap',
	'retro-box-theme' => 'ts-retro-style',
	'badge-theme' => 'ts-badge-style',
	'white-box-theme' => 'ts-white-box-style',
	'card-theme' => 'ts-theme-card-style',
	'white-card-theme' => 'ts-theme-white-card-style',
	'odd-colored' => 'ts-table-odd-colored'
	);


$ts_boxstyles = array(
	'img-left'=>'ts-float-left',
	'img-right'=>'ts-float-right',
	'normal-float' => 'ts-normal-float',
	'1-column' => 'ts-col_1',
	'2-columns' => 'ts-col_2',
	'3-columns' => 'ts-col_3',
	'4-columns' => 'ts-col_4',
	'5-columns' => 'ts-col_5',
	'6-columns' => 'ts-col_6'
	);
	
$ts_innerboxstyles = array(
	'img-left'=>'ts-float-left',
	'img-right'=>'ts-float-right'
	);

$ts_txtstyles = array(
	'text-left'=>'ts-align-left',
	'text-right'=>'ts-align-right',
	'text-center'=>'ts-align-center'
	);

$ts_imgstyles = array(
		'img-rounded'=>'ts-rounded',
		'img-circle'=>'ts-circle',
		'img-square'=>'ts-square',
		'img-grayscale' =>'ts-grayscale',
		'img-grayscale-shadow' =>'ts-grayscale-shadow',
		'img-shadow' =>'ts-shadow',
		'img-left' =>'ts-img-left',
		'img-right' =>'ts-img-right',
		'img-white-border' => 'ts-white-border',
		'img-hover-zoom' => 'ts-hover-zoom'
		);

$ts_infostyles = array(
	'img-left'=>'ts-float-left',
	'img-right'=>'ts-float-right'
	);
	
$ts_pagerstyles = array(
	'thumbs-left'=>'ts-pager-left',
	'thumbs-right'=>'ts-pager-right',
	'thumbs-below'=>'ts-pager-below',
	'thumbs-above'=>'ts-pager-above'
	);

$ts_pagerboxstyles = array(
	'thumbs-left'=>'ts-pager-box-right',
	'thumbs-right'=>'ts-pager-box-left',
	'thumbs-below'=>'ts-pager-box-above',
	'thumbs-above'=>'ts-pager-box-below'
	);





$ts_theme_names = array (

        'grid' => array(
                        
                        'default' => array (
                                            'key' => 'default',
                                            'name' => 'tshowcase-default-style',
                                            'link' => 'css/normal.css',
                                            'label' => __('Default','tshowcase')
                                            ),
                        'badge-theme' => array (
                                            'key' => 'badge-theme',
                                            'name' => 'tshowcase-badge-style',
                                            'link' => 'css/badge.css',
                                            'label' => __('Blue Badge Title','tshowcase')
                                            
                                            ),

                        'retro-box-theme' => array (
                                            'key' => 'retro-box-theme',
                                            'name' => 'tshowcase-retro-style',
                                            'link' => 'css/retro.css',
                                            'label' => __('Retro boxes','tshowcase')
                                            
                                            ),
                        'white-box-theme' => array (
                                            'key' => 'white-box-theme',
                                            'name' => 'tshowcase-white-box-style',
                                            'link' => 'css/white-box.css',
                                            'label' => __('White Box with Shadow','tshowcase')
                                            ),
                        'card-theme' => array (
                                            'key' => 'card-theme',
                                            'name' => 'tshowcase-card-theme-style',
                                            'link' => 'css/theme-card.css',
                                            'label' => __('Simple Card','tshowcase')
                                            ),
                        'white-card-theme' => array (
                                            'key' => 'white-card-theme',
                                            'name' => 'tshowcase-white-card-theme-style',
                                            'link' => 'css/theme-card.css',
                                            'label' => __('Simple White Card','tshowcase')
                                            )
                        ),
                        
                    'hover' => array(
                                
                                'default' => array (
                                                    'key' => 'default',
                                                    'name' => 'tshowcase-default-hover-style',
                                                    'link' => 'css/normal-hover.css',
                                                    'label' => __('Default','tshowcase')
                                                    ),
                                'white-hover' => array (
                                                    'key' => 'white-hover',
                                                    'name' => 'tshowcase-white-hover-style',
                                                    'link' => 'css/white-hover.css',
                                                    'label' => __('White Hover','tshowcase')
                                                    
                                                    )
                                ),    
                    'table' => array(
                                
                                'default' => array (
                                                    'key' => 'default',
                                                    'name' => 'tshowcase-default-table-style',
                                                    'link' => 'css/table.css',
                                                    'label' => __('Default','tshowcase')
                                                    ),
                                'odd-colored' => array (
                                                    'key' => 'odd-colored',
                                                    'name' => 'tshowcase-odd-colored-table-style',
                                                    'link' => 'css/table-odd-colored.css',
                                                    'label' => __('Odd Rows Colored','tshowcase')
                                                    
                                                    )
                                ),    
                    'pager' => array(
                                
                                'default' => array (
                                                    'key' => 'default',
                                                    'name' => 'tshowcase-default-pager-style',
                                                    'link' => 'css/pager.css',
                                                    'label' => __('Default','tshowcase')
                                                    )
                                )    

    );


//New Custom Fields Array - Under Development

add_filter('tshowcase_custom_fields','tshowcase_default_custom_fields');
function tshowcase_default_custom_fields($tshowcase_fields){

	if(!is_array($tshowcase_fields)){
		$tshowcase_fields = array();
	}

	$custom_fields = array(

		'freehtml' => array(
			'key' => '_tsfreehtml',
			'label' => __('Free HTML','tshowcase'),
			'description' => __('Short bio or tag line. You can use HTML code here.','tshowcase'),
			'icon' => 'fas fa-align-justify',
			'type' => 'textarea',
			'format' => 'text',
			'container' => '<div class="tshowcase-single-freehtml">%s</div>',
			'property' => 'description'
			),

		'position' => array(
			'key' => '_tsposition',
			'label' => __('Job Title','tshowcase'),
			'description' => __('The job description, position or functions of this member.','tshowcase'),
			'icon' => 'fas fa-chevron-circle-right',
			'type' => 'text',
			'format' => 'text',
			'container' => '<div itemprop="jobTitle" class="tshowcase-single-position">%s</div>',
			'property' => 'jobTitle'
			),

		'email' => array(
			'key' => '_tsemail',
			'label' => __('Email','tshowcase'),
			'description' => __('Contact email.','tshowcase'),
			'icon' => 'fas fa-envelope',
			'type' => 'text',
			'format' => 'email',
			'container' => '<div class="tshowcase-single-email" itemprop="email">%s</div>',
			'property' => 'email',
			),

		'location' => array(
			'key' => '_tslocation',
			'label' => __('Location','tshowcase'),
			'description' => __('Location/Origin/Address.','tshowcase'),
			'icon' => 'fas fa-map-marker',
			'type' => 'text',
			'format' => 'text',
			'container' => '<div class="tshowcase-single-location">%s</div>',
			'property' => 'address'
			),

		'telephone' => array (
			'key' => '_tstel',
			'label' => __('Telephone','tshowcase'),
			'description' => __('Telephone contact.','tshowcase'),
			'type' => 'text',
			'format' => 'tel',
			'icon' => 'fas fa-phone-square',
			'container' => '<div class="tshowcase-single-telephone">%s</div>',
			'property' => 'telephone'
			),

		'website' => array (
			'key' => '_tspersonal',
			'label' => __('Personal Website','tshowcase'),
			'description' => __('URL to personal website.','tshowcase'),
			'icon' => 'fas fa-external-link-square-alt',
			'type' => 'text',
			'format' => 'url',
			'anchor' => 'websiteanchor',
			'container' => '<div class="tshowcase-single-website">%s</div>',
			'property' => 'url'
			),

		'websiteanchor' => array (
			'key' => '_tspersonalanchor',
			'label' => __('Personal Website Anchor Text','tshowcase'),
			'description' => __('Text to display for the link. If blank URL will be used.','tshowcase'),
			'icon' => 'fas fa-external-link',
			'type' => 'text',
			'hide' => true
			),

		'user' => array (
			'key' => '_tsuser',
			'label' => __('User/Author Profile','tshowcase'),
			'description' => __('If this member is associated with a user account select it here. Might be used to fetch latest published posts in the single member page.','tshowcase'),
			'type' => 'users',
			'hide' => true
			),

	);

	$tshowcase_fields = array_merge($custom_fields,$tshowcase_fields);


	//Check if there's any other custom field in the advanced settings
	$options = get_option('tshowcase-settings');
	if(isset($options['tshowcase_custom_fields']) && $options['tshowcase_custom_fields'] != ''){
		$newarray = str_getcsv($options['tshowcase_custom_fields'],';');
		if(is_array($newarray)){
			$formatted = array();
			foreach ($newarray as $key => $value) {
				if($value!=''){
					$fieldinfo = str_getcsv($value,',');
					if(isset($fieldinfo[4])){

						$formatted[trim($fieldinfo[0])] = array (
							'key' => '_ts'.trim($fieldinfo[0]),
							'label' => $fieldinfo[1],
							'description' => $fieldinfo[2],
							'type' => $fieldinfo[3],
							'icon' => $fieldinfo[4]
							);

					}
					
					//format
					if(isset($fieldinfo[5])){
						$formatted[trim($fieldinfo[0])]['format'] = $fieldinfo[5];
					}
					//container
					if(isset($fieldinfo[6])){
						$formatted[trim($fieldinfo[0])]['container'] = $fieldinfo[6];
					}
					//structural data property
					if(isset($fieldinfo[7])){
						$formatted[trim($fieldinfo[0])]['property'] = $fieldinfo[7];
					}
				}
			}


			$tshowcase_fields = array_merge($tshowcase_fields,$formatted);

		}
	}



	return $tshowcase_fields;

}



//Order for Fields
$ts_content_order = apply_filters('tshowcase_content_order', array());
add_filter('tshowcase_content_order','tshowcase_content_order');
function tshowcase_content_order($tshowcase_fields){

	$ts_content_order = array(
		1 => 'title',
		2 => 'groups',
		3 => 'taxonomy',
		4 => 'ctaxonomy',
		5 => 'dtaxonomy',
		6 => 'position',
		7 => 'location',
		8 => 'telephone',
		9 => 'email',
		10 => 'freehtml',
		11 => 'website'	
	);

	return $ts_content_order;

}

$ts_table_content_order = apply_filters('tshowcase_table_content_order', array());
add_filter('tshowcase_table_content_order','tshowcase_table_content_order');
function tshowcase_table_content_order($tshowcase_fields){

	$ts_content_order = array(
		1 => 'title',
		2 => 'groups',
		3 => 'taxonomy',
		4 => 'ctaxonomy',
		5 => 'dtaxonomy',
		6 => 'position',
		7 => 'location',
		8 => 'telephone',
		9 => 'email',
		10 => 'freehtml',
		11 => 'website',
		12 => 'social',	
	);

	return $ts_content_order;

}


//Example on how to add new custom fields
/*
add_filter('tshowcase_custom_fields','tshowcase_secondary_custom_fields');

function tshowcase_secondary_custom_fields($tshowcase_fields){

	$extrafields = array(

		'fax' => array (
			'key' => '_tsfax',
			'label' => __('Fax','tshowcase'),
			'description' => __('Fax number','tshowcase'),
			'type' => 'text',
			'icon' => 'fas fa-fax',
			'format' => 'tel',
			'container' => '<div class="tshowcase-single-fax">%s</div>',
			'property' => 'faxNumber',
			),
		'birthday' => array (
			'key' => '_tsbirthday',
			'label' => __('Data of Birth','tshowcase'),
			'description' => __('Date of birth with the format Y-m-d','tshowcase'),
			'type' => 'text',
			'icon' => 'fas fa-user',
			'property' => 'birthDate'
			),

		);

	$tshowcase_fields = array_merge($tshowcase_fields,$extrafields);
	return $tshowcase_fields;

}
*/


//Example on how to set custom order
/*
add_filter('tshowcase_content_order','tshowcase_custom_content_order');
function tshowcase_custom_content_order($tshowcase_fields){

	$ts_content_order = array(
		0 => 'social',
		1 => 'email',
		2 => 'groups',
		3 => 'freehtml',
		4 => 'email',	
	);

	return $ts_content_order;

}*/


//Example on how to add custom social network
/*
add_filter('tshowcase_social_networks','tshowcase_custom_social');
function tshowcase_custom_social($social){

	array_push($social, array('jsfiddle','JSfiddle','fab fa-jsfiddle'));

	return $social;

}
*/

//example on how to change global order
/*
add_filter('tshowcase_display_order','tshowcase_custom_display_order');
function tshowcase_custom_display_order($order){

	$new = array(
		1 => 'social',
		2 => 'details',
		3 => 'name'	
	);

	return $new;

}
*/


?>