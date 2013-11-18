<?php
/*******************************************************************************
** WP Currency Converter Shortcode Display
** Description: A clever widget for displaying a currency conversion tool
** @since 1.2
*******************************************************************************/
function wpccByShortcode($atts) {
    global $wp_widget_factory;
    
    extract(
    	shortcode_atts(
    		array(
    			'title' => '',
    			'pretool_paragraph' => __('Currency conversion tool provided by WP Currency Converter', 'wpcc'),
    			'from_default' => '',
    			'to_default' => ''
    		), 
    		$atts
    	)
    );
    
    $widget_name = 'Widget_WPCC';
    
	$instance = "title=$title";
    
    if (!empty($pretool_paragraph)) $instance .= "&pretool_paragraph=$pretool_paragraph";
    if (!empty($from_default)) $instance .= "&from_default=$from_default";
    if (!empty($to_default)) $instance .= "&to_default=$to_default";
        
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')) {
        $wp_class = 'WP_Widget_' . ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')) {
            return '<p>' . __('ERROR: WP Currency Converter widget has not been initialized properly.', 'wpcc') . '</p>';
    	} else {
            $class = $wp_class;
    	}
    }
    
    ob_start();
    
    the_widget(
    	$widget_name, 
    	$instance, 
    	array(
			'widget_id' => 'shortcode-wpcc-widget-' . $id,
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '',
			'after_title' => '',
			'inline' => true // tells widget not to wrap itself in list tags
		)
	);
	
    $output = ob_get_contents();
    
    ob_end_clean();
    
    return $output;
    
}

add_shortcode('wpcc','wpccByShortcode',1); 

?>
