<?php
/**
 * @internal
 */
class Tribe__Support__Tickets__Admin_Attendance_Pagination {
	protected $current_page = 1;
	protected $max_page = 1;

	public function __construct( $current_page = 1, $max_page = 1 ) {
		$this->current_page = (int) $current_page;
		$this->max_page = (int) $max_page;
		$this->sanity_adjustments();
	}

	protected function sanity_adjustments() {
		if ( $this->current_page < 1 ) {
			$this->current_page = 1;
		}

		if ( $this->max_page < 1 ) {
			$this->max_page = 1;
		}

		if ( $this->current_page > $this->max_page ) {
			$this->current_page = $this->max_page;
		}
	}

	public function first_page_is_useful() {
		return $this->current_page > 2;
	}

	public function first_page() {
		return 1;
	}

	public function prev_page_is_useful() {
		return $this->current_page > 1;
	}

	public function prev_page() {
		return max( $this->current_page - 1, 1 );
	}

	public function current_page() {
		return $this->current_page;
	}

	public function next_page_is_useful() {
		return $this->current_page < $this->max_page;
	}

	public function next_page() {
		return min( $this->current_page + 1, $this->max_page );
	}

	public function last_page_is_useful() {
		return $this->current_page < ( $this->max_page - 1 );
	}

	public function last_page() {
		return $this->max_page;
	}
}