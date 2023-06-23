<?php
/*
 * Plugin Name:       warning-redirect
 * Plugin URI:        https://github.com/VolkanSah/warning-redirect
 * Description:       Effortlessly manage and respond to comments on your WordPress site with the power of AI using the ChatGPT Comments Reply Plugin
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            S. Volkan Sah
 * Author URI:        https://volkansah.github.com
 * License:           GPL3
 * License URI:       license.txt
 * Update URI:        https://github.com/VolkanSah/warning-redirectlatest.zip
 * Text Domain:       aicc-aicr
 * Domain Path:       /languages
 */
function content_warning_filter($content) {
    global $post;
    if (has_category('was-wuerde-onkel-volkan-davon-halten', $post->ID) && is_single()) {
        // Überprüfen, ob die Warnung bereits gesehen wurde
        if (!isset($_GET['warnung_gelesen'])) {
        $content = '<p>The following post contains content that may not be suitable for all audiences. Reader discretion is advised. <a href="'.get_permalink($post->ID).'?warnung_gelesen=1">Klicken Sie hier, um weiterzulesen.</a></p>';
        }
    }
    return $content;
}
add_filter('the_content', 'content_warning_filter');


