<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function eventos_plugin_upload_images() {
	$asset_dir = plugin_dir_path(__FILE__) . '../assets/';
	$upload_dir = wp_upload_dir();
	$uploaded_ids = [];

	// Incluir funções de media
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/media.php');

	// Percorrer todas as imagens .jpg da pasta assets
	foreach (glob($asset_dir . '*.jpg') as $file) {
		$filename = basename($file);
		$dest = $upload_dir['path'] . '/' . $filename;

		// Copiar arquivo se não existir no upload
		if (!file_exists($dest)) {
			if (!copy($file, $dest)) continue; // pular se falhar
		}

		// Verificar se attachment já existe
		$existing = get_posts([
			'post_type'   => 'attachment',
			'meta_key'    => '_wp_attached_file',
			'meta_value'  => str_replace($upload_dir['basedir'] . '/', '', $dest),
			'numberposts' => 1,
		]);

		if (!empty($existing)) {
			$attach_id = $existing[0]->ID;
		} else {
			// Criar attachment
			$filetype = wp_check_filetype($filename);
			$attachment = [
				'post_mime_type' => $filetype['type'],
				'post_title'     => sanitize_file_name($filename),
				'post_content'   => '',
				'post_status'    => 'inherit'
			];

			$attach_id = wp_insert_attachment($attachment, $dest);
			if (!is_wp_error($attach_id)) {
				$attach_data = wp_generate_attachment_metadata($attach_id, $dest);
				wp_update_attachment_metadata($attach_id, $attach_data);
			}
		}

		if ($attach_id) $uploaded_ids[] = $attach_id;
	}

	// Guardar IDs no option para permitir limpeza posterior
	update_option('eventos_plugin_uploaded_images', $uploaded_ids);
	set_transient('eventos_plugin_images_uploaded', count($uploaded_ids), 60);

	return $uploaded_ids;
}
