<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://beantowers.com/
 * @since      1.0.0
 *
 * @package    Wp_Clients
 * @subpackage Wp_Clients/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Clients
 * @subpackage Wp_Clients/public
 * @author     James Towers <james@songdrop.com>
 */
class Wp_Clients_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->add_shortcodes();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Clients_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Clients_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-clients-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Clients_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Clients_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-clients-public.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Enable shortcode
	 * Adds the [gfd_form] shortcode for displaying the submission form on a page
	 */
	public function add_shortcodes()
	{
		add_shortcode('ghg_clients', array( &$this, 'render_clients_tiles'));
	}

	public function get_clients() {
		
		$args = array(
			'post_type' => 'clients'
			);

		return get_posts( $args );

	}

	public function render_clients_tiles() {
		
		$clients = $this->get_clients();
		$odd = true;

		foreach( $clients as $client ){ 
			$tax = wp_get_post_terms( $client->ID, 'client_type' ); ?>
			
			<div class="tile col6 <?php echo $odd ? '' : 'last' ;?>" data-animate="true">
				<figure>
					<?php
					$attachment_id = get_post_thumbnail_id( $client->ID );
					$img_src = wp_get_attachment_image_url( $attachment_id, 'medium' );
					$img_srcset = wp_get_attachment_image_srcset( $attachment_id, 'medium' );
					?>
					<img src="<?php echo esc_url( $img_src ); ?>"
					     srcset="<?php echo esc_attr( $img_srcset ); ?>"
					     sizes="(max-width: 768px) 100vw, 50vw" alt="<?php echo get_the_title($client->ID);?>">
				</figure>
				<div class="copy">
					<span class="h3" data-animate="true"><?php echo $tax[0]->name;?></span>
					<h2 class="tile-title" data-animate="true"><?php echo get_the_title($client->ID);?></h2>
				</div>
			</div>

		<?php $odd = $odd ? false : true;}

	}

}