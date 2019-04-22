<?php if (!defined('FW')) {
	die('Forbidden');
}

$options = array(
	'block_1_title' => array(
		'label'        => __('Блок 1 заголовок', 'fw'),
		'type'         => 'text'
	),
	'block_1' => array (
		'type'          => 'addable-popup',
		'label'         => __( 'Add link items', 'fw' ),
		'popup-title'   => __( 'Add/Edit link items', 'fw' ),
		'desc'          => __( 'Create your link items', 'fw' ),
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
	'block_2_title' => array(
		'label'        => __('Блок 2 заголовок', 'fw'),
		'type'         => 'text'
	),
	'block_2' => array (
		'type'          => 'addable-popup',
		'label'         => __( 'Add link items', 'fw' ),
		'popup-title'   => __( 'Add/Edit link items', 'fw' ),
		'desc'          => __( 'Create your link items', 'fw' ),
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
	'block_3_title' => array(
		'label'        => __('Блок 3 заголовок', 'fw'),
		'type'         => 'text'
	),
	'block_3' => array (
		'type'          => 'addable-popup',
		'label'         => __( 'Add link items', 'fw' ),
		'popup-title'   => __( 'Add/Edit link items', 'fw' ),
		'desc'          => __( 'Create your link items', 'fw' ),
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
	'search_text' => array(
		'label'        => __('Кнопка поиска текст', 'fw'),
		'type'         => 'text'
	),
	'search_link' => array(
		'label'        => __('Кнопка поиска ссылка', 'fw'),
		'type'         => 'text'
	),
	'subscribe_title' => array(
		'label'        => __('Форма подписки тайтл', 'fw'),
		'type'         => 'text'
	),
	'subscribe_subtitle' => array(
		'label'        => __('Форма подписки сабтайтл', 'fw'),
		'type'         => 'text'
	),
	'subscribe_notice' => array(
		'label'        => __('Форма подписки подпись', 'fw'),
		'type'         => 'text'
	),
);
