<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://beantowers.com/
 * @since             1.0.0
 * @package           Wp_Clients
 *
 * @wordpress-plugin
 * Plugin Name:       WP Clients 
 * Plugin URI:        http://beantowers.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            James Towers
 * Author URI:        http://beantowers.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-clients
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-clients-activator.php
 */
function activate_wp_clients() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-clients-activator.php';
	Wp_Clients_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-clients-deactivator.php
 */
function deactivate_wp_clients() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-clients-deactivator.php';
	Wp_Clients_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_clients' );
register_deactivation_hook( __FILE__, 'deactivate_wp_clients' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-clients.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_clients() {

	$plugin = new Wp_Clients();
	$plugin->run();

}
run_wp_clients();
