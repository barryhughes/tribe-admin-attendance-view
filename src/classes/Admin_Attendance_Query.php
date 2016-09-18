<?php
/**
 * @internal
 */
class Tribe__Support__Tickets__Admin_Attendance_Query {
	protected $args        = array();
	protected $fetched     = false;
	protected $results     = array();
	protected $total_avail = 0;

	public function __construct( array $args = array() ) {
		$this->args = wp_parse_args( $args, array(
			'limit' => 20,
			'page'  => 1
		) );
	}
	
	protected function fetch() {
		global $wpdb;

		$post_types = $this->prepare_list( Tribe__Tickets__Main::instance()->post_types(), 'post_types' );
		$post_statuses = $this->prepare_list( array( 'publish', 'private' ), 'post_statuses' );

		$sql = "
			SELECT SQL_CALC_FOUND_ROWS DISTINCT 
			       {$wpdb->posts}.ID,
			       start_date.meta_value,
			       IF ( start_date.meta_value IS NULL, 0, 1 ) AS has_start_date

			FROM {$wpdb->posts}

			LEFT JOIN {$wpdb->postmeta} AS start_date 
			ON        ID = start_date.post_id
			AND       meta_key = '_EventStartDate'

			WHERE post_type IN ( $post_types )
			AND   post_status IN ( $post_statuses )
			AND   (
			          start_date.meta_value > %s
			          OR start_date.meta_value IS NULL
			      )

			ORDER BY has_start_date DESC,
			         start_date.meta_value ASC,
			         post_date

			LIMIT %d, %d
		";

		$results = $wpdb->get_results( $wpdb->prepare( $sql, $this->start_date(), $this->offset(), $this->limit() ) );
		$this->total_avail = (int) $wpdb->get_var( 'SELECT FOUND_ROWS()' );
		$this->results = array_map( array( $this, 'prepare_results' ), $results );
	}

	protected function start_date() {
		return date_i18n( 'Y-m-d H:i:s' );
	}

	protected function offset() {
		$limit = (int) $this->args['limit'];
		$page  = (int) $this->args['page'];

		$offset = ( $page * $limit ) - $limit;
		return $offset > -1 ? $offset : 0;
	}

	protected function limit() {
		return (int) $this->args['limit'];
	}

	protected function prepare_list( array $items, $context = 'general' ) {
		$original_items = $items;
		array_map( 'esc_sql', $items );

		foreach ( $items as &$single_item ) {
			$single_item = "'$single_item'";
		}

		$result = join( ',', $items );
		return apply_filters( 'tribe_admin_attendance_view_prepared_list', $result, $context, $original_items );
	}

	protected function prepare_results( $post ) {
		return new Tribe__Support__Tickets__Admin_Attendance_Post( $post );
	}

	public function get_posts() {
		if ( ! $this->fetched ) {
			$this->fetch();
			$this->fetched = true;
		}

		return $this->results;
	}

	public function available_pages() {
		return (int) ceil( $this->total_avail / (int) $this->args['limit'] );
	}
}