<?php
/**
 * Plugin Name: Content Warning Plugin
 * Plugin URI: https://github.com/VolkanSah/Warning-function-for-WordPress/
 * Description: Dieses Plugin fügt Beiträgen in einer ausgewählten Kategorie eine Content-Warnung hinzu.
 * Version: 1.1
 * Author: Volkan Kücükbudak
 * Author URI: https://github.com/VolkanSah/
 */

// 1. Optionsseite im Admin-Menü hinzufügen
function cwp_add_admin_menu() {
    add_options_page(
        'Content Warning Einstellungen',
        'Content Warning',
        'manage_options',
        'content-warning',
        'cwp_options_page'
    );
}
add_action( 'admin_menu', 'cwp_add_admin_menu' );

// 2. Einstellungen registrieren und Felder definieren
function cwp_settings_init() {
    register_setting( 'cwpSettings', 'cwp_options' );
    
    add_settings_section(
        'cwp_section',
        __( 'Content Warning Einstellungen', 'content-warning' ),
        'cwp_section_callback',
        'cwpSettings'
    );
    
    // Kategorie-Auswahlfeld
    add_settings_field(
        'cwp_category',
        __( 'Kategorie auswählen', 'content-warning' ),
        'cwp_category_render',
        'cwpSettings',
        'cwp_section'
    );
    
    // Textfeld für Warnungstext
    add_settings_field(
        'cwp_message',
        __( 'Warnungstext', 'content-warning' ),
        'cwp_message_render',
        'cwpSettings',
        'cwp_section'
    );
}
add_action( 'admin_init', 'cwp_settings_init' );

// Rendering-Funktion für die Kategorie-Auswahl
function cwp_category_render() {
    $options = get_option( 'cwp_options' );
    $selected_category = isset( $options['cwp_category'] ) ? $options['cwp_category'] : '';
    
    $categories = get_categories( array( 'hide_empty' => false ) );
    echo '<select name="cwp_options[cwp_category]">';
    foreach ( $categories as $cat ) {
        $selected = selected( $selected_category, $cat->term_id, false );
        echo '<option value="' . esc_attr( $cat->term_id ) . '" ' . $selected . '>' . esc_html( $cat->name ) . '</option>';
    }
    echo '</select>';
}

// Rendering-Funktion für das Textfeld
function cwp_message_render() {
    $options = get_option( 'cwp_options' );
    $message = isset( $options['cwp_message'] ) ? $options['cwp_message'] : '';
    echo '<textarea name="cwp_options[cwp_message]" rows="5" cols="50">' . esc_textarea( $message ) . '</textarea>';
}

function cwp_section_callback() {
    echo __( 'Hier kannst du die Einstellungen für die Content-Warnung vornehmen.', 'content-warning' );
}

// Optionsseiten-HTML
function cwp_options_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'cwpSettings' );
            do_settings_sections( 'cwpSettings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// 3. Filter zum Einfügen der Warnung im Frontend
function cwp_content_warning_filter( $content ) {
    if ( is_single() ) {
        global $post;
        $options = get_option( 'cwp_options' );
        $selected_category = isset( $options['cwp_category'] ) ? $options['cwp_category'] : '';
        $warning_message = isset( $options['cwp_message'] ) ? $options['cwp_message'] : '';
        
        // Prüfe, ob der Beitrag in der ausgewählten Kategorie ist
        if ( has_category( $selected_category, $post->ID ) ) {
            // Überprüfen, ob die Warnung bereits gesehen wurde
            if ( !isset( $_GET['warnung_gelesen'] ) ) {
                $warning_url = add_query_arg( 'warnung_gelesen', '1', get_permalink( $post->ID ) );
                $warning = '<p>' . esc_html( $warning_message ) . ' <a href="' . esc_url( $warning_url ) . '">Klicken Sie hier, um weiterzulesen.</a></p>';
                return $warning;
            }
        }
    }
    return $content;
}
add_filter( 'the_content', 'cwp_content_warning_filter' );
?>
