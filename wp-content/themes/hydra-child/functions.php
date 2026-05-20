<?php
/**
 * HYDRA Child Theme — functions.php
 * Enqueues parent Kadence stylesheet then the HYDRA responsive stylesheet.
 */

add_action( 'wp_enqueue_scripts', function () {

    // Parent theme stylesheet
    wp_enqueue_style(
        'kadence-parent',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'kadence' )->get( 'Version' )
    );

    // HYDRA responsive stylesheet
    wp_enqueue_style(
        'hydra-responsive',
        get_stylesheet_directory_uri() . '/hydra-responsive.css',
        [ 'kadence-parent' ],
        '1.0.0'
    );

}, 20 );

// Remove Kadence footer credit
add_filter( 'kadence_footer_credit', '__return_false' );
