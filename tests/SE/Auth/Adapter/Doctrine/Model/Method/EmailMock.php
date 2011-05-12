<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Constants.php';
require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Email/Interface.php';
require_once realpath(__DIR__) . '/../UserMock.php';

class SE_Auth_Adapter_Doctrine_Model_Method_EmailMock implements SE_Auth_Adapter_Doctrine_Model_Method_Email_Interface {

    public $email;
    public $password;
    public $status;
    public $user;

    public function  __construct($status = SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_ACTIVE) {
        $this->email = 'example@example.com';
        $this->password = md5('example password');
        $this->status = $status;
        $this->user = new SE_Auth_Adapter_Doctrine_Model_UserMock(1);
    }

    public function fetchEmail() {
        return $this->email;
    }

    public function fetchPassword() {
        return $this->password;
    }

    public function fetchStatus() {
        return $status;
    }

    public function fetchName() {
        return 'Email';
    }

    public function fetchSlug() {
        return 'email';
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

    public function fetchUser($email = '', $password = '') {
        if ($email == $this->email) {
            if (md5($password) == $this->password) {
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

}