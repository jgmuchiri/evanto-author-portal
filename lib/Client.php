<?php
/**
 * @package     default
 * @copyright   2019 A&M Digital Technologies
 * @author      John Muchiri
 * @link        https://amdtllc.com
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

class Client
{

    public $methods, $sites, $site, $uri;

    protected $bearer;

    function __construct($args = [])
    {
        $this->bearer = get_option(EAP_AUTHOR_KEY);

        $username = get_option(EAP_USERNAME);
        $site = EVANTO_DEFAULT_SITE;

        if(isset($_GET['site'])) {
            $site = $_GET['site'];
        }

        $this->sites = [
            'codecanyon',
            'themeforest',
            'videohive',
            'audiojungle',
            'graphicriver',
            'photodune',
            '3docean',
        ];

        $this->methods = [
            // User details
            'profile' => [
                'collections' => EVANTO_USER_API_V3.'user/collections',
                'collection' => EVANTO_USER_API_V3.'user/collection',
                'bookmarks' => EVANTO_USER_API_V3.'market/user/bookmarks',
                'details' => EVANTO_USER_API_V1.'user:'.$username.'.json',
                'badges' => EVANTO_USER_API_V1.'user-badges:'.$username.'.json',
                'items' => EVANTO_USER_API_V1.'user-items-by-site:'.$username.'.json',
                'newest' => EVANTO_USER_API_V1.'new-files-from-user:'.$username,
            ],
            // Private user details
            'user' => [
                'sales' => EVANTO_USER_API_V3.'author/sales',
                'sale' => EVANTO_USER_API_V3.'author/sale',
                'purchases' => EVANTO_USER_API_V3.'buyer/list-purchases',
                'purchase' => EVANTO_USER_API_V3.'buyer/purchase',

                'details' => EVANTO_USER_API_V1.'private/user/account.json',
                'username' => EVANTO_USER_API_V1.'private/user/username.json',
                'email' => EVANTO_USER_API_V1.'private/user/email.json',
                'month-sales' => EVANTO_USER_API_V1.'private/user/earnings-and-sales-by-month.json',
            ],
            'catalog' => [
                'item' => EVANTO_USER_API_V3.'catalog/item',
                'random' => EVANTO_USER_API_V1.'random-new-files:'.$site.'.json',
                'featured' => EVANTO_USER_API_V1.'features:'.$site.'.json',
                'popular' => EVANTO_USER_API_V1.'popular:'.$site.'.json',
            ],
        ];

    }

    function fetchData($uri)
    {
        if(empty($this->bearer)) {
            return [
                'status' => 'error',
                'error' => 'Error',
                'message' => 'No bearer key provided',
            ];
        }

        //setting the header for the rest of the api
        $bearer = 'bearer '.$this->bearer;

        $header = [];
        $header[] = 'Content-length: 0';
        $header[] = 'Content-type: application/json; charset=utf-8';
        $header[] = 'Authorization: '.$bearer;

        $evanto_api_url = curl_init($uri);
        curl_setopt($evanto_api_url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($evanto_api_url, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($evanto_api_url, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($evanto_api_url, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($evanto_api_url, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $data = curl_exec($evanto_api_url);
        curl_close($evanto_api_url);

        if($data != "")
            return json_decode($data);

        return [
            'status' => 'error',
            'error' => 'Error!',
            'message' => 'No data found',
        ];

    }
}

?>