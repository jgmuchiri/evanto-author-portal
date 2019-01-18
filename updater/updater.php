<?php
define('PLUGIN_SLUG', 'evanto-author-portal');
define('PLUGIN_JSON', 'https://amdtllc.com/wp/plugins/evanto-author-portal');
define('PLUGIN_BANNER_LOW', 'https://snag.gy/xs4EbG.jpg');//772x250
define('PLUGIN_BANNER_HIGH', 'https://snag.gy/xs4EbG.jpg');//1544x500
define('PLUGIN_CACHE_TIME', 43200); //12 hrs

/*
 * $res contains information for plugins with custom update server 
 * $action 'plugin_information'
 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
 */
add_filter('plugins_api', 'evanto_author_info', 20, 3);
function evanto_author_plugin_info($res, $action, $args)
{
    // do nothing if this is not about getting plugin information
    if($action !== 'plugin_information')
        return FALSE;

    // do nothing if it is not our plugin	
    if(PLUGIN_SLUG !== $args->slug)
        return $res;

    // trying to get from cache first, to disable cache comment 18,28,29,30,32
    if(FALSE == $remote = get_transient('gatebe_upgrade_'.PLUGIN_SLUG)) {

        // info.json is the file with the actual plugin information on your server
        $remote = wp_remote_get(PLUGIN_JSON.'/?token='.get_option(EAP_UPDATE_TOKEN), [
                'timeout' => 10,
                'headers' => [
                    'Accept' => 'application/json',
                ]]
        );

        if(!is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && !empty($remote['body'])) {
            set_transient('gatebe_upgrade_'.PLUGIN_SLUG, $remote, PLUGIN_CACHE_TIME);
        }

    }

    if($remote) {

        $remote = json_decode($remote['body']);
        $res = new stdClass();
        $res->name = $remote->name;
        $res->slug = PLUGIN_SLUG;
        $res->version = $remote->version;
        $res->tested = $remote->tested;
        $res->requires = $remote->requires;
        $res->author = '<a href="'.$remote->author_homepage.'">'.$remote->author.'</a>';
        $res->author_profile = $remote->author_homepage; // WordPress.org profile
        $res->download_link = $remote->download_url;
        $res->trunk = $remote->download_url;
        $res->last_updated = $remote->last_updated;
        $res->sections = [//tabs you can add your custom sections (tabs) here
            'description' => $remote->sections->description,
            'installation' => $remote->sections->installation,
            'changelog' => $remote->sections->changelog,
        ];

        // in case you want the screenshots tab, use the following HTML format for its content:
        // <ol><li><a href="IMG_URL" target="_blank"><img src="IMG_URL" alt="CAPTION" /></a><p>CAPTION</p></li></ol>
        if(!empty($remote->sections->screenshots)) {
            $res->sections['screenshots'] = $remote->sections->screenshots;
        }

        $res->banners = [
            'low' => PLUGIN_BANNER_LOW,
            'high' => PLUGIN_BANNER_HIGH,
        ];
        return $res;
    }

    return FALSE;

}

add_filter('site_transient_update_plugins', 'evanto_author_push_update');
function evanto_author_push_update($transient)
{
    if(empty($transient->checked)) {
        return $transient;
    }
    // trying to get from cache first
    if(FALSE == $remote = get_transient('evanto_author_upgrade_'.PLUGIN_SLUG)) {

        // info.json is the file with the actual plugin information on your server
        $remote = wp_remote_get(PLUGIN_JSON.'/?token='.get_option(EAP_UPDATE_TOKEN),  [
                'timeout' => 10,
                'headers' => [
                    'Accept' => 'application/json',
                ]]
        );

        if(!is_wp_error($remote) && isset($remote['response']['code']) && $remote['response']['code'] == 200 && !empty($remote['body'])) {
            set_transient('evanto_author_upgrade_'.PLUGIN_SLUG, $remote, PLUGIN_CACHE_TIME);
        }

    }
    if($remote) {
        $remote = json_decode($remote['body']);
        $plugin = PLUGIN_SLUG.'/'.PLUGIN_SLUG.'.php';

        // your installed plugin version should be on the line below! You can obtain it dynamically of course
        if($remote && version_compare($transient->checked[$plugin], $remote->version, '<') ){
//            && version_compare($remote->requires, get_bloginfo('version'), '<')) {
            $res = new stdClass();

            $res->slug = PLUGIN_SLUG;
            $res->plugin = $plugin;
            $res->new_version = $remote->version;
            $res->tested = $remote->tested;
            $res->package = $remote->download_url;
            $res->url = $remote->author_homepage;
            //
            $res->last_updated = $remote->last_updated;
            $res->requires = $remote->requires;

            $transient->response[$res->plugin] = $res;
            $transient->checked[$res->plugin] = $remote->version;
        }

    }
    return $transient;
}

add_action('upgrader_process_complete', 'evanto_author_after_update', 10, 2);
function evanto_author_after_update($upgrader_object, $options)
{
    if($options['action'] == 'update' && $options['type'] === 'plugin') {
        // just clean the cache when new plugin version is installed
        delete_transient('evanto_author_upgrade_'.PLUGIN_SLUG);
    }
}
