<?php
/**
 * Created by PhpStorm.
 * User: shabir
 * Date: 6/10/16
 * Time: 10:45 PM
 */
namespace Shabirmanu\SocialNet;


use App\Http\Controllers\Controller;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Facebook;

class FacebookController extends Controller
{

    protected $fbh;
    protected $access_token;
    protected $helper;

    public function __construct() {
        $this->fbh = new Facebook([
            'app_id' => config('fb_app_id'),
            'app_secret' => config('fb_secret'),
            'default_graph_version' => 'v2.5',
        ]);

        $this->access_token = $this->_setAccessToken();
        $this->helper = $this->fbh->getRedirectLoginHelper();
    }

    private function _setAccessToken() {
        $helper = $this->fbh->getRedirectLoginHelper();
        try {
            $access_token = $helper->getAccessToken();
        }
        catch(FacebookResponseException $e) {
            dd($e->getMessage());
        }
        return $access_token;
    }

    public function index() {
        $permission = ['email'];

        $url = $this->access_token ? $this->helper->getLogoutUrl(): $this->helper->getLoginUrl(route('socialnet.fb-callback'), $permission);
        return view('views.index', compact('url'));
    }

}