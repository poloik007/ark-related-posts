<?php

/*
 * Plugin Name: Arkon related posts
 * Description: Display the related posts from tags.
 * Version: 1.0.0
 * Author: Gabriel Del Fiaco
 */

require_once plugin_dir_path(__FILE__) . 'class.ark-related-posts-query.php';

function ark_add_related_posts($content){

    if (!is_single()) { // show only in single posts.
        return $content;
    }

    $related = new Ark_Related_Posts(get_the_ID());
    $posts = $related->ark_get_posts();

    return $content . ark_render_template($posts);
}

function ark_render_template($posts){
    ob_start(); //buffer
    include plugin_dir_path(__FILE__) . 'view/ark-related-posts-template.php';
    return ob_get_clean(); //get the buffer and clean it
}

function ark_enqueue_styles(){
    $css_path = plugin_dir_path(__FILE__) . '_inc/dist/style.css';
    $css_url = plugin_dir_url(__FILE__) . '_inc/dist/style.css';

    // managment of cache by the timestamp of the file.
    $version = file_exists($css_path) ? filemtime($css_path) : '1.0.0';

    wp_enqueue_style(
        'ark-related-posts',
        $css_url,
        array(),
        $version
    );
}

add_filter('the_content', 'ark_add_related_posts');
add_action('wp_enqueue_scripts', 'ark_enqueue_styles');