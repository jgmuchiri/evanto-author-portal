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

    public $methods;

    protected $bearer;

    function __construct($args=[])
    {
        $this->bearer = get_option(EAP_AUTHOR_KEY);

        $username = get_option(EAP_USERNAME);

        $this->methods = [
            // User details
            'profile' => [
                'collections' => '/v3/market/user/collections',
                'collection' => '/v3/market/user/collection',
                'details' => '/v1/market/user:'.$username.'.json',
                'badges' => '/v1/market/user-badges:'.$username.'.json',
                'portfolio' => '/v1/market/user-items-by-site:'.$username.'.json',
                'newest' => '/v1/market/new-files-from-user:'.$username.',{site}.json',
            ],
            // Private user details
            'user' => [
                'sales' => '/v3/market/author/sales',
                'sale' => '/v3/market/author/sale',
                'purchases' => '/v3/market/buyer/list-purchases',
                'purchase' => '/v3/market/buyer/purchase',
                'details' => '/v1/market/private/user/account.json',
                'username' => '/v1/market/private/user/username.json',
                'email' => '/v1/market/private/user/email.json',
                'month-sales' => '/v1/market/private/user/earnings-and-sales-by-month.json',
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

        $evanto_api_url = curl_init('https://api.envato.com'.$uri);
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