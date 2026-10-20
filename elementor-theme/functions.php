<?php
/** i9nove Elementor theme setup and one-click starter content. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'elementor' );
} );
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style( 'i9-elementor', get_theme_file_uri( 'assets/elementor.css' ), array(), '1.0.0' );
    wp_enqueue_script( 'i9-menu', get_theme_file_uri( 'assets/menu.js' ), array(), '1.0.0', true );
} );
function i9_elementor_layout( $name ) {
    $pages = get_option( 'i9_elementor_pages', array() );
    $id = isset( $pages[ $name ] ) ? absint( $pages[ $name ] ) : 0;
    if ( $id && 'publish' === get_post_status( $id ) && class_exists( '\Elementor\Plugin' ) ) {
        // Elementor renders and sanitizes its document with the current widget registry.
        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id, true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        return true;
    }
    return false;
}
function i9_is_layout_preview() {
    $pages = get_option( 'i9_elementor_pages', array() );
    return is_page() && in_array( get_queried_object_id(), array( (int) ( $pages['header'] ?? 0 ), (int) ( $pages['footer'] ?? 0 ) ), true );
}
add_filter( 'wp_robots', function ( $robots ) {
    if ( i9_is_layout_preview() ) { $robots['noindex'] = true; }
    return $robots;
} );
add_shortcode( 'i9nove_posts', function () {
    $posts = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 3, 'ignore_sticky_posts' => true, 'no_found_rows' => true ) );
    ob_start();
    echo '<div class="i9-posts">';
    if ( ! $posts->have_posts() ) { echo '<p>Novos conteúdos em breve. Acompanhe nossas ideias e novidades.</p>'; }
    while ( $posts->have_posts() ) {
        $posts->the_post();
        echo '<article><a href="' . esc_url( get_permalink() ) . '">';
        if ( has_post_thumbnail() ) { the_post_thumbnail( 'medium_large' ); }
        echo '<h3>' . esc_html( get_the_title() ) . '</h3></a><time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time></article>';
    }
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean();
} );
add_action( 'admin_menu', function () {
    add_theme_page( 'Configurar i9nove Elementor', 'Configurar i9nove', 'edit_theme_options', 'i9-elementor', 'i9_elementor_admin' );
} );
function i9_elementor_admin() {
    if ( ! current_user_can( 'edit_theme_options' ) ) { return; }
    $pages = get_option( 'i9_elementor_pages', array() );
    echo '<div class="wrap"><h1>i9nove Digital — Elementor</h1>';
    if ( ! class_exists( '\Elementor\Plugin' ) ) {
        echo '<p>Instale e ative o plugin gratuito Elementor em Plugins → Adicionar plugin. Depois volte a esta tela.</p></div>';
        return;
    }
    if ( isset( $_GET['i9_imported'] ) ) { echo '<div class="notice notice-success"><p>Layout importado. A página inicial foi configurada.</p></div>'; }
    echo '<p>Importe o layout de referência. Serão criadas três páginas editáveis no Elementor: início, cabeçalho e rodapé. A página inicial do site será alterada para a nova home. As páginas e posts existentes serão preservados.</p>';
    echo '<form action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" method="post"><input type="hidden" name="action" value="i9_import_elementor">';
    wp_nonce_field( 'i9_import_elementor' );
    submit_button( empty( $pages ) ? 'Importar layout e definir como página inicial' : 'Verificar e completar importação' );
    echo '</form><h2>Editar no Elementor</h2><ul>';
    foreach ( array( 'home' => 'Página inicial', 'header' => 'Cabeçalho', 'footer' => 'Rodapé' ) as $key => $label ) {
        if ( ! empty( $pages[ $key ] ) && get_post( $pages[ $key ] ) ) {
            echo '<li><a href="' . esc_url( admin_url( 'post.php?post=' . absint( $pages[ $key ] ) . '&action=elementor' ) ) . '">' . esc_html( $label ) . '</a></li>';
        }
    }
    echo '</ul><p>Substitua os exemplos de portfólio e o e-mail contato@example.com. O blog mostra automaticamente os três posts mais recentes pelo widget Shortcode. Para reverter a página inicial, use Configurações → Leitura.</p></div>';
}
add_action( 'admin_notices', function () {
    if ( current_user_can( 'edit_theme_options' ) && ! get_option( 'i9_elementor_pages' ) ) {
        echo '<div class="notice notice-info"><p>i9nove Elementor: <a href="' . esc_url( admin_url( 'themes.php?page=i9-elementor' ) ) . '">configure o plugin e importe o layout</a>.</p></div>';
    }
} );
add_action( 'admin_post_i9_import_elementor', function () {
    if ( ! current_user_can( 'edit_theme_options' ) || ! current_user_can( 'edit_pages' ) ) { wp_die( 'Sem permissão.', '', array( 'response' => 403 ) ); }
    check_admin_referer( 'i9_import_elementor' );
    if ( ! class_exists( '\Elementor\Plugin' ) ) { wp_die( 'Ative o Elementor antes de importar.' ); }
    $pages = get_option( 'i9_elementor_pages', array() );
    foreach ( array( 'home' => 'Início — i9nove', 'header' => 'Cabeçalho — i9nove', 'footer' => 'Rodapé — i9nove' ) as $key => $title ) {
        if ( ! empty( $pages[ $key ] ) && 'trash' !== get_post_status( $pages[ $key ] ) && get_post( $pages[ $key ] ) ) { continue; }
        $json = file_get_contents( get_theme_file_path( 'templates/' . $key . '.json' ) );
        $json = str_replace( '{{I9_ASSET}}', untrailingslashit( get_template_directory_uri() ) . '/assets', $json );
        $data = json_decode( $json, true );
        if ( ! isset( $data['content'] ) || ! is_array( $data['content'] ) ) { wp_die( 'Arquivo de layout inválido.' ); }
        $id = wp_insert_post( array( 'post_title' => $title, 'post_type' => 'page', 'post_status' => 'publish', 'meta_input' => array( '_elementor_edit_mode' => 'builder', '_wp_page_template' => 'default' ) ), true );
        if ( is_wp_error( $id ) ) { wp_die( esc_html( $id->get_error_message() ) ); }
        $document = \Elementor\Plugin::instance()->documents->get( $id );
        try {
            if ( ! $document || ! $document->save( array( 'elements' => $data['content'], 'settings' => array( 'hide_title' => 'yes' ) ) ) ) {
                wp_delete_post( $id, true );
                wp_die( 'O Elementor não conseguiu salvar o layout. Verifique a versão do plugin.' );
            }
        } catch ( \Throwable $error ) {
            wp_delete_post( $id, true );
            wp_die( esc_html( $error->getMessage() ) );
        }
        $pages[ $key ] = $id;
        update_option( 'i9_elementor_pages', $pages );
    }
    if ( ! get_option( 'i9_elementor_front_configured' ) ) {
        update_option( 'i9_elementor_previous_front', array( 'show_on_front' => get_option( 'show_on_front' ), 'page_on_front' => get_option( 'page_on_front' ) ) );
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $pages['home'] );
        update_option( 'i9_elementor_front_configured', true );
    }
    \Elementor\Plugin::instance()->files_manager->clear_cache();
    wp_safe_redirect( admin_url( 'themes.php?page=i9-elementor&i9_imported=1' ) );
    exit;
} );
