<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Enqueue scripts e estilos
add_action('wp_enqueue_scripts', function() {
	// Bootstrap CSS
	wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', [], '5.3.2');

	// Bootstrap JS (opcional, se necessário)
	wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', ['jquery'], '5.3.2', true);

	// Estilos do plugin
	$plugin_css = plugin_dir_url(__FILE__) . '../assets/style.css';
	if(file_exists(plugin_dir_path(__FILE__) . '../assets/style.css')) {
		wp_enqueue_style('eventos-plugin-css', $plugin_css, [], '1.0');
	}

	// Scripts do plugin
	$plugin_js = plugin_dir_url(__FILE__) . '../assets/script.js';
	if(file_exists(plugin_dir_path(__FILE__) . '../assets/script.js')) {
		wp_enqueue_script('eventos-plugin-js', $plugin_js, ['jquery'], '1.0', true);
	}
});
