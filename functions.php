<?php

function theme_enqueue_styles() {

wp_enqueue_style( 'childtheme-style', get_stylesheet_directory_uri() . '/style.css', array( 'fusion-dynamic-css') );
//wp_enqueue_style( 'childtheme-style-fusionbuilder', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet') );
 wp_enqueue_style( 'avada-child-styles', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );





/**
 * Avada logosunu yüksek öncelikle wp-login ekranına zorla uygular
 */
function avada_child_force_login_logo() {
    $logo_url = Avada()->settings->get( 'logo', 'url' );

    if ( ! empty( $logo_url ) ) {
        // !important ekleyerek diğer eklentilerin CSS kurallarını eziyoruz
        echo '
        <!-- Avada Child Theme tarafından wp-login ekranına özel logo uygulaması -->
        <style type="text/css">
            body.login h1 a, 
            .login .wp-login-logo a,
            #login h1 a {
                background-image: url(' . esc_url( $logo_url ) . ') !important;
                height: 80px !important; 
                width: 100% !important;
                background-size: contain !important;
                background-repeat: no-repeat !important;
                background-position: center bottom !important;
                margin-bottom: 20px !important;
                padding-bottom: 10px !important;
            }
        </style>';
    }
}
// Önceliği 999 yaparak diğer tanımlardan sonra çalışmasını sağlıyoruz
add_action( 'login_enqueue_scripts', 'avada_child_force_login_logo', 999 );

/**
 * Logo linkini ana sayfaya yönlendirir
 */
add_filter( 'login_headerurl', function() {
    return home_url();
}, 999 );