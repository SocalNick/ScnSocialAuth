<?php
namespace ScnSocialAuth\HybridAuth\Provider;

/**
 * This is simply to trigger autoloading as a hack for poor design in HybridAuth.
 */
class Odnoklassniki extends \Hybrid_Providers_Odnoklassniki
{
    public $curl_time_out         = 30;
    public $curl_connect_time_out = 30;
    public $curl_ssl_verifypeer   = false;
    public $curl_auth_header      = true;
    public $curl_useragent        = "OAuth/2 Simple PHP Client v0.1; HybridAuth http://hybridauth.sourceforge.net/";
    public $curl_proxy            = null;
    public $curl_header           = array("Accept: application/json; charset=UTF-8");
    public $http_info             = "";
}
