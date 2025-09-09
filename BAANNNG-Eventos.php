<?php
/**
 * Plugin Name: BAANNNG · Eventos
 * Plugin URI: https://baannng.com
 * Description: Sistema de gestão de eventos (com ACF) criado como parte do desafio da LBC. Uso restrito.
 * Version: 1.2.0
 * Author: Abel Pinto
 * Author URI: https://baannng.com
 * License: Proprietary
 * License URI: https://baannng.com
 * Text Domain: baannng-eventos
 */

if (!defined('ABSPATH')) exit;

// Diretório base dos módulos
$modulos_dir = plugin_dir_path(__FILE__) . 'modulos/';

// ------------------------------
// Carregar módulos essenciais
// ------------------------------
require_once $modulos_dir . 'loader.php';        // Loader com CPT, ACF e shortcodes
require_once $modulos_dir . 'desativar.php';     // Limpeza ao desativar

// ------------------------------
// Registrar bloco de menu do cabeçalho (FSE)
// ------------------------------
add_action('init', function() {
	if (function_exists('register_block_type_from_metadata')) {
		register_block_type_from_metadata(plugin_dir_path(__FILE__) . 'blocks/menu-cabecalho');
	}
});





// ------------------------------
// Registrar hook de desativação
// ------------------------------
register_deactivation_hook(__FILE__, 'eventos_plugin_handle_deactivate');

// ------------------------------
// Template single para Eventos
// ------------------------------
add_filter('template_include', function($template){
	if(is_singular('eventos')){
		$plugin_template = plugin_dir_path(__FILE__) . 'templates/single-eventos.php';
		if(file_exists($plugin_template)) return $plugin_template;
	}
	return $template;
});

// ------------------------------
// Hook de ativação
// ------------------------------
// ------------------------------
// Hook de ativação completo
// ------------------------------
register_activation_hook(__FILE__, function() use ($modulos_dir) {

	// 0. Registrar CPT temporariamente para flush
	register_post_type('eventos', [
		'labels' => [
			'name' => 'Eventos',
			'singular_name' => 'Evento',
		],
		'public' => true,
		'has_archive' => true,
		'rewrite' => ['slug' => 'eventos'],
		'supports' => ['title','editor','thumbnail'],
	]);

	// 1. Criar página "Todos os Eventos" se não existir
	if (!get_option('eventos_plugin_page_created')) {
		$page_id = wp_insert_post([
			'post_title'   => 'Todos os Eventos',
			'post_content' => '[eventos_todos]',
			'post_status'  => 'publish',
			'post_type'    => 'page',
		]);
		if($page_id) update_option('eventos_plugin_page_created', $page_id);
	}

	// 2. Upload automático das imagens
	require_once $modulos_dir . 'carga-imagens.php';
	eventos_plugin_upload_images();

	// 3. Criar posts de teste
	require_once $modulos_dir . 'seed-eventos.php';
	eventos_plugin_seed_events();

	// 4. Flush de permalinks
	flush_rewrite_rules();

	// 5. Guardar flag para avisar no admin
	update_option('eventos_flush_done', true);
});

// ------------------------------
// Admin notice para avisar flush
// ------------------------------
add_action('admin_notices', function() {
	if (get_option('eventos_flush_done')) {
		echo '<div class="notice notice-success is-dismissible">
				<p>Permalinks do BAANNNG · Eventos foram atualizados com sucesso!</p>
			  </div>';
		// Remover a flag para não mostrar novamente
		delete_option('eventos_flush_done');
	}
});


// ------------------------------
// Submenu Changelog dentro do menu Eventos
// ------------------------------
add_action('admin_menu', function() {
	add_submenu_page(
		'edit.php?post_type=eventos', // Slug do menu principal do CPT
		'Changelog BAANNNG',          // Título da página
		'Changelog',                  // Título do submenu
		'manage_options',             // Permissões
		'baannng-changelog',          // Slug do submenu
		'baannng_changelog_page'      // Função que gera o conteúdo
	);
});

// Função para exibir o Changelog
function baannng_changelog_page() {
	$file = plugin_dir_path(__FILE__) . 'changelog.md';
	if (!file_exists($file)) {
		echo '<div class="notice notice-error"><p>Changelog não encontrado.</p></div>';
		return;
	}

	$markdown = file_get_contents($file);

	if (!function_exists('wp_markdown')) {
		$html = '<pre>' . esc_html($markdown) . '</pre>';
	} else {
		$html = wp_markdown($markdown);
	}

	echo '<div class="wrap">';
	echo '<h1>Changelog BAANNNG · Eventos</h1>';
	echo $html;
	echo '</div>';
}

// ------------------------------
// Links na página de plugins: Configurações e Changelog
// ------------------------------
add_filter('plugin_row_meta', function($links, $file) {
	if ($file === plugin_basename(__FILE__)) {
		// Link para Configurações
		$links[] = '<a href="' . admin_url('edit.php?post_type=eventos&page=eventos-plugin-settings') . '">Configurações</a>';

		// Link para Changelog
		$links[] = '<a href="' . admin_url('edit.php?post_type=eventos&page=baannng-changelog') . '">Changelog</a>';
	}
	return $links;
}, 10, 2);
