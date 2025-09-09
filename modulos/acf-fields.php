<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_eventos',
	'title' => 'Campos do Evento',
	'fields' => array(
		array(
			'key' => 'field_data_do_evento',
			'label' => 'Data do Evento',
			'name' => 'data_do_evento',
			'type' => 'date_picker',
			'required' => 1,
			'display_format' => 'd/m/Y',
			'return_format' => 'Y-m-d',
		),
		array(
			'key' => 'field_local',
			'label' => 'Local',
			'name' => 'local',
			'type' => 'text',
			'required' => 1,
		),
		array(
			'key' => 'field_organizador',
			'label' => 'Organizador',
			'name' => 'organizador',
			'type' => 'text',
			'required' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'eventos',
			),
		),
	),
	'position' => 'normal',
	'style' => 'default',
	'active' => true,
));

endif;
