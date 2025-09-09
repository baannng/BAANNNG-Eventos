<?php
add_action('init', function() {
	register_post_type('eventos', [
		'labels' => [
			'name' => 'Eventos',
			'singular_name' => 'Evento',
			'add_new_item' => 'Adicionar Novo Evento',
			'edit_item' => 'Editar Evento',
			'all_items' => 'Todos os Eventos',
		],
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-calendar-alt',
		'supports' => ['title', 'editor', 'thumbnail'],
		'show_in_rest' => true,
	]);
});
