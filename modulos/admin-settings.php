<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Adiciona submenu "Configurações" no menu do CPT "Eventos"
add_action('admin_menu', function() {
	add_submenu_page(
		'edit.php?post_type=eventos',   // parent slug
		'Configurações do Plugin',      // page title
		'Configurações',                // menu title
		'manage_options',               // capability
		'eventos-plugin-settings',      // menu slug
		'eventos_plugin_settings_page'  // callback
	);
});

// Função de renderização da página de configurações
function eventos_plugin_settings_page() {
	// Salvar opções
	if (isset($_POST['submit'])) {
		check_admin_referer('eventos_plugin_settings_nonce');
		$clean_deactivate = !empty($_POST['eventos_plugin_clean_deactivate']);
		$clean_uninstall  = !empty($_POST['eventos_plugin_clean_uninstall']);

		update_option('eventos_plugin_clean_on_deactivate', $clean_deactivate);
		update_option('eventos_plugin_clean_on_uninstall', $clean_uninstall);

		echo '<div class="updated notice is-dismissible"><p>Opções do plugin salvas com sucesso.</p></div>';
	}

	// Ler opções atuais
	$clean_deactivate = get_option('eventos_plugin_clean_on_deactivate', false);
	$clean_uninstall  = get_option('eventos_plugin_clean_on_uninstall', false);
	?>
	<div class="wrap">
		<h1>Configurações do Plugin Eventos</h1>
		<form method="post">
			<?php wp_nonce_field('eventos_plugin_settings_nonce'); ?>
			<table class="form-table">
				<tr>
					<th>Limpeza ao desativar</th>
					<td>
						<label>
							<input type="checkbox" name="eventos_plugin_clean_deactivate" value="1" <?php checked($clean_deactivate, true); ?> />
							Apagar todos os dados criados pelo plugin (posts de teste, imagens, página "Todos os Eventos") ao desativar
						</label>
					</td>
				</tr>
				<tr>
					<th>Limpeza ao eliminar</th>
					<td>
						<label>
							<input type="checkbox" name="eventos_plugin_clean_uninstall" value="1" <?php checked($clean_uninstall, true); ?> />
							Apagar todos os dados criados pelo plugin ao eliminar
						</label>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="submit" class="button button-primary" value="Guardar Alterações">
			</p>
		</form>
		<p>Para temas FSE, use o bloco Gutenberg <strong>"Menu BNGEv"</strong> no Editor do Tema.</p>
		<p>Para temas clássicos, adicione a página “Todos os Eventos” ao menu via Appearance → Menus.</p>
	</div>
	<?php
}
