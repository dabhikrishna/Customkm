<?php
/**
 * HTML table for displaying data.
 *
 * This file represents an HTML table for displaying data, typically retrieved from a database or other source.
 * It includes styling for table headers and defines columns for various data fields.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Customkm Menu
 * @subpackage customkm-menu/templates
 */
?>
<table>
	<style>
		th {
			border: 1px solid #ddd;
			padding: 8px;
			text-align: left;
			background-color: #f2f2f2;
		}
	</style>
	<tr>
<<<<<<<< HEAD:templates/form.php
	<th><?php echo esc_html__( 'Title', 'customkm-menu' ); ?></th>
========
		<th><?php echo esc_html__( 'Title', 'customkm-menu' ); ?></th>
>>>>>>>> a6719ac514c5ab92aa59c39115dbb0e99ff6b942:includes/templates/form.php
		<th><?php echo esc_html__( 'Name', 'customkm-menu' ); ?></th>
		<th><?php echo esc_html__( 'Address', 'customkm-menu' ); ?></th>
		<th><?php echo esc_html__( 'Email', 'customkm-menu' ); ?></th>
		<th><?php echo esc_html__( 'Phone', 'customkm-menu' ); ?></th>
		<th><?php echo esc_html__( 'Company Name', 'customkm-menu' ); ?></th>
		<th><?php echo esc_html__( 'Date', 'customkm-menu' ); ?></th>
		<th><?php echo esc_html__( 'Action', 'customkm-menu' ); ?></th>
	</tr>
