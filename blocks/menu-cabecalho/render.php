<?php
if (!defined('ABSPATH')) exit;

function eventos_menu_cabecalho_render($attributes) {
	$links = isset($attributes['links']) ? $attributes['links'] : [];
	$align = isset($attributes['align']) ? $attributes['align'] : 'left';

	$justify_class = 'justify-content-start';
	if ($align === 'center') $justify_class = 'justify-content-center';
	if ($align === 'right') $justify_class = 'justify-content-end';

	$html = '<nav class="evento-mini-menu d-flex ' . esc_attr($justify_class) . '">';
	foreach ($links as $link) {
		$label = isset($link['label']) ? $link['label'] : '';
		$url = isset($link['url']) ? $link['url'] : '#';
		$html .= '<a href="' . esc_url($url) . '" class="text-decoration-none text-dark me-3" style="text-transform:uppercase; font-size:10px;">' . esc_html($label) . '</a>';
	}
	$html .= '</nav>';

	return $html;
}
