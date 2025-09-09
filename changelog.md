# Changelog - Eventos Plugin

## [1.2.0] - Release atual
- Sistema completo de admin settings (limpeza ao desativar ou uninstall).
- Implementação do `uninstall.php`.
- Shortcode refinado: exibição em cards com imagem, título, ACF e link para single.
- Novo template `single-eventos.php` com design responsivo.
- Estilo integrado com Google Fonts (Manrope).
- Navegação entre posts (anterior/próximo) e link “Voltar a todos os eventos”.

## [1.1.1] - Patch
- Corrigido `flush_rewrite_rules()` para permalinks.
- Ajustes no carregamento de imagens e seeding.

## [1.1.0] - Nova funcionalidade
- Criação automática da página “Todos os Eventos” na ativação.
- Seeder de eventos de teste com integração ACF.
- Upload automático de imagens a partir da pasta `assets/`.
- Opção de limpeza ao desativar plugin.

## [1.0.1] - Patch
- Fixes menores no shortcode e CPT.
- Primeira versão do `single-eventos.php` sem header/footer.

## [1.0.0] - Release inicial
- Criação do Custom Post Type `eventos`.
- Integração básica com ACF Pro (campos: data, local, organizador).
- Shortcode inicial `[eventos_todos]`.
- Página “Todos os Eventos” criada manualmente.
