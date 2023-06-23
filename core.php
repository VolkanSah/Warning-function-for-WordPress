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
 * Update URI:       https://github.com/VolkanSah/warning-redirectlatest.zip
 * Text Domain:       aicc-aicr
 * Domain Path:       /languages
 */
<?php
function content_warning_filter($content) {
    global $post;
    if (has_category('ACHTUNG WARNUNG!', $post->ID)) {
        $content = '<p>Der folgende Beitrag ist möglicherweise nicht für Kinder und Jugendliche unter 16 Jahren geeignet. Im umgangssprachlichen Kontext der heutigen Jugendkultur kann der Inhalt dieses Artikels als heftig oder direkt empfunden werden. Wenn du weiterlesen möchtest, klicke bitte auf den untenstehenden Link. Wir übernehmen keine Haftung für eventuelle Unannehmlichkeiten oder Schäden, die durch den Inhalt des folgenden Artikels entstehen könnten. Dieser Beitrag ist eine Reaktion auf die Frustration vieler Menschen, die die Integrität unserer Demokratie in Frage stellen. Es ist bedauerlich, dass wir als Migranten-Deutsche oft mehr Respekt vor unserem neuen Heimatland zeigen als manche selbsternannte Patrioten. Wenn du mehr über die gesellschaftlichen Gegebenheiten in Deutschland erfahren möchtest, besuche unsere Rubrik \'Was würde Onkel Volkan davon halten?\'. <a href="'.get_permalink($post->ID).'">Klicken Sie hier, um weiterzulesen.</a></p>';
    }
    return $content;
}

add_filter('the_content', 'content_warning_filter');

