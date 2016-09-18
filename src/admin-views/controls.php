<?php
/**
 * @var string $context
 * @var Tribe__Support__Tickets__Admin_Attendance_Pagination $pagination
 */
?>
<div class="controls">
	<div class="pagination">
		<?php
		$first_page = $pagination->first_page();
		$is_useful  = $pagination->first_page_is_useful();
		?>

		<a href="<?php echo esc_attr( add_query_arg( 'pagenum', $first_page ) ); ?>"
		   data-page="<?php echo esc_attr( $first_page ); ?>"
		   class="button <?php echo $is_useful ? '' : 'disabled'; ?>">
			&laquo;
		</a>

		<?php
		$prev_page = $pagination->prev_page();
		$is_useful = $pagination->prev_page_is_useful();
		?>

		<a href="<?php echo esc_attr( add_query_arg( 'pagenum', $prev_page ) ); ?>"
		   data-page="<?php echo esc_attr( $prev_page ); ?>"
		   class="button <?php echo $is_useful ? '' : 'disabled'; ?>">
			&lsaquo;
		</a>

		<?php
		$next_page = $pagination->next_page();
		$is_useful = $pagination->next_page_is_useful();
		?>

		<a href="<?php echo esc_attr( add_query_arg( 'pagenum', $next_page ) ); ?>"
		   data-page="<?php echo esc_attr( $next_page ); ?>"
		   class="button <?php echo $is_useful ? '' : 'disabled'; ?>">
			&rsaquo;
		</a>

		<?php
		$last_page = $pagination->last_page();
		$is_useful = $pagination->last_page_is_useful();
		?>

		<a href="<?php echo esc_attr( add_query_arg( 'pagenum', $last_page ) ); ?>"
		   data-page="<?php echo esc_attr( $last_page ); ?>"
		   class="button <?php echo $is_useful ? '' : 'disabled'; ?>">
			&raquo;
		</a>

	</div>
</div>