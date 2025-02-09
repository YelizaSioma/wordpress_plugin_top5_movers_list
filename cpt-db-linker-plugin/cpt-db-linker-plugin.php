<?php
/**
 * Plugin Name: CPT DB Linker
 * Plugin URI: https://github.com/YelizaSioma
 * Description: This plugin will create a dynamic block template of the top 5 movers list linked to the database.
 * Author: Yelizaveta Siomchanka
 * Version: 1.0.0
 * Author URI: https://github.com/YelizaSioma
 */

// Constant for Plugin path.
define( 'CPT_DB_LINKER_PLUGIN_FILE_PATH', plugin_dir_path( __FILE__ ) );

// Require menu handler file.
require_once trailingslashit( CPT_DB_LINKER_PLUGIN_FILE_PATH ) . 'includes/cpt-block.php';

register_activation_hook(__FILE__, 'cpt_db_linker_create_movers_table');

function cpt_db_linker_create_movers_table() {
	global $wpdb;

	// Define the table name with the WordPress prefix
	$table_name = $wpdb->prefix . 'movers_list';

	// Set the charset and collation
	$charset_collation = $wpdb->get_charset_collate();

	// SQL statement to create the table
	$sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        username varchar(50) NOT NULL,
        display_name varchar(100) NOT NULL,
        rating float(3,2) DEFAULT 0.00 NOT NULL,
        short_paragraph text NOT NULL,
        long_paragraph longtext NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collation";

	// Include the upgrade functions and run dbDelta
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	dbDelta($sql);

	add_option('cpt_db_linker_table_version', '1.0.0');
}

/**
 * Enqueue custom CSS for the Top 5 Movers admin page.
 */
function cpt_db_linker_enqueue_admin_styles($hook) {
	// Load styles only on the specific admin page
	if ($hook !== 'toplevel_page_cpt-db-linker-top-movers') {
		return;
	}
	wp_enqueue_style(
		'cpt-db-linker-admin-styles',
		plugin_dir_url(__FILE__) . 'css/admin-custom-styles.css'
	);
}
add_action('admin_enqueue_scripts', 'cpt_db_linker_enqueue_admin_styles');


register_uninstall_hook(__FILE__, 'cpt_db_linker_uninstall');

function cpt_db_linker_uninstall() {
	global $wpdb;

	// Define the table name with the WordPress prefix
	$table_name = $wpdb->prefix . 'movers_list';

	// SQL statement to drop the table if it exists
	$sql = "DROP TABLE IF EXISTS $table_name";

	// Execute the query to drop the table
	$wpdb->query($sql);

	delete_option('cpt_db_linker_table_version');
}


