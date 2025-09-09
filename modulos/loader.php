<?php
if (!defined('ABSPATH')) exit;

// Diretório base dos módulos
$modulos_dir = plugin_dir_path(__FILE__);

// Carregar módulos essenciais
require_once $modulos_dir . 'cpt.php';             // Custom Post Type
require_once $modulos_dir . 'acf-fields.php';     // Campos ACF Pro
require_once $modulos_dir . 'shortcode.php';      // Shortcodes
require_once $modulos_dir . 'enqueue.php';        // Scripts e estilos
require_once $modulos_dir . 'admin-notice.php';   // Admin notice
require_once $modulos_dir . 'admin-settings.php'; // Página de configurações
require_once $modulos_dir . 'desativar.php';      // Limpeza ao desativar

