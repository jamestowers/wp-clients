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


	public function post_meta_boxes_setup()
	{
	  /* Add meta boxes on the 'add_meta_boxes' hook. */
	  add_action( 'add_meta_boxes', array( &$this, 'add_client_meta_boxes') );
	  /* Save post meta on the 'save_post' hook. */
	  add_action( 'save_post', array( &$this, 'save_featured_client_meta'), 10, 2 );
	}


	public function add_client_meta_boxes($postType)
	{
	  if(in_array($postType, array('clients'))){
	    add_meta_box(
	      $this->plugin_name . '_client_meta_box',      // Unique ID
	      esc_html__( 'Feature Client', $this->plugin_name ),    // Title
	      array( &$this, 'render_featured_client_meta_box'),   // Callback function
	      $postType,         // Admin page (or post type)
	      'side',         // Context
	      'default'       // Priority
	    );
	  }
	}

	public function render_featured_client_meta_box( $object, $box ) { 

	  $meta_key = $this->plugin_name . '_featured_client';
		$current = get_post_meta($object->ID, $meta_key, true);
		// Add nonce field - use meta key name with '_nonce' appended
    wp_nonce_field( basename( __FILE__ ), $meta_key . '_nonce' );

    echo '<p class="description">' .  _e( "Make this a <em>big</em> client on the homepage ", $this->plugin_name ) . '</p>';

    $checked = $current ? 'checked="checked"' : '';
    echo '<input type="checkbox" value="1" name="' . $meta_key . '" ' . $checked . ' /><br>';
	  
	}

		public function save_featured_client_meta( $post_id, $post )
	  {
	    $this->save_meta($post_id, $post, $this->plugin_name . '_featured_client'); 
	  }

	public function save_meta($post_id, $post, $meta_key)
	{
	  $this->verify_nonce($meta_key . '_nonce', $post_id);

	  /* Get the post type object. */
	  $post_type = get_post_type_object( $post->post_type );
	  /* Check if the current user has permission to edit the post. */
	  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	    return $post_id;

	  /* Get the posted data and sanitize it for use as an HTML class. */
	  $new_meta_value = ( isset( $_POST[$meta_key] ) ? sanitize_html_class( $_POST[$meta_key] ) : '' );

	  $this->save_or_edit_meta($post_id, $meta_key, $new_meta_value);
	}

	public function verify_nonce($nonce_key, $post_id)
	{
	  if ( !isset( $_POST[$nonce_key] ) || !wp_verify_nonce( $_POST[$nonce_key], basename( __FILE__ ) ) )
	    return $post_id;
	}



	public function save_or_edit_meta($post_id, $meta_key, $new_meta_value)
	{
		  log_it($new_meta_value);
	  /* Get the meta value of the custom field key. */
	  $meta_value = get_post_meta( $post_id, $meta_key, true );

	  /* If a new meta value was added and there was no previous value, add it. */
	  if ( $new_meta_value && '' == $meta_value )
	    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	  /* If the new meta value does not match the old value, update it. */
	  elseif ( $new_meta_value && $new_meta_value != $meta_value )
	    update_post_meta( $post_id, $meta_key, $new_meta_value );

	  /* If there is no new meta value but an old value exists, delete it. */
	  elseif ( '' == $new_meta_value && $meta_value )
	    delete_post_meta( $post_id, $meta_key, $meta_value );
	}

}
