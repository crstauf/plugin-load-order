<?php
/*
Plugin Name: Plugin Load Order
Plugin URI: 
Description: 
Version: 0.0.1
Author: Caleb Stauffer
Author URI: http://develop.calebstauffer.com
*/

new css_plugin_load_order;
class css_plugin_load_order {

	public static $hook = '';
	public static $active_plugins = array();

	function __construct() {
		if (!is_admin()) return;
		add_action('admin_menu',array(__CLASS__,'menu'));
		add_action('wp_ajax_change_plugin_load_order',array(__CLASS__,'ajax'));
	}

	public static function menu() {
		self::$hook = add_submenu_page('plugins.php','Plugin Load Order','Load Order','install_plugins','plugin-load-order',array(__CLASS__,'screen'));
		add_action('admin_print_scripts-' . self::$hook,array(__CLASS__,'includes'));
	}

	public static function includes() {
		wp_enqueue_script('plugin-load-order',plugin_dir_url(__FILE__) . 'admin.js',array('jquery','jquery-ui-sortable'));
		wp_enqueue_style('plugin-load-order',plugin_dir_url(__FILE__) . 'admin.css');
	}

	public static function screen() {
		self::$active_plugins = get_option('active_plugins');
		?>

		<h2>Plugin Load Order <span class="spinner"></span></h2>

		<ul id="plugin-load-order">
			<?php
			foreach (self::$active_plugins as $plugin_path) {
				$plugin = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin_path);
				echo '<li data-plugin-path="' . $plugin_path . '">' . $plugin['Name'] . '</li>';
			}
			?>
		</ul>

		<?php
	}

	public static function ajax() {
		update_option('active_plugins',$_POST['rows']);
		wp_die();
	}

}

?>