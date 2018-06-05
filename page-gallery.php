<?php
/*
Template Name: Gallery
*/
get_header(); ?>

<?php get_template_part( 'template-parts/featured-image' ); ?>
<div class="main-container">
	<main class="main-content-full-width">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'page' ); ?>
			<?php echo wp_swift_grid_block_gallery(); ?>
			<?php comments_template(); ?>
		<?php endwhile; ?>
	</main>
</div>
<?php get_footer();
