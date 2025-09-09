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

	// CSS customizado
	$output = '<style>
		.evento-card-shadow {
			box-shadow: rgba(0, 0, 0, 0.2) 0px 0px 9px 1px !important;
			border: none;
		}
		.evento-card-shadow .card-body {
			line-height: 1.6; /* aumenta o espaço entre linhas */
		}
		.evento-card-shadow .card-img-top img {
			padding: 1rem; /* padding em toda a volta da imagem */
		}
	</style>';

	$output .= '<div class="container my-4"><div class="row g-5 justify-content-center">';

	while($query->have_posts()): $query->the_post();
		$data = get_field('data_do_evento');
		$local = get_field('local');
		$organizador = get_field('organizador');

		// Imagem com crop central e padding uniforme
		if (has_post_thumbnail()) {
			$thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium', [
				'class'=>'img-fluid w-100 h-100',
				'style'=>'object-fit:cover; object-position:center;'
			]);
		} else {
			$thumbnail = '';
		}

		$output .= '<div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center mb-5">';
		$output .= '<a href="'.get_permalink().'" class="text-decoration-none text-dark">';

		// Card com sombra, altura uniforme e largura controlada
		$output .= '<div class="card h-100 d-flex flex-column evento-card-shadow" style="max-width:320px;">';

		if($thumbnail) {
			$output .= '<div class="card-img-top overflow-hidden" style="height:200px;">'.$thumbnail.'</div>';
		}

		$output .= '<div class="card-body flex-grow-1 d-flex flex-column">';
		$output .= '<h5 class="card-title">'.get_the_title().'</h5>';
		$output .= '<p class="card-text mb-0"><strong>Data:</strong> '.esc_html($data).'<br>';
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
