<?php
/* 
Plugin Name: Top Level Category Widget
Version: 1.0
Description: Widget listing only top level categories.
Author: Zaantar
Author URI: http://zaantar.eu
Donate Link: http://zaantar.eu/financni-prispevek
License: GPL2
*/


class TopLevelCategoryWidget extends WP_Widget {


	const txd = "top-level-category-widget";
	const wid = self::txd;
	
	
	static function register_widget() {
		register_widget( 'TopLevelCategoryWidget' ); 
	}
	
	
	static function load_textdomain() {
		load_plugin_textdomain( TopLevelCategoryWidget::txd, false, basename( dirname(__FILE__) ).'/languages' );
	}

	
	function TopLevelCategoryWidget() {
		$this->__construct();
	}

	
	function __construct() {
		$widget_ops = array( "classname" => self::wid, "description" => __( "Widget listing only top level categories", self::txd ) );
		parent::__construct( self::wid, __( "Top Level Category Widget", self::txd ), $widget_ops );
	}
	
	
	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		/*$exclude = explode( ',', $instance['exclude'] );
		sort( $exclude );
		$exclude = implode( ",", $exclude ); */
		$exclude = "1";

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display widget content. */
		wp_list_categories( array(
			"orderby" => "ID",
			"order" => "ASC",
			"style" => "list",
			"hide_empty" => 0,
			"depth" => 1,
			"hierarchical" => 1,
			"exclude" => $exclude,
			"title_li" => NULL
		) );
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		//$instance['exclude'] = strip_tags( $new_instance['exclude'] );

		return $instance;
	}
	
	
	function form( $instance ) {
unregister_widget( 'WP_Widget_Categories' );
	
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __( 'Categories', self::txd) , 'exclude' => '1' );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', self::txd ); ?>:</label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>
		<?php /*
			<p>
				<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e( 'Categories to exclude', self::txd ); ?>:</label>
				<input id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" style="width:100%;" /><br />
				<label><small><?php _e( 'Enter category IDs separated by commas.', self::txd ); ?></small></label>
			</p>
			
		<?php */
	}
	
}


add_action( 'widgets_init', "TopLevelCategoryWidget::register_widget" ); 

/*function tlcw_register_widget() { 
	register_widget( 'TopLevelCategoryWidget' ); 
	unregister_widget( 'WP_Widget_Categories' );	
}*/

add_action( 'init', "TopLevelCategoryWidget::load_textdomain" ); 



?>
