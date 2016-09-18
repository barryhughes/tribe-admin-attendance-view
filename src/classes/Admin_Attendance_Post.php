<?php
/**
 * @internal
 */
class Tribe__Support__Tickets__Admin_Attendance_Post {
	protected $post_ref;
	protected $wp_post;

	public function __construct( $post_ref ) {
		$this->post_ref = $post_ref;
		$this->get_wp_post();
		$this->process();
		$this->process_ticket_types();
	}

	protected function get_wp_post() {
		$this->wp_post = get_post( $this->post_ref->ID );

		if ( ! is_object( $this->wp_post ) ) {
			$this->wp_post = new WP_Post( (object) array() );
		}
	}

	protected function process() {
		$this->wp_post->has_start_date    = (bool) $this->post_ref->has_start_date;
		$this->wp_post->start_date        = $this->wp_post->has_start_date ? $this->wp_post->_EventStartDate : $this->wp_post->post_date;
		$this->wp_post->edit_post_url     = get_edit_post_link( $this->wp_post->ID );
		$this->wp_post->attendee_list_url = $this->get_attendee_link( $this->wp_post->ID );
		$this->wp_post->ticket_types      = Tribe__Tickets__Tickets::get_all_event_tickets( $this->wp_post->ID );
	}

	protected function process_ticket_types() {
		$this->wp_post->stock     = 0;
		$this->wp_post->sold      = 0;
		$this->wp_post->pending   = 0;
		$this->wp_post->cancelled = 0;

		foreach ( $this->wp_post->ticket_types as $ticket_type ) {
			$this->wp_post->stock     += $ticket_type->stock;
			$this->wp_post->sold      += $ticket_type->qty_sold;
			$this->wp_post->pending   += $ticket_type->qty_pending;
			$this->wp_post->cancelled += $ticket_type->qty_cancelled;
		}
	}

	protected function get_attendee_link( $post_object ) {
		$params = array(
			'post_type' => $this->wp_post->post_type,
			'page'      => 'tickets-attendees',
			'event_id'  => $this->wp_post->ID
		);

		return add_query_arg( $params, admin_url( 'edit.php' ) );
	}

	public function __get( $key ) {
		if ( is_object( $this->wp_post ) ) {
			return $this->wp_post->$key;
		}
		else {
			return null;
		}
	}

	public function has_ticket_types() {
		return count( $this->wp_post->ticket_types ) > 0;
	}
}