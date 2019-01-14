<?php
add_filter('plugins_api', 'misha_plugin_info', 20, 3);
/*
 * $res contains information for plugins with custom update server
 * $action 'plugin_information'
 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
 */
function misha_plugin_info( $res, $action, $args ){

    // do nothing if this is not about getting plugin information
    if( $action !== 'plugin_information' )
        return false;

    // do nothing if it is not our plugin
    if( 'YOUR_PLUGIN_SLUG' !== $args->slug )
        return $res;

    // trying to get from cache first, to disable cache comment 18,28,29,30,32
    if( false == $remote = get_transient( 'misha_upgrade_YOUR_PLUGIN_SLUG' ) ) {

        // info.json is the file with the actual plugin information on your server
        $remote = wp_remote_get( 'https://YOUR_WEBSITE/SOME_PATH/info.json', array(
                'timeout' => 10,
                'headers' => array(
                    'Accept' => 'application/json'
                ) )
        );

        if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
            set_transient( 'misha_upgrade_YOUR_PLUGIN_SLUG', $remote, 43200 ); // 12 hours cache
        }

    }

    if( $remote ) {

        $remote = json_decode( $remote['body'] );
        $res = new stdClass();
        $res->name = $remote->name;
        $res->slug = 'YOUR_PLUGIN_SLUG';
        $res->version = $remote->version;
        $res->tested = $remote->tested;
        $res->requires = $remote->requires;
        $res->author = '<a href="https://rudrastyh.com">Misha Rudrastyh</a>'; // I decided to write it directly in the plugin
        $res->author_profile = 'https://profiles.wordpress.org/rudrastyh'; // WordPress.org profile
        $res->download_link = $remote->download_url;
        $res->trunk = $remote->download_url;
        $res->last_updated = $remote->last_updated;
        $res->sections = array(
            'description' => $remote->sections->description, // description tab
            'installation' => $remote->sections->installation, // installation tab
            'changelog' => $remote->sections->changelog, // changelog tab
            // you can add your custom sections (tabs) here
        );

        // in case you want the screenshots tab, use the following HTML format for its content:
        // <ol><li><a href="IMG_URL" target="_blank"><img src="IMG_URL" alt="CAPTION" /></a><p>CAPTION</p></li></ol>
        if( !empty( $remote->sections->screenshots ) ) {
            $res->sections['screenshots'] = $remote->sections->screenshots;
        }

        $res->banners = array(
            'low' => 'https://YOUR_WEBSITE/banner-772x250.jpg',
            'high' => 'https://YOUR_WEBSITE/banner-1544x500.jpg'
        );
        return $res;

    }

    return false;

}