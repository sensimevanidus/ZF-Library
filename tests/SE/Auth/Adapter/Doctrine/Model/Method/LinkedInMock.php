<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Constants.php';
require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/LinkedIn/Interface.php';
require_once realpath(__DIR__) . '/../UserMock.php';

class SE_Auth_Adapter_Doctrine_Model_Method_LinkedInMock implements SE_Auth_Adapter_Doctrine_Model_Method_LinkedIn_Interface {

    public $linkedInId;
    public $accessToken;
    public $accessTokenSecret;
    public $status;
    public $user;

    public function  __construct($status = SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_ACTIVE) {
        $this->linkedInId = 'linkedin user id';
        $this->accessToken = 'linkedin access token';
        $this->accessTokenSecret = 'linkedin access token secret';
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
        return 'LinkedIn';
    }

    public function fetchSlug() {
        return 'linkedin';
    }

    public function fetchStatus() {
        return $status;
    }

    public function fetchUser($linkedInId = '', $accessToken = '', $accessTokenSecret = '') {
        if ($linkedInId == $this->linkedInId) {
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

    public function fetchLinkedInId() {
        return $this->linkedInId;
    }

}
