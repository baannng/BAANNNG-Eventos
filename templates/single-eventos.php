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
	font-size: 10px;
	text-transform: uppercase;
}

.evento-nav a {
	color: #000;
	text-decoration: none;
}

.evento-nav a:hover {
	color: #777;
}

.evento-back {
	display: flex;
	justify-content: center;
	margin-top: 1rem;
	font-weight: 600;
}

.evento-back a {
	color: #000;
	font-size: 9px;
	text-transform: uppercase;
	text-decoration: none;
}

.evento-back a:hover {
	color: #777;
}

.nav-previous, .nav-next {
	border: 1px solid gray;
	padding: 2px 10px;
	border-radius: 25px;
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
			<div class="nav-previous">
				<?php
				$prev = get_adjacent_post(false, '', true);
				if ($prev && $prev->post_type === 'eventos') {
					echo '<a href="' . get_permalink($prev->ID) . '">← Evento Anterior</a>';
				}
				?>
			</div>
			<div class="nav-next">
				<?php
				$next = get_adjacent_post(false, '', false);
				if ($next && $next->post_type === 'eventos') {
					echo '<a href="' . get_permalink($next->ID) . '">Próximo Evento →</a>';
				}
				?>
			</div>
		</div>

		<div class="evento-back">
			 <a href="<?php echo site_url('/todos-os-eventos'); ?>">-- Voltar a todos os eventos --</a>
		</div>
	</div>
</div>

<?php endwhile; ?>
