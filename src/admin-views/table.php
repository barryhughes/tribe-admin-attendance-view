<?php
/**
 * @var array $event_list
 */
?>
<table>
	<thead>
		<th><?php esc_html_e( 'Date', 'tribe-admin-attendance-view' ); ?></th>
		<th><?php esc_html_e( 'Event', 'tribe-admin-attendance-view' ); ?></th>
		<th><?php esc_html_e( 'Remaining', 'tribe-admin-attendance-view' ); ?></th>
		<th><?php esc_html_e( 'Sold', 'tribe-admin-attendance-view' ); ?></th>
		<th><?php esc_html_e( 'Cancelled', 'tribe-admin-attendance-view' ); ?></th>
	</thead>
	<tbody>
		<?php foreach ( $event_list as $event ): ?>
			<tr class="<?php echo $event->has_ticket_types() ? 'ticketed' : 'non-ticketed'; ?>">
				<td class="datetime">
					<?php if ( $event->has_start_date ): ?>
						<div class="dateblock mon-<?php echo esc_attr( date_i18n( 'n', strtotime( $event->start_date ) ) ); ?>">
							<div class="month">
								<?php echo esc_html( date_i18n( 'M', strtotime( $event->start_date ) ) ); ?>
							</div>
							<div class="day">
								<?php echo esc_html( date_i18n( 'j', strtotime( $event->start_date ) ) ); ?>
							</div>
						</div>
					<?php else: ?>
						<div class="dateblock nodate">
							<div class="month empty"> &nbsp; </div>
							<div class="day">?</div>
						</div>
					<?php endif; ?>
				</td>

				<td class="title">
					<h3> <?php echo esc_html( get_the_title( $event->ID ) ); ?> </h3>
					<div class="action_links">
						<a href="<?php echo esc_url( $event->edit_post_url ); ?>"><?php esc_html_e( 'Edit Post', 'tribe-admin-attendance-view' ); ?></a> |
						<a href="<?php echo esc_url( $event->attendee_list_url ); ?>"><?php esc_html_e( 'View Attendee Details', 'tribe-admin-attendance-view' ); ?></a>
					</div>
				</td>

				<td class="total remaining">
					<div class="stock"> <?php echo esc_html( $event->stock ); ?> </div>
				</td>

				<td class="total sold">
					<div class="sold"> <?php echo esc_html( $event->sold ); ?> </div>
				</td>

				<td class="total cancelled">
					<div class="cancelled"> <?php echo esc_html( $event->cancelled ); ?> </div>
				</td>
			</tr>
		<?php endforeach; ?>

		<?php if ( empty( $event_list ) ): ?>
			<tr class="no-results"> <td colspan="2">
				<p> <?php esc_html_e( 'No upcoming events were found.', 'tribe-admin-attendance-view' ); ?> </p>
			</td> </tr>
		<?php endif; ?>
	</tbody>
</table>