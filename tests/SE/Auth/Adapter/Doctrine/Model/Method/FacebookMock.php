<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Constants.php';
require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Facebook/Interface.php';
require_once realpath(__DIR__) . '/../UserMock.php';

class SE_Auth_Adapter_Doctrine_Model_Method_FacebookMock implements SE_Auth_Adapter_Doctrine_Model_Method_Facebook_Interface {

    public $facebookId;
    public $accessToken;
    public $accessTokenScope;
    public $status;
    public $user;

    public function  __construct($status = SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_ACTIVE) {
        $this->facebookId = 'facebook user id';
        $this->accessToken = 'facebook access token';
        $this->accessTokenScope = 'facebook access token scope';
        $this->status = $status;
        $this->user = new SE_Auth_Adapter_Doctrine_Model_UserMock(1);
    }

    public function fetchAccessToken() {
        return $this->accessToken;
    }

    public function fetchAccessTokenScope() {
        return $this->$accessTokenScope;
    }

    public function fetchMessage($errorCode) {
        switch($errorCode) {
            case SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE:
                return 'Inactive account!';
                break;
            case SE_Auth_Adapter_Doctrine_Model_Method_Constants::CREDENTIAL_INVALID:
                return 'Account not found!';
                break;
            case SE_Auth_Adapter_Doctrine_Model_Method_Constants::IDENTITY_NOT_FOUND:
                return 'Password wrong!';
                break;
            case SE_Auth_Adapter_Doctrine_Model_Method_Constants::SUCCESS:
                return 'Congratulations!';
                break;
            default:
                return 'An error occured!';
        }
    }

    public function fetchName() {
        return 'Facebook';
    }

    public function fetchSlug() {
        return 'facebook';
    }

    public function fetchStatus() {
        return $status;
    }

    public function fetchUser($facebookId = '', $accessToken = '', $accessTokenScope = '') {
        if ($facebookId == $this->facebookId) {
            if ($accessToken == $this->accessToken && $accessTokenScope == $this->accessTokenScope) {
                if (SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_ACTIVE == $this->status) {
                    return $this->user;
                } else {
                    throw new Exception(
                        $this->fetchMessage(SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE),
                        SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE
                    );
                }
            } else {
                throw new Exception(
                    $this->fetchMessage(SE_Auth_Adapter_Doctrine_Model_Method_Constants::IDENTITY_NOT_FOUND),
                    SE_Auth_Adapter_Doctrine_Model_Method_Constants::IDENTITY_NOT_FOUND
                );
            }
        } else {
            throw new Exception(
                $this->fetchMessage(SE_Auth_Adapter_Doctrine_Model_Method_Constants::CREDENTIAL_INVALID),
                SE_Auth_Adapter_Doctrine_Model_Method_Constants::CREDENTIAL_INVALID
            );
        }
    }

    public function fetchFacebookId() {
        return $this->facebookId;
    }

}