<?php
if (!defined('ABSPATH')) exit;

while (have_posts()) : the_post();
	$data = get_field('data_do_evento');
	$local = get_field('local');
	$organizador = get_field('organizador');
	$thumbnail = has_post_thumbnail() ? get_the_post_thumbnail(get_the_ID(), 'large', ['class'=>'evento-img mb-3']) : '';

	$prev_post = get_previous_post();
	$next_post = get_next_post();
?>

<style>
/* Importar Google Font Manrope */
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;700&display=swap');

.evento-container {
	display: flex;
	justify-content: center;
	align-items: center;
	padding: 3rem 1rem;
	font-family: 'Manrope', sans-serif;
}

.evento-card {
	max-width: 600px;
	width: 100%;
	background: #fff;
	padding: 2rem;
	border-radius: 10px;
	box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.evento-img {
	width: 100%;
	height: auto;
	border-radius: 8px;
	margin-bottom: 1rem;
}

.evento-card h1 {
	font-size: 2rem;
	margin: 1rem 0;
}

.evento-info p {
	margin-bottom: 0.5rem;
	color: #000;
}

.evento-content {
	margin-bottom: 1.5rem;
}

.evento-nav {
	display: flex;
	justify-content: space-between;
	margin-bottom: 1rem;
}

.evento-nav a,
.evento-back {
	color: #000;
	text-decoration: none;
}

.evento-back {
	display: inline-block;
	margin-top: 1rem;
}
</style>

<div class="evento-container">
	<div class="evento-card">
		<?php if ($thumbnail) echo $thumbnail; ?>
		<h1><?php the_title(); ?></h1>
		<div class="evento-info">
			<p><strong>Data:</strong> <?php echo esc_html($data); ?></p>
			<p><strong>Local:</strong> <?php echo esc_html($local); ?></p>
			<p><strong>Organizador:</strong> <?php echo esc_html($organizador); ?></p>
		</div>
		<div class="evento-content"><?php the_content(); ?></div>

		<div class="evento-nav">
			<div>
				<?php if ($prev_post) : ?>
					<a href="<?php echo get_permalink($prev_post->ID); ?>">&laquo; Evento anterior</a>
				<?php endif; ?>
			</div>
			<div>
				<?php if ($next_post) : ?>
					<a href="<?php echo get_permalink($next_post->ID); ?>">Próximo evento &raquo;</a>
				<?php endif; ?>
			</div>
		</div>

		<a class="evento-back" href="<?php echo get_permalink(get_option('eventos_plugin_page_created')); ?>">← Voltar a todos os eventos</a>
	</div>
</div>

<?php endwhile; ?>
