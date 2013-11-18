<?php
/*******************************************************************************
** WP Currency Converter Widget Class
** Description: A clever widget for displaying a currency conversion tool
** @since 1.0
*******************************************************************************/
class Widget_WPCC extends WP_Widget {

	function Widget_WPCC() {

		$widget_ops = array( 
			'description' => __('Currency conversion tool provided by WP Currency Converter', 'wpcc')
		);
		
		$this->WP_Widget( 
			'wp-currency-converter', 
			'WP Currency Converter Widget', 
			$widget_ops
		);
		
	}

	function widget($args, $instance) {
		extract( $args, EXTR_SKIP );
		
		$title = $instance['title'];
		$pretool_paragraph = $instance['pretool_paragraph'];
		$from_default = $instance['from_default'];
		$to_default = $instance['to_default'];
		
		$from_currency_options = $this->retrieveCurrencyOptions('from_currencies', $from_default);
		$to_currency_options = $this->retrieveCurrencyOptions('to_currencies', $to_default);
		
		echo '<div id="' . $args['widget_id'] . '" class="widget wp-currency-converter-widget">';
		
		echo '<h3>' . $title . '</h3>';
		
		// start widget content
		echo '<div>' . (!empty($pretool_paragraph) ? '<p>' . $pretool_paragraph . '</p>' : '');
		
		echo '<div class="wpcc_tool">
		<p><label for="wpcc_currency_from">' . __('From', 'wpcc') . ':</label><br />
		<select name="wpcc_currency_from" id="wpcc_currency_from">
		' . $from_currency_options . '
		</select></p>
		
		<p><label for="wpcc_currency_to">' . __('To', 'wpcc') . ':</label><br />
		<select name="wpcc_currency_to" id="wpcc_currency_to">
		' . $to_currency_options . '
		</select></p>
		
		<p><label for="wpcc_currency_amount">' . __('Amount', 'wpcc') . ':</label><br />
		<input type="text" size="4" name="wpcc_currency_amount" id="wpcc_currency_amount" /></p>
		
		<p><input type="button" value="' . __('Convert', 'wpcc') . '" name="wpcc_convert" id="wpcc_convert" />&nbsp;&nbsp;<img src="' . plugins_url('wp-currency-converter/images/converting.gif') . '" alt="" id="wpcc_converting" /></p>
		<p id="wpcc_results"></p>';
		
		echo '</div></div>'; // end widget content
		echo '</div>'; // close widget
		
	}
	
	function retrieveCurrencyOptions($from_or_to = 'from_currencies', $default = '') {
		$wpccOptions = get_option('wpccOptions');
		$currencies = explode("\n", $wpccOptions[$from_or_to]);
		
		$optionsArray = array();
		foreach ($currencies as $currency) {
			$optionsArray[] = '<option value="' . trim($currency) . '"' . 
			(strcasecmp(trim($currency), trim($default)) == 0 ? ' selected="selected"' : '') . '>' . 
			trim($currency) . '</option>';
		}
		
		return implode("\n", $optionsArray);
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = (array)$new_instance;

		$instance['title'] = (!empty($new_instance['title']) ? strip_tags($new_instance['title']) : '');
		$instance['pretool_paragraph'] = $new_instance['pretool_paragraph'];
		$instance['from_default'] = trim(!empty($new_instance['from_default']) ? strip_tags($new_instance['from_default']) : '');
		$instance['to_default'] = trim(!empty($new_instance['to_default']) ? strip_tags($new_instance['to_default']) : '');
		
		return $instance;
	}

	function form($instance) {

		//Defaults
		$defaults = array(
			'title' => __('Currency Converter', 'wpcc'),
			'pretool_paragraph' => __('Try our free currency converter', 'wpcc') . ':',
			'from_default' => '',
			'to_default' => ''
		);
		
		$instance = wp_parse_args( (array)$instance, $defaults );
		
		echo '<p>
		<label for="' . 
		$this->get_field_id('title') . 
		'">' . __('Title', 'wpcc') . ':</label>
		<input type="text" id="' . 
		$this->get_field_id('title') . 
		'" name="' . 
		$this->get_field_name('title') . 
		'" value="' . 
		$instance['title'] . '" />
		</p>';
	
		echo '<p>
		<label for="' . 
		$this->get_field_id('pretool_paragraph') . 
		'">' . __('Pre-tool Paragraph', 'wpcc') . ':</label>
		<textarea id="' . 
		$this->get_field_id('pretool_paragraph') . 
		'" name="' . 
		$this->get_field_name('pretool_paragraph') . 
		'">' . $instance['pretool_paragraph'] . '</textarea>
		</p>';
		
		echo '<p>
		<label for="' . 
		$this->get_field_id('from_default') . 
		'">' . __('Default "From" Currency (eg: USD)', 'wpcc') . ':</label>
		<input type="text" id="' . 
		$this->get_field_id('from_default') . 
		'" name="' . 
		$this->get_field_name('from_default') . 
		'" value="' . 
		$instance['from_default'] . '" />
		</p>';
		
		echo '<p>
		<label for="' . 
		$this->get_field_id('to_default') . 
		'">' . __('Default "To" Currency (eg: USD)', 'wpcc') . ':</label>
		<input type="text" id="' . 
		$this->get_field_id('to_default') . 
		'" name="' . 
		$this->get_field_name('to_default') . 
		'" value="' . 
		$instance['to_default'] . '" />
		</p>';
			
	}
}


add_action('widgets_init', 'wpccRegisterWidget');
function wpccRegisterWidget() {
    register_widget('Widget_WPCC');
}
?>
