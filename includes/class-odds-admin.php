<?php
// This class handles the admin settings page for the Odds Comparison plugin
class Odds_Admin {

    // Constructor function: automatically runs when the class is created
    public function __construct() {
        // Add menu link in WordPress admin sidebar
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

        // Register settings and fields
        add_action( 'admin_init', array( $this, 'settings_init' ) );
    }

    // Add a new item in the "Settings" menu in WordPress admin
    public function add_admin_menu() {
        add_options_page(
            'Odds Comparison Settings', // Page title
            'Odds Comparison',          // Menu title
            'manage_options',           // Who can see this menu (admins only)
            'odds_comparison',          // Unique slug
            array( $this, 'options_page' ) // Function that displays the settings page
        );
    }

    // Register settings and create input fields for bookmakers and markets
    public function settings_init() {
        // Register a settings group named 'odds_comparison'
        register_setting( 'odds_comparison', 'odds_comparison_settings' );

        // Add a section to the settings page
        add_settings_section(
            'odds_comparison_section', // Section ID
            __( 'Bookmakers and Markets Settings', 'odds_comparison' ), // Title
            null,                      // Optional callback (we’re not using it here)
            'odds_comparison'          // Page slug
        );

        // Add input field for "Bookmakers"
        add_settings_field(
            'bookmakers',                          // Field ID
            __( 'Bookmakers', 'odds_comparison' ), // Field label
            array( $this, 'bookmakers_render' ),   // Callback function to render field
            'odds_comparison',                     // Page slug
            'odds_comparison_section'              // Section ID
        );

        // Add input field for "Markets"
        add_settings_field(
            'markets',
            __( 'Markets', 'odds_comparison' ),
            array( $this, 'markets_render' ),
            'odds_comparison',
            'odds_comparison_section'
        );
    }

    // Display the text input for "Bookmakers"
    public function bookmakers_render() {
        $options = get_option( 'odds_comparison_settings' );
        ?>
        <input type='text' name='odds_comparison_settings[bookmakers]' value='<?php echo $options['bookmakers']; ?>'>
        <?php
    }

    // Display the text input for "Markets"
    public function markets_render() {
        $options = get_option( 'odds_comparison_settings' );
        ?>
        <input type='text' name='odds_comparison_settings[markets]' value='<?php echo $options['markets']; ?>'>
        <?php
    }

    // The main settings page layout
    public function options_page() {
        ?>
        <form action='options.php' method='post'>
            <h2>Odds Comparison Settings</h2>

            <?php
            // This function adds the hidden security fields
            settings_fields( 'odds_comparison' );

            // This outputs all settings sections and fields
            do_settings_sections( 'odds_comparison' );

            // Submit button
            submit_button();
            ?>
        </form>
        <?php
    }
}

// Create a new object of the class so the code runs
new Odds_Admin();
?>
