<?php
/*
Plugin Name: Evanto Author Portal
Plugin URI: https://gitlab.com/jgmuchiri/evanto-author-portal/
Description: Evanto Purchase Verification Plugin. Create a token here https://build.envato.com/create-token/
Version: 1.5
Author: A&M Digital Tech
Contributors: John Muchiri
Author URI: https://amdtllc.com
Donate link: https://cashier.amdtllc.com
Tags: Evanto, CodeCanyon, License, API

License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Installation: Test
*/
define('EAP_VERIFIED_PURCHASES', 'eap_verified_purchases');
define('EAP_AUTHOR_KEY', 'eap_author_key');
define('EAP_USERNAME', 'eap_username');
define('EVANTO_USER_API', 'https://api.envato.com/v3/market/user');

class Evanto_author_portal
{

    public function __construct()
    {
        add_action('admin_menu', [&$this, 'menu_items']);
        add_action('wp_enqueue_scripts', [&$this, 'eap_styles']);
        add_action('admin_enqueue_scripts', [&$this, 'eap_scripts']);

        $this->eap_styles();
        $this->eap_scripts();

        $this->checkUpdate();

        include plugin_dir_path(__FILE__).'functions.php';
    }

    function admin()
    {
        global $wpdb;
        include plugin_dir_path(__FILE__)."lib/Client.php";
        $eap_client = new Client();
        include plugin_dir_path(__FILE__).'views/index.php';
    }

    function eap_styles()
    {
        $dir = plugin_dir_url(__FILE__);
        //styles
        wp_enqueue_style('fa-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('bootstrap', $dir.'assets/css/bootstrap.min.css');
        wp_enqueue_style('style-main', $dir.'assets/css/style.css');
        wp_enqueue_style('datatables', 'https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css');
    }

    function eap_scripts()
    {
        $dir = plugin_dir_url(__FILE__);
        wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.js', [], NULL, TRUE);
        wp_enqueue_script('datatables', '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js', ['jquery'], NULL, TRUE);
//        wp_enqueue_script('bootstrap', $dir.'assets/js/bootstrap.min.js', [], NULL, TRUE);
        wp_enqueue_script('custom', $dir.'assets/js/custom.js', ['jquery'], NULL, TRUE);
    }

    function menu_items()
    {
        // Add a page to manage this plugin's settings
        add_menu_page(
            'Evanto Author',
            'Evanto Author',
            'manage_options',
            'Evanto_author_portal',
            [$this, 'admin'],
            plugin_dir_url(__FILE__).'assets/img/menu-icon.png', 2
        );
    }

    function checkUpdate()
    {

        require_once plugin_dir_path(__FILE__).'updater/updater.php';
//        require_once plugin_dir_path(__FILE__).'updater/plugin-updater.php';
    }

    function activate()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $eap_table = EAP_VERIFIED_PURCHASES;
        $query = "CREATE TABLE {$wpdb->prefix}{$eap_table} (
                id int auto_increment primary key,
                purchase_code VARCHAR(255) NOT NULL,
                item_id varchar(255) null,
                item_name varchar(255) null,
                buyer varchar(255) null,
                purchase_date varchar(255) null,
                licence_type varchar(255) null,
                supported_until varchar(255) null) $charset_collate;";
        require_once ABSPATH.'wp-admin/includes/upgrade.php';
        dbDelta($query);

        //check table created
        if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}$eap_table'") != $wpdb->prefix.$eap_table) {
            die('Unable to create database. Check plugin.');
        }

        add_option(EAP_AUTHOR_KEY, '');
        add_option(EAP_USERNAME, '');
    }

    function deactivate()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix.EAP_VERIFIED_PURCHASES);

        delete_option(EAP_AUTHOR_KEY);
        delete_option(EAP_USERNAME);
    }
}

/**
 * START PLUGIN ACTIONS
 */
if(class_exists('Evanto_author_portal')) {
    //install
    register_activation_hook(__FILE__, ['Evanto_author_portal', 'activate']);
    //uninstall
    register_deactivation_hook(__FILE__, ['Evanto_author_portal', 'deactivate']);

    // Instantiate the plugin class
    $eap_author = new Evanto_author_portal();

    // Add a link to the settings page onto the plugin page
    if(isset($eap_author)) {
        // Add the settings link to the plugins page
        function eap_listing_settings_link($links)
        {
            $settings_link = '<a href="?page=Evanto_author_portal">Evanto Author</a>';
            array_unshift($links, $settings_link);
            return $links;
        }

        $plugin = plugin_basename(__FILE__);
        add_filter("plugin_action_links_$plugin", 'eap_listing_settings_link');
    }
}