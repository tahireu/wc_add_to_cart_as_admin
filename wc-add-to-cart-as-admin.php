<?php
/**
 * Plugin Name:     WC Add To Cart As Admin
 * Plugin URI:      https://github.com/tahireu/wc_add_to_cart_as_admin
 * Description:     Add products to your customer's cart from WP admin side.
 * Version:         1.0.0
 * Author:          Tahireu
 * Author URI:      https://github.com/tahireu/
 * License:         GPL
 * License URI:     http://www.opensource.org/licenses/gpl-license.php
 */


/*
 * Prevent intruders from sneaking around
 * */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/*
 * Variables
 * */
const ATCAA_TEXT_DOMAIN = "wc-add-to-cart-as-admin";


/*
 * Load ATCAA_Activator class before WooCommerce check
 * */
require plugin_dir_path( __FILE__ ) . 'includes/class-atcaa-activator.php';



/*
 * Check if WooCommerce is installed and active
 * */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {


    /*
     * Current plugin version - https://semver.org
     * This should be updated as new versions are released
     * */
    if( !defined( 'WC_TRY_BEFORE_YOU_BUY_VERSION' ) ) {
        define( 'WC_TRY_BEFORE_YOU_BUY_VERSION', '1.0.0' );
    }



    /*
     * Create database table on plugin activation
     * */
    function create_table(){
        ATCAA_activator::create_table();
    }

    register_activation_hook( __FILE__, 'create_table' );




    /*
     * Do the work
     * */
    require plugin_dir_path( __FILE__ ) . 'functions.php';

    if ( is_admin() ) {
        require plugin_dir_path(__FILE__) . 'admin/class-atcaa-admin.php';
        ATCAA_admin::on_load();
    }

    require plugin_dir_path(__FILE__) . 'public/class-atcaa-public.php';
    ATCAA_public::on_load();


} else {

    /*
     * Abort and display info message
     * */
    ATCAA_activator::abort();

}