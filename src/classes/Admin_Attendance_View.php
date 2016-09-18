<?php
/**
 * @internal
 */
class Tribe__Support__Tickets__Admin_Attendance_View {
	const ADMIN_SLUG = 'tribe_admin_attendance_view';

	protected $admin_page_hook = '';
	protected $event_list      = array();
	protected $current_page    = 1;
	protected $max_pages       = 1;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_page_register' ), 20 );
		add_action( 'load-tribe_events_page_' . self::ADMIN_SLUG, array( $this, 'admin_page_setup' ) );
		add_action( 'tribe_tickets_attendance_controls', array( $this, 'admin_page_controls' ) );
		add_action( 'tribe_tickets_attendance_table', array( $this, 'admin_page_table' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_page_assets' ) );
		add_action( 'wp_ajax_perform_attendee_search', array( $this, 'perform_search' ) );
	}

	public function admin_page_register() {
		$title = __( 'Event Attendance & Capacity', 'tribe-admin-attendance-view' );

		$this->admin_page_hook = add_submenu_page(
			Tribe__Settings::$parent_page,
			$title,
			$title,
			$this->list_attendees_capability(),
			self::ADMIN_SLUG,
			array( $this, 'admin_page_render' )
		);
	}

	protected function list_attendees_capability() {
		return apply_filters( 'tribe_tickets_list_attendees_capability', 'list_users' );
	}

	public function admin_page_setup() {
		$query = array(
			'limit' => isset( $_GET['show'] ) ? absint( $_GET['show'] ) : 20,
			'page'  => isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1
		);

		$events = new Tribe__Support__Tickets__Admin_Attendance_Query( $query );

		$this->event_list   = $events->get_posts();
		$this->current_page = (int) $query['page'];
		$this->max_pages    = (int) $events->available_pages();
	}

	public function admin_page_render() {
		include TRIBE_ADMIN_ATTENDANCE_VIEW_SRC . '/admin-views/screen.php';
	}

	public function admin_page_controls( $context ) {
		$pagination = new Tribe__Support__Tickets__Admin_Attendance_Pagination( $this->current_page, $this->max_pages );
		include TRIBE_ADMIN_ATTENDANCE_VIEW_SRC . '/admin-views/controls.php';
	}

	public function admin_page_table() {
		$event_list = $this->event_list;
		include TRIBE_ADMIN_ATTENDANCE_VIEW_SRC . '/admin-views/table.php';
	}

	public function admin_page_assets( $page_hook ) {
		if ( $this->admin_page_hook !== $page_hook ) {
			return;
		}

		wp_enqueue_style(
			'tribe_admin_attendance_css',
			TRIBE_ADMIN_ATTENDANCE_VIEW_URL . 'src/resources/css/admin-attendance.css'
		);
	}

	public function perform_search() {
		if ( wp_verify_nonce( @$_POST['check'], 'perform_attendee_search' ) ) {
			new Tribe__Support__Tickets__Admin_Attendance_ViewAttendees_Search( @$_POST['purchaser'] );
		}
	}
}