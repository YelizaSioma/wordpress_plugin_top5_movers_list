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
	$table_name = $wpdb->prefix . 'display_info';

	// Set the charset and collation
	$charset_collation = $wpdb->get_charset_collate();

	// Define table names
	$mover_table = $wpdb->prefix . 'mover_info';

	// SQL statement to create the main table mover_info
	$mover_creation_sql = "CREATE TABLE $mover_table (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        login varchar(255) NULL,
        password varchar(255) NULL,
        username varchar(50) NOT NULL,
        display_name varchar(100) NOT NULL,
        rating float(2,1) NOT NULL DEFAULT 0.0,
        short_paragraph text NOT NULL,
        long_paragraph longtext NOT NULL,
        image_url varchar(255) NOT NULL,
        is_active boolean NOT NULL DEFAULT TRUE,
        current_balance float,
        rate_per_lead float NOT NULL,
        priority int NOT NULL DEFAULT 100,
        PRIMARY KEY  (id)
    ) $charset_collation";

	// Include the upgrade functions and run dbDelta
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	dbDelta($mover_creation_sql);

	// SQL statement to populate the table with not existing info
	$mover_population_sql = "INSERT INTO $mover_table (`id`, `username`, `display_name`, `rating`, `short_paragraph`, `long_paragraph`, `image_url`, `current_balance`, `rate_per_lead`) 
VALUES
(1, 'la_future_movers', 'LA Future Movers LLC', 8.2, 'Trusted moving company chartered in the state of LA', 'LA Future Movers specialize in complete moves, from start to finish. Moving from LA to the West Coast of the United States. Their main goal is to keep your belongings unharmed, get things done quickly and efficiently. Already thousands of families have been satisfied with their services. Choose this company if you are tired of dealing with middlemen and want one company to handle your transportation completely.', 'https://i.imgur.com/aEDaZ9Q.jpeg', 1403.50, 7.80),
(2, 'ny_express_relocators', 'NY Express Relocators Inc.', 9.0, 'Leading moving service based in New York.', 'NY Express Relocators Inc. offers swift and reliable moving services from New York to various East Coast destinations. With a focus on customer satisfaction, they ensure a hassle-free moving experience. Their team of professionals handles your belongings with utmost care, making them a preferred choice for many.', 'https://i.imgur.com/edgq1R2.jpeg', 1200.00, 8.50),
(3, 'texas_star_movers', 'Texas Star Movers Co.', 8.5, 'Reliable moving company operating within Texas.', 'Texas Star Movers Co. provides comprehensive moving solutions across the state of Texas. Known for their punctuality and professionalism, they have assisted numerous families and businesses in relocating efficiently. Their services are tailored to meet individual needs, ensuring a personalized moving experience.', 'https://i.imgur.com/v2LOZAT.jpeg', 950.75, 6.75),
(4, 'fl_sunshine_transport', 'Florida Sunshine Transport LLC', 8.8, 'Premier moving service in the state of Florida.', 'Florida Sunshine Transport LLC specializes in moves from Florida to neighboring states. They pride themselves on their attention to detail and commitment to customer satisfaction. With a fleet of modern vehicles and a team of experienced movers, they guarantee a smooth and stress-free relocation process.', 'https://i.imgur.com/xewZ14g.jpeg', 1100.25, 7.50),
(5, 'chicago_north_movers', 'Chicago North Movers Ltd.', 8.7, 'Trusted moving company serving the Chicago area.', 'Chicago North Movers Ltd. offers top-notch moving services within Illinois and to neighboring states. Their experienced team ensures that all belongings are transported safely and efficiently. They have built a reputation for reliability and excellent customer service, making them a top choice for residents in the Chicago area.', 'https://i.imgur.com/6V8YKJ3.jpeg', 1300.00, 8.00),
(6, 'seattle_pacific_relocators', 'Seattle Pacific Relocators', 8.9, 'Leading moving service based in Seattle.', 'Seattle Pacific Relocators provides efficient moving solutions from Seattle to various West Coast destinations. They focus on providing a seamless moving experience, ensuring that all items are handled with care. Their commitment to excellence has earned them a loyal customer base in the Pacific Northwest.', 'https://i.imgur.com/kyeuX51.jpeg', 1250.50, 7.90),
(7, 'denver_mile_high_movers', 'Denver Mile High Movers', 8.6, 'Reliable moving company operating in Denver.', 'Denver Mile High Movers offers comprehensive moving services within Colorado and to neighboring states. Known for their professionalism and attention to detail, they have assisted numerous clients in relocating successfully. Their team is dedicated to making the moving process as smooth as possible.', 'https://i.imgur.com/TQCXjfn.jpeg', 1150.00, 7.60),
(8, 'atlanta_peach_state_transport', 'Atlanta Peach State Transport', 8.4, 'Premier moving service in Atlanta, Georgia.', 'Atlanta Peach State Transport specializes in moves from Georgia to various Southern states. They pride themselves on their customer-centric approach and efficient service delivery. With a team of skilled movers, they ensure that all belongings are transported safely and on time.', 'https://i.imgur.com/WhpWJZZ.jpeg', 1050.75, 7.40),
(9, 'boston_new_england_movers', 'Boston New England Movers', 8.3, 'Trusted moving company serving the Boston area.', 'Boston New England Movers provides top-tier moving services within Massachusetts and throughout New England. Their experienced team handles each move with precision and care, ensuring a stress-free experience for their clients. They have established themselves as a reliable choice for residents in the Boston area.', 'https://i.imgur.com/LrcEfuY.jpeg', 980.00, 7.20),
(10, 'sf_bay_area_relocators', 'SF Bay Area Relocators', 9.1, 'Leading moving service in the San Francisco Bay Area.', 'SF Bay Area Relocators offers efficient and reliable moving solutions within California and to neighboring states. They focus on providing personalized services to meet the unique needs of each client. Their commitment to quality and customer satisfaction has made them a preferred moving company in the Bay Area.', 'https://i.imgur.com/agDFd9w.jpeg', 1500.00, 8.80),
(11, 'phoenix_rising_movers', 'Phoenix Rising Movers', 7.5, 'Dependable moving service based in Phoenix, AZ.', 'Phoenix Rising Movers offers reliable relocation services within Arizona and to neighboring states. Known for their punctuality and careful handling of belongings, they have assisted numerous clients in achieving smooth transitions. Their team is dedicated to providing quality service at competitive rates.', 'https://i.imgur.com/FZtn8ix.jpeg', 900.00, 6.50),
(12, 'nashville_music_city_movers', 'Nashville Music City Movers', 7.8, 'Trusted moving company operating in Nashville, TN.', 'Nashville Music City Movers specializes in local and interstate moves from Tennessee. They pride themselves on their customer-focused approach and efficient service delivery. With a team of experienced movers, they ensure that all items are transported safely and on schedule.', 'https://i.imgur.com/8ugKaQV.jpeg', 1000.00, 7.00),
(13, 'portland_rose_city_relocators', 'Portland Rose City Relocators', 7.3, 'Reliable moving service serving the Portland, OR area.', 'Portland Rose City Relocators provides comprehensive moving solutions within Oregon and to neighboring states. Known for their attention to detail and commitment to customer satisfaction, they have assisted many families and businesses in relocating successfully.', 'https://i.imgur.com/RCyJXD5.jpeg', 950.00, 6.80),
(14, 'charlotte_queen_city_movers', 'Charlotte Queen City Movers', 7.6, 'Professional moving company based in Charlotte, NC.', 'Charlotte Queen City Movers offers efficient and affordable moving services within North Carolina and beyond. Their team is dedicated to ensuring a hassle-free moving experience, handling each item with care and precision. They have built a reputation for reliability and excellent customer service.', 'https://i.imgur.com/St7NaSJ.jpeg', 0.00, 5.50),
(15, 'detroit_motor_city_transport', 'Detroit Motor City Transport', 7.4, 'Experienced movers operating in Detroit, MI.', 'Detroit Motor City Transport provides dependable moving services within Michigan and to neighboring states. They focus on providing personalized services to meet the unique needs of each client. Their commitment to quality and customer satisfaction has made them a preferred moving company in the Detroit area.', 'https://i.imgur.com/cfLl0J9.jpeg', 600.00, 6.50);
    $charset_collation";
	dbDelta($mover_population_sql);

	// Create 'state' table
	$state_table = $wpdb->prefix . 'state';
	$state_sql = "CREATE TABLE $state_table (
    id BIGINT(20) NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL DEFAULT 'State',
    short_name VARCHAR(50) NOT NULL DEFAULT 'ST',
    PRIMARY KEY (id)
) $charset_collation";
	$wpdb->query($state_sql);

	// Create 'from_state' table
	$from_state_table = $wpdb->prefix . 'from_state';
	$from_state_sql = "CREATE TABLE $from_state_table (
    mover_id BIGINT(20) NOT NULL,
    state_id BIGINT(20) NOT NULL,
    PRIMARY KEY (mover_id, state_id),
    FOREIGN KEY (mover_id) REFERENCES {$wpdb->prefix}mover_info(id) ON DELETE CASCADE,
    FOREIGN KEY (state_id) REFERENCES $state_table(id) ON DELETE CASCADE
) $charset_collation";
	$wpdb->query($from_state_sql);

	// Create 'to_state' table
	$to_state_table = $wpdb->prefix . 'to_state';
	$to_state_sql = "CREATE TABLE $to_state_table (
    mover_id BIGINT(20) NOT NULL,
    state_id BIGINT(20) NOT NULL,
    PRIMARY KEY (mover_id, state_id),
    FOREIGN KEY (mover_id) REFERENCES {$wpdb->prefix}mover_info(id) ON DELETE CASCADE,
    FOREIGN KEY (state_id) REFERENCES $state_table(id) ON DELETE CASCADE
) $charset_collation";
	$wpdb->query($to_state_sql);

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
	$table_name = $wpdb->prefix . 'mover_info';

	// SQL statement to drop the table if it exists
	$sql = "DROP TABLE IF EXISTS $table_name";

	// Execute the query to drop the table
	$wpdb->query($sql);

	delete_option('cpt_db_linker_table_version');
}


/*Further changes:
1. populate tables
2. sort by rating
3. add mane title "Top 5 movers from STATE to STATE"
4. sort appeared movers by states filter
*/