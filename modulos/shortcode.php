<?php
add_shortcode('eventos_todos', function($atts){
	$atts = shortcode_atts(['limite'=>-1], $atts, 'eventos_todos');

	$query = new WP_Query([
		'post_type'=>'eventos',
		'posts_per_page'=>$atts['limite'],
		'orderby'=>'meta_value',
		'meta_key'=>'data_do_evento',
		'order'=>'ASC'
	]);

	if(!$query->have_posts()) return '<p>Nenhum evento disponível.</p>';

	$output = '<div class="container my-4"><div class="row g-4">';
	while($query->have_posts()): $query->the_post();
		$data = get_field('data_do_evento');
		$local = get_field('local');
		$organizador = get_field('organizador');
		$thumbnail = has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'medium', ['class'=>'img-fluid mb-2']) : '';

		$output .= '<div class="col-md-4">';
		$output .= '<a href="'.get_permalink().'" class="text-decoration-none text-dark">';
		$output .= '<div class="card h-100">';
		if($thumbnail) $output .= '<div class="card-img-top">'.$thumbnail.'</div>';
		$output .= '<div class="card-body">';
		$output .= '<h5 class="card-title">'.get_the_title().'</h5>';
		$output .= '<p class="card-text"><strong>Data:</strong> '.esc_html($data).'<br>';
		$output .= '<strong>Local:</strong> '.esc_html($local).'<br>';
		$output .= '<strong>Organizador:</strong> '.esc_html($organizador).'</p>';
		$output .= '</div>'; // card-body
		$output .= '</div>'; // card
		$output .= '</a>';
		$output .= '</div>'; // col
	endwhile;
	wp_reset_postdata();
	$output .= '</div></div>';

	return $output;
});
