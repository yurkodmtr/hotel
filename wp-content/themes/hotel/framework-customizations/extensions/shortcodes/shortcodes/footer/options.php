<?php if (!defined('FW')) {
	die('Forbidden');
}

$options = array(
	'logo'   => array(
	    'type'  => 'upload',
	    'label' => __('Logo img (45*45px)', '{domain}'),
	    'images_only' => true,
	),
	'copy_text' => array(
		'label'        => __('Копирайт', 'fw'),
		'type'         => 'text'
	),
	'copy_item_1_text' => array(
		'label'        => __('Копирайт ссылка 1 текст', 'fw'),
		'type'         => 'text'
	),
	'copy_item_1_link' => array(
		'label'        => __('Копирайт ссылка 1 линк', 'fw'),
		'type'         => 'text'
	),
	'copy_item_2_text' => array(
		'label'        => __('Копирайт ссылка 2 текст', 'fw'),
		'type'         => 'text'
	),
	'copy_item_2_link' => array(
		'label'        => __('Копирайт ссылка 2 линк', 'fw'),
		'type'         => 'text'
	),
	'info' => array(
		'label'        => __('Инфо', 'fw'),
		'type'         => 'text'
	),
	'info_phone' => array(
		'label'        => __('Инфо телефон', 'fw'),
		'type'         => 'text'
	),
	'info_email' => array(
		'label'        => __('Инфо email', 'fw'),
		'type'         => 'text'
	),
	'soc' => array (
		'type'          => 'addable-popup',
		'label'         => __( 'Add soc items', 'fw' ),
		'popup-title'   => __( 'Add/Edit soc items', 'fw' ),
		'desc'          => __( 'Create your soc items', 'fw' ),
		'template'      => '{{= link}}',
		'popup-options' => array(	
			'link' => array(
				'label'        => __('Link', '{domain}'),
				'type'         => 'text'
			),
			'logo'   => array(
			    'type'  => 'upload',
			    'label' => __('Soc img (60*60px)', '{domain}'),
			    'images_only' => true,
			),			
		),
	),
);
