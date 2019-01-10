<?php

class Verify_purchase
{

    // Bearer, no need for OAUTH token, change this to your bearer string
    // https://build.envato.com/api/#token
    private $bearer = '';

    function __construct($args = [])
    {
        $this->bearer = $args['bearer'];
    }

    function getPurchaseData($code)
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

        $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$code.'.json';
        $ch_verify = curl_init($verify_url.'?code='.$code);

        curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        $cinit_verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        if($cinit_verify_data != "")
            return json_decode($cinit_verify_data);

        return [
            'status' => 'error',
            'error' => 'Error!',
            'message' => 'No data found',
        ];

    }

    function verifyPurchase($code)
    {
        $verify_obj = self::getPurchaseData($code);
        if(is_object($verify_obj) && $verify_obj->message == 'Unauthorized') {
            return [
                'status' => 'error',
                'error' => 'Unauthorized!',
                'message' => 'Check you author API key and try again',
            ];
        }

        //Validate code
        if(
            (FALSE === $verify_obj) ||
            !is_object($verify_obj) ||
            !isset($verify_obj->{"verify-purchase"}) ||
            !isset($verify_obj->{"verify-purchase"}->item_name)) {
            return [
                'status' => 'error',
                'error' => 'Unverified!',
                'message' => 'Sorry, this purchase code is invalid or does not exist',
            ];
        }

        if($verify_obj->{"verify-purchase"}->supported_until == "" ||
            $verify_obj->{"verify-purchase"}->supported_until != NULL) {
            return $verify_obj->{"verify-purchase"};
        }

        return [
            'status' => 'error',
            'error' => 'Not verified!',
            'message' => 'Sorry, this purchase code is invalid or does not exist',
        ];

    }

    function verify()
    {
        global $wpdb;
        if(isset($_POST['purchase_code'])) {
            $purchase_code = htmlspecialchars(trim($_POST['purchase_code']));
            $result = self::verifyPurchase($purchase_code);
            if(is_object($result)) {
                $data = [
                    'purchase_code' => $purchase_code,
                    'item_name' => $result->item_name,
                    'item_id' => $result->item_id,
                    'purchase_date' => date('Y-m-d H:i:s', strtotime($result->created_at)),
                    'licence_type' => $result->licence,
                    'supported_until' => $result->supported_until,
                    'buyer' => $result->buyer,
                ];

                $item = $wpdb->get_row('SELECT purchase_code FROM '.$wpdb->prefix.EAP_VERIFIED_PURCHASES.' WHERE purchase_code ='.$purchase_code, 'ARRAY_A');

                if(empty($item))
                    $wpdb->insert($wpdb->prefix.EAP_VERIFIED_PURCHASES, $data);
            }

            return $result;
        }
    }
}

?>