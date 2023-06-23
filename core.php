<?php
/**
 * Plugin Name: Content Warning Plugin
 * Plugin URI: https://github.com/VolkanSah/Warning-function-for-WordPress/
 * Description: This plugin adds a content warning to posts in specific categories.
 * Version: 1.0
 * Author: VolkanSah, OpenAI's ChatGPT
 * Author URI: https://github.com/VolkanSah/
 */

function content_warning_filter($content) {
    global $post;
    if (has_category('example-category', $post->ID) && is_single()) {
        // Überprüfen, ob die Warnung bereits gesehen wurde
        if (!isset($_GET['warnung_gelesen'])) {
        $content = '<p>The following post contains content that may not be suitable for all audiences. Reader discretion is advised. <a href="'.get_permalink($post->ID).'?warnung_gelesen=1">Klicken Sie hier, um weiterzulesen.</a></p>';
        }
    }
    return $content;
}
add_filter('the_content', 'content_warning_filter');


