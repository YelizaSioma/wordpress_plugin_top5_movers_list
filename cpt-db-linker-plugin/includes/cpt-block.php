<?php
/**
 * Register a custom menu page for Top 5 Movers.
 */
function cpt_db_linker_custom_menu_page() {
	add_menu_page(
		'Top 5 Movers',
		'Top 5 Movers',
		'manage_options',
		'cpt-db-linker-top-movers',
		'cpt_db_linker_menu_page_renderer',
		'dashicons-list-view',
		6
	);
}
add_action( 'admin_menu', 'cpt_db_linker_custom_menu_page' );

/**
 * Display the Top 5 Movers in the custom admin page.
 */
function cpt_db_linker_menu_page_renderer() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'mover_info';

	//Setting how to sort
	// Query to retrieve the top 5 movers based on rating
	$top_movers = $wpdb->get_results(
		"
        SELECT *
        FROM $table_name
        ORDER BY rating DESC
        LIMIT 5
        "
	);

	// Display the movers in a styled format
	echo '<div class="wrap cpt-db-linker-top-movers">';
	echo '<h1>Top 5 Movers in USA</h1>';
	if ( ! empty( $top_movers ) ) {
		$rank = 1;
		foreach ( $top_movers as $mover ) {
			// Format the rating to one decimal place
			$formatted_rating = number_format( $mover->rating, 1 );
			echo '<div class="mover-entry">';
			echo '<h2>' . $rank . '. ' . esc_html( $mover->display_name ) . ' - ' . esc_html( $formatted_rating ) . '</h2>';
			echo '<p><strong>' . esc_html( $mover->short_paragraph ) . '</strong></p>';
			if ( ! empty( $mover->image_url ) ) {
				echo '<img src="' . esc_url( $mover->image_url ) . '" alt="' . esc_attr( $mover->display_name ) . '">';
			}
			echo '<p>' . esc_html( $mover->long_paragraph ) . '</p>';
			echo '</div>';
			$rank++;
		}
	} else {
		echo '<p>No movers found.</p>';
	}
	echo '</div>';
}