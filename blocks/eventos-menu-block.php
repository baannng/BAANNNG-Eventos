<?php
// Regista o bloco dinâmico "Menu de Eventos"
function eventos_register_menu_block() {
	register_block_type('eventos/menu', [
		'render_callback' => 'eventos_menu_block_render',
		'attributes' => [
			'futuros' => ['type' => 'boolean', 'default' => false],
			'limite' => ['type' => 'number', 'default' => -1]
		]
	]);
}
add_action('init', 'eventos_register_menu_block');

function eventos_menu_block_render($attributes) {
	$atts = wp_parse_args($attributes, [
		'futuros' => false,
		'limite' => -1
	]);

	$meta_query = [];
	if ($atts['futuros']) {
		$meta_query[] = [
			'key' => 'data_evento',
			'value' => date('Ymd'),
			'compare' => '>=',
			'type' => 'DATE'
		];
	}

	$query = new WP_Query([
		'post_type' => 'eventos',
		'posts_per_page' => $atts['limite'],
		'orderby' => 'meta_value',
		'meta_key' => 'data_evento',
		'order' => 'ASC',
		'meta_query' => $meta_query
	]);

	if (!$query->have_posts()) return '<p>Nenhum evento disponível.</p>';

	$output = '<div class="container"><div class="row">';
	while ($query->have_posts()): $query->the_post();
		$data = get_field('data_evento');
		$thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium', ['class'=>'img-fluid mb-2']);

		$output .= '<div class="col-md-4 mb-4">';
		$output .= '<a href="' . get_permalink() . '">';
		$output .= $thumbnail;
		$output .= '<h5>' . get_the_title() . '</h5>';
		if ($data) $output .= '<p><strong>Data:</strong> ' . esc_html($data) . '</p>';
		$output .= '</a>';
		$output .= '</div>';
	endwhile;
	wp_reset_postdata();
	$output .= '</div></div>';

	return $output;
}
