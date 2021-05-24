<?php
/**
 * Admin Settings.
 */

$data = $this->default_data();
?>

<div class="wrap">

	<h2><?php esc_html_e( 'Chat With Me on Zalo Settings', 'chat-with-me-on-zalo' ); ?></h2>

	<?php $this->message(); ?>

	<form method="post" id="cwmoz-settings-form" action="<?php echo $this->form_action(); ?>">

		<hr>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Zalo Phone Number', 'chat-with-me-on-zalo' ); ?>
					</th>
					<td>
						<input id="cwmoz_phone" name="cwmoz_configurations[phone]" type="text" class="regular-text" value="<?php echo esc_attr( $data['phone'] ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Margin Bottom (px)', 'chat-with-me-on-zalo' ); ?>
					</th>
					<td>
						<input id="cwmoz_margin" name="cwmoz_configurations[margin]" type="number" value="<?php echo esc_attr( $data['margin'] ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Style', 'chat-with-me-on-zalo' ); ?>
					</th>
					<td>
						<select name="cwmoz_configurations[style]">
							<option value="1" <?php selected( $data['style'], '1' ) ?>><?php esc_html_e( 'Style 1', 'chat-with-me-on-zalo' ); ?></option>
							<option value="2" <?php selected( $data['style'], '2' ) ?>><?php esc_html_e( 'Style 2', 'chat-with-me-on-zalo' ); ?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e( 'Position', 'chat-with-me-on-zalo' ); ?>
					</th>
					<td>
						<select name="cwmoz_configurations[position]">
							<option value="left" <?php selected( $data['position'], 'left' ) ?>><?php esc_html_e( 'Left', 'chat-with-me-on-zalo' ); ?></option>
							<option value="right" <?php selected( $data['position'], 'right' ) ?>><?php esc_html_e( 'Right', 'chat-with-me-on-zalo' ); ?></option>
						</select>
					</td>
				</tr>
			</tbody>
		</table>

		<?php submit_button("Save Changes"); ?>
		<?php wp_nonce_field( 'cwmoz-settings', 'cwmoz-settings-nonce' ); ?>

	</form>

	<hr />

	<h2>
		<?php esc_html_e( 'Support', 'chat-with-me-on-zalo' ); ?>
	</h2>
	<p>
		<?php _e( 'For submitting any support, please contact us to <a href="mailto:luutrongnghia38@gmail.com" target="_blank">E-mail</a> or visit our website <a href="http://haita.media/" target="_blank">haita.media</a>', 'chat-with-me-on-zalo' ); ?>
	</p>

</div>
