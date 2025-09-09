<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;

// Verifica se a limpeza ao eliminar está ativa
$clean = get_option('eventos_plugin_clean_on_uninstall', false);
if (!$clean) return;

// ------------------------------
// 1. Remover posts de simulação
// ------------------------------
$seeded_ids = get_option('eventos_plugin_seeded_ids', []);
if (!empty($seeded_ids)) {
	foreach ($seeded_ids as $post_id) {
		if (get_post($post_id)) wp_delete_post($post_id, true);
	}
}

// ------------------------------
// 2. Remover página "Todos os Eventos"
// ------------------------------
$page_id = get_option('eventos_plugin_page_created');
if ($page_id && get_post($page_id)) wp_delete_post($page_id, true);

// ------------------------------
// 3. Remover imagens carregadas
// ------------------------------
$uploaded_ids = get_option('eventos_plugin_uploaded_images', []);
if (!empty($uploaded_ids)) {
	foreach ($uploaded_ids as $attachment_id) {
		if (get_post($attachment_id)) wp_delete_attachment($attachment_id, true);
	}
}

// ------------------------------
// 4. Limpar options do plugin
// ------------------------------
delete_option('eventos_plugin_seeded_ids');
delete_option('eventos_plugin_uploaded_images');
delete_option('eventos_plugin_page_created');
delete_option('eventos_plugin_seeded');
delete_option('eventos_plugin_clean_on_deactivate');
delete_option('eventos_plugin_clean_on_uninstall');
