<?php
/**
 * Created by PhpStorm.
 * User: mrussell
 * Date: 1/4/17
 * Time: 2:08 PM
 */

namespace App;

use Illuminate\Support\Facades\Cache;
use SugarAPI\SDK\Client\Abstracts\AbstractSugarClient;

class SugarClient extends AbstractSugarClient {

    protected static $_token_cache = 'sugarcrm_token';

    protected static $_Client;

    protected static function init(){
        $server = config('sugar.server');
        $username = config('sugar.username');
        $password = config('sugar.password');
        $client_id = config('sugar.client_id');
        $client_secret = config('sugar.client_secret');
        $platform = config('sugar.platform');
        if (empty($server) || empty($username) || empty($password)){
            throw new \Exception("SugarCRM client not configured.");
        }
        $Client = new static($server,array(
            'username' => $username,
            'password' => $password,
            'client_id' => (empty($client_id)?'sugar':$client_id),
            'client_secret' => (empty($client_secret)?'':$client_secret),
            'platform' => (empty($platform)?'api':$platform)
        ));
        if (!$Client->authenticated()){
            $Client->login();
        }
        return $Client;
    }

    public static function instance(){
        if (!isset(static::$_Client)){
            static::$_Client = static::init();
        }
        return static::$_Client;
    }

    public function authenticated(){
        if (!parent::authenticated()&&(isset($this->token)&&is_object($this->token))){
            if ($this->token->refresh_expiration < time()){
                return $this->refreshToken();
            }
        }
        return FALSE;
    }

    /**
     * @inheritdoc
     * @param \stdClass $token
     */
    public static function storeToken($token, $credentials) {
        parent::storeToken($token,$credentials);
        Cache::put(static::$_token_cache,$token,$token->refresh_expires_in);
        return TRUE;
    }
    /**
     * @inheritdoc
     */
    public static function getStoredToken($client_id) {
        $token = parent::getStoredToken($client_id);
        if (empty($token) && Cache::has(self::$_token_cache)){
            $token = Cache::get(self::$_token_cache,NULL);
        }
        return $token;
    }
    /**
     * @inheritdoc
     */
    public static function removeStoredToken($credentials) {
        Cache::forget(self::$_token_cache);
        return parent::removeStoredToken($credentials);
    }
}