<div class="wrap tribe-tickets-admin-attendance-view">
	<h1> <?php esc_html_e( 'Event Attendance &amp; Capacity', 'tribe-admin-attendance-view' ); ?> </h1>
	<?php
	do_action( 'tribe_tickets_attendance_controls', 'top' );
	do_action( 'tribe_tickets_attendance_table' );
	do_action( 'tribe_tickets_attendance_controls', 'bottom' );
	?>
</div>