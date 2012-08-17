<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Constants.php';
require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Twitter/Interface.php';
require_once realpath(__DIR__) . '/../UserMock.php';

class SE_Auth_Adapter_Doctrine_Model_Method_TwitterMock implements SE_Auth_Adapter_Doctrine_Model_Method_Twitter_Interface {

    public $twitterId;
    public $accessToken;
    public $accessTokenSecret;
    public $status;
    public $user;

    public function  __construct($status = SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_ACTIVE) {
        $this->twitterId = 'twitter user id';
        $this->accessToken = 'twitter access token';
        $this->accessTokenSecret = 'twitter access token secret';
        $this->status = $status;
        $this->user = new SE_Auth_Adapter_Doctrine_Model_UserMock(1);
    }

    public function fetchAccessToken() {
        return $this->accessToken;
    }

    public function fetchAccessTokenSecret() {
        return $this->$accessTokenSecret;
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
        return 'Twitter';
    }

    public function fetchSlug() {
        return 'twitter';
    }

    public function fetchStatus() {
        return $status;
    }

    public function fetchUser($twitterId = '', $accessToken = '', $accessTokenSecret = '') {
        if ($twitterId == $this->twitterId) {
            if (SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_INACTIVE == $this->status) {
                throw new Exception(
                    $this->fetchMessage(SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE),
                    SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE
                );
            } else {
                return $this->user;
            }
        } else {
            throw new Exception(
                $this->fetchMessage(SE_Auth_Adapter_Doctrine_Model_Method_Constants::CREDENTIAL_INVALID),
                SE_Auth_Adapter_Doctrine_Model_Method_Constants::CREDENTIAL_INVALID
            );
        }
    }

    public function fetchTwitterId() {
        return $this->twitterId;
    }

}
