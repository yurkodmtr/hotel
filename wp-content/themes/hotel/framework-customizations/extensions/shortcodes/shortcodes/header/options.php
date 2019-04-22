<?php if (!defined('FW')) {
	die('Forbidden');
}

$options = array(
	'logo_img'   => array(
	    'type'  => 'upload',
	    'label' => __('Logo img (45*45px)', '{domain}'),
	    'images_only' => true,
	),
	'slogan' => array(
		'label'        => __('Slogan text', 'fw'),
		'type'         => 'text'
	),
	'menu_links' => array (
		'type'          => 'addable-popup',
		'label'         => __( 'Add menu items', 'fw' ),
		'popup-title'   => __( 'Add/Edit menu items', 'fw' ),
		'desc'          => __( 'Create your menu items', 'fw' ),
		'template'      => '{{= title}}',
		'popup-options' => array(	
			'title' => array(
				'label'        => __('Title', '{domain}'),
				'type'         => 'text'
			),
			'link' => array(
				'label'        => __('Link', '{domain}'),
				'type'         => 'text'
			),			
		),
	),
	'email' => array(
		'label'        => __('Email', 'fw'),
		'type'         => 'text'
	),
	'phone' => array(
		'label'        => __('Phone', 'fw'),
		'type'         => 'text'
	),
	'social' => array (
		'type'          => 'addable-popup',
		'label'         => __( 'Add social items', 'fw' ),
		'popup-title'   => __( 'Add/Edit social items', 'fw' ),
		'desc'          => __( 'Create your social items', 'fw' ),
		'template'      => '{{= link}}',
		'popup-options' => array(	
			'link' => array(
				'label'        => __('Link', '{domain}'),
				'type'         => 'text'
			),	
			'logo_img'   => array(
			    'type'  => 'upload',
			    'label' => __('Social img (28*28px)', '{domain}'),
			    'images_only' => true,
			),		
		),
	),
);
