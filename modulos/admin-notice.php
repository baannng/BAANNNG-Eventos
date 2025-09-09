<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_notices', function() {
	$page_id = get_transient('eventos_plugin_page_created');
	$images_uploaded = get_transient('eventos_plugin_images_uploaded');
	$seeded_posts = get_transient('eventos_plugin_seeded_posts');

	if ($page_id || $images_uploaded || $seeded_posts) {
		echo '<div class="notice notice-success is-dismissible custom-eventos-notice"><p>';

		// Página "Todos os Eventos"
		if ($page_id) {
			$page = get_post($page_id);
			if ($page) {
				$page_title = esc_html($page->post_title);
				echo "A página <strong>{$page_title}</strong> foi criada com sucesso.<br>";
			}
			delete_transient('eventos_plugin_page_created');
		}

		// Imagens carregadas
		if ($images_uploaded) {
			echo "{$images_uploaded} imagens foram carregadas na biblioteca de multimédia.<br>";
			delete_transient('eventos_plugin_images_uploaded');
		}

		// Eventos de simulação
		if ($seeded_posts) {
			echo "Foram criados {$seeded_posts} eventos de simulação com ACF Pro preenchido.<br>";
			delete_transient('eventos_plugin_seeded_posts');
		}

		echo 'Para temas FSE, aplique o bloco Gutenberg <strong>"Menu BNGEv"</strong> no Editor do Tema.<br>';
		echo 'Para temas clássicos, adicione a página ao menu via Appearance → Menus.';
		echo '</p></div>';
	}
});

// CSS leve para o notice
add_action('admin_head', function() {
	echo '<style>
		.custom-eventos-notice {
			background-color: #fff3cd; /* amarelo suave */
			border-radius: 10px;       /* cantos arredondados */
		}
	</style>';
});

// Fade out automático após 30 segundos
add_action('admin_footer', function() {
	?>
	<script>
		jQuery(document).ready(function($){
			setTimeout(function(){
				$('.custom-eventos-notice').fadeOut('slow');
			}, 30000); // 30 segundos
		});
	</script>
	<?php
});
