<?php get_header(); ?>
<main id="i9-main" class="i9-document">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?>><h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1><?php if ( is_singular() ) { the_content(); } else { the_excerpt(); } ?></article>
<?php endwhile; the_posts_pagination(); else : ?><h1>Nenhum conteúdo encontrado.</h1><?php endif; ?>
</main><?php get_footer(); ?>
