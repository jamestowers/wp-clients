<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://beantowers.com/
 * @since      1.0.0
 *
 * @package    Wp_Clients
 * @subpackage Wp_Clients/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Clients
 * @subpackage Wp_Clients/admin
 * @author     James Towers <james@songdrop.com>
 */
class Wp_Clients_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-clients-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-clients-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function create_post_types()
	{
		register_post_type( 'clients',
		  array(
		    'labels' => array(
		      'name' => __( 'Clients' ),
		      'singular_name' => __( 'Client' ),
		      'add_new' => __( 'Add new client' ),
		      'add_new_item' => __( 'Add New Client' ),
		      'edit_item' => 'Edit Client',
		      'featured_image' => __( 'Client image' ),
		      'use_featured_image' => __( 'Use as client image' ),
		      'archives' => __( 'Client archives' )
		    ),
		    'public' => true,
		    'menu_icon' => 'dashicons-groups',
		    'supports' => array(
		    	'title',
		    	'editor' => true,
		    	'thumbnail',
		    	//'page-attributes',
		    	),
		    'rewrite' => array( 
		    	'slug' => 'clients', 
		    	'with_front' => true 
		    ),
		    'has_archive' => 'clients',
		  )
		);
	}

	public function create_taxonomies()
	{
	  register_taxonomy(
	    'client_type',
	    array('clients', 'post'),
	    array(
	      'label' => __( 'Client Type' ),
	      'rewrite' => array( 'slug' => 'client_type' ),
	      'hierarchical' => true,
	      'labels' => array(
					'name'              => _x( 'Client Types', 'taxonomy general name', 'ghg' ),
					'singular_name'     => _x( 'Client Type', 'taxonomy singular name', 'ghg' ),
					'search_items'      => __( 'Search Client Types', 'ghg' ),
					'all_items'         => __( 'All Client Types', 'ghg' ),
					'parent_item'       => __( 'Parent Client Type', 'ghg' ),
					'parent_item_colon' => __( 'Parent Client Type:', 'ghg' ),
					'edit_item'         => __( 'Edit Client Type', 'ghg' ),
					'update_item'       => __( 'Update Client Type', 'ghg' ),
					'add_new_item'      => __( 'Add New Client Type', 'ghg' ),
					'new_item_name'     => __( 'New Client Type Name', 'ghg' ),
					'menu_name'         => __( 'Client Type', 'ghg' ),
				)
	    )
	  );
	}

}
