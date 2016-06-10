<?php
/**
 * Created by PhpStorm.
 * User: shabir
 * Date: 6/10/16
 * Time: 6:53 PM
 */

namespace ShabirmanuSocialNetSDK;


use Illuminate\Support\ServiceProvider;

class SocialNetSDKServiceProvider extends ServiceProvider {

    public function boot() {
        $this->loadViewsFrom(__DIR__.'/views', 'social-net-sdk');

        $this->_publishThings();
    }

    private function _publishThings() {
        $this->publishes([
            __DIR__.'views' => base_path('resources/views/shabirmanu/social-net-sdk'),
            __DIR__.'/config/SocialNetSDK.php' => config_path('social-net-config'),
        ]);
    }
    public function register() {
        include __DIR__.'/routes.php';
        $this->registerFacebook();
        $this->registerTwitter();

        $this->mergeConfigFrom(
            __DIR__ . '/config/SocialNetSDK.php', 'social-net-config'
        );

    }

    private function registerFacebook() {
        $this->app->bind('FacebookController', function($app) {
            return new FacebookController();
        });
    }

    private function registerTwitter() {
        $this->app->bind('TwitterController', function($app) {
            return new TwitterController();
        });
    }
}