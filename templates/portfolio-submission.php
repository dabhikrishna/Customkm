<?php
/**
 * Success message display with auto-hide.
 *
 * This file contains HTML code to display a success message and JavaScript code to hide it automatically
 * after a certain period of time.
 *
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */
?>
<<<<<<<< HEAD:templates/portfolio-submission.php
<div id="success-message"><?php echo esc_html__( 'Success! Your portfolio has been submitted with email .', 'customkm-menu' ); ?></div>
========
<div id="success-message">Success! Your portfolio has been submitted with emails .</div>
>>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942:includes/templates/portfolio-submission.php

<script>
	setTimeout(function() {
		document.getElementById("success-message").style.display = "none";
	}, 5000); // Hide after 5 seconds
</script>
