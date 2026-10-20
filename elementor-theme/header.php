<!doctype html>
<html <?php language_attributes(); ?>>
<head><meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head>
<body <?php body_class( 'i9-elementor-site' ); ?>>
<?php wp_body_open(); ?>
<a class="i9-skip-link" href="#i9-main">Pular para o conteúdo</a>
<?php if ( ! i9_is_layout_preview() ) : ?>
<header class="i9-site-header">
<button class="i9-menu-toggle" aria-expanded="false" aria-controls="i9-header-content" type="button">Menu <span aria-hidden="true">☰</span></button>
<div id="i9-header-content"><?php if ( ! i9_elementor_layout( 'header' ) ) : ?><div class="i9-fallback-brand"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">i9nove Digital</a></div><?php endif; ?></div>
</header>
<?php endif; ?>
