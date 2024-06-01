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
<div id="success-message">Success! Your portfolio has been submitted with email .</div>

<script>
	setTimeout(function() {
		document.getElementById("success-message").style.display = "none";
	}, 5000); // Hide after 5 seconds
</script>
