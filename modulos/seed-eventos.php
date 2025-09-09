<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function eventos_plugin_seed_events() {
	// Evitar duplicar posts
	if (get_option('eventos_plugin_seeded')) return;

	// Obter imagens carregadas (do carga-imagens.php)
	$uploaded_ids = get_option('eventos_plugin_uploaded_images', []);
	$created_ids = [];

	// Criar 6 posts de eventos de simulação
	for ($i = 0; $i < 6; $i++) {
		$post_id = wp_insert_post([
			'post_title'   => 'Evento de Simulação ' . ($i + 1),
			'post_content' => "Look, just because I don't be givin' no man a foot massage don't make it right for Marsellus to throw Antwone into a glass motherfuckin' house, fuckin' up the way the nigger talks. Motherfucker do that shit to me, he better paralyze my ass, 'cause I'll kill the motherfucker, know what I'm sayin'?

The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother's keeper and the finder of lost children. And I will strike down upon thee with great vengeance and furious anger those who would attempt to poison and destroy My brothers. And you will know My name is the Lord when I lay My vengeance upon thee.

https://slipsum.com",
			'post_type'    => 'eventos',
			'post_status'  => 'publish',
		]);

		// Definir imagem de destaque se houver upload correspondente
		if (isset($uploaded_ids[$i])) {
			set_post_thumbnail($post_id, $uploaded_ids[$i]);
		}

		// Preencher campos ACF Pro
		if (function_exists('update_field')) {
			// update_field('data_do_evento', date('Y-m-d', strtotime("+$i days")), $post_id);

			// Data do evento (ACF)
			$data_evento = date('Y-m-d', strtotime("+$i days"));

			// Hora fixa 10:00 e minutos incrementais (passado/presente)
			$hour = 10;
			$minute = $i * 10;
			$post_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . " $hour:$minute:00"));

			// Atualiza ACF
			if (function_exists('update_field')) {
				update_field('data_do_evento', $data_evento, $post_id);
				update_field('local', 'Local ' . ($i + 1), $post_id);
				update_field('organizador', 'Organizador ' . ($i + 1), $post_id);
			}

			// Atualiza post_date no WordPress e força publish
			wp_update_post([
				'ID' => $post_id,
				'post_date' => $post_date,
				'post_date_gmt' => get_gmt_from_date($post_date),
				'post_status' => 'publish' // força já publicado
			]);

			update_field('local', 'Local ' . ($i + 1), $post_id);
			update_field('organizador', 'Organizador ' . ($i + 1), $post_id);
		}

		$created_ids[] = $post_id;
	}

	// Guardar IDs para limpeza posterior
	update_option('eventos_plugin_seeded_ids', $created_ids);
	update_option('eventos_plugin_seeded', true);

	// Mostrar admin notice de sucesso
	set_transient('eventos_plugin_seeded_notice', count($created_ids), 60);
}

// Mostrar aviso no admin
add_action('admin_notices', function() {
	if ($count = get_transient('eventos_plugin_seeded_notice')) {
		echo '<div class="notice notice-success is-dismissible">';
		echo '<p>Foram criados ' . intval($count) . ' eventos de simulação com imagens de destaque e campos ACF.</p>';
		echo '</div>';
		delete_transient('eventos_plugin_seeded_notice');
	}
});
