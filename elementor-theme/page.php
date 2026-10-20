<?php get_header(); ?>
<main id="i9-main">
<?php while ( have_posts() ) : the_post(); ?>
<?php if ( ! get_post_meta( get_the_ID(), '_elementor_edit_mode', true ) ) : ?><h1 class="i9-document-title"><?php the_title(); ?></h1><?php endif; ?>
<?php the_content(); ?>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
