<?php

require_once 'Zend/Auth/Adapter/Interface.php';

// Facebook PHP-SDK library source file shall be found on your include path
require_once 'facebook.php';

class SE_Auth_Adapter_Doctrine_Facebook implements Zend_Auth_Adapter_Interface {

    protected $_facebookId;
    protected $_accessToken;
    protected $_accessTokenScope;

    /**
     * Corresponding user
     * @var SE_Auth_Adapter_Doctrine_Model_User_Interface
     */
    protected $_user;

    /**
     * @var SE_Auth_Adapter_Doctrine_Model_Method_Facebook_Interface
     */
    protected $_facebookModel;

    public function __construct($facebookId = null, $accessToken = null, $accessTokenScope = null, SE_Auth_Adapter_Doctrine_Model_Method_Facebook_Interface $facebookModel) {
        if (null === $facebookId) {
            $fb = new Facebook();
            $this->_facebookId = $facebookId;
            $this->_accessToken = $accessToken;
            $this->_accessTokenScope = $accessTokenScope;
        } else {
            $this->_facebookId = $facebookId;
            $this->_accessToken = $accessToken;
            $this->_accessTokenScope = $accessTokenScope;
        }
        $this->_facebookModel = $facebookModel;
    }

    /**
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        try {
            $this->_user = $this->_facebookModel->fetchUser($this->_facebookId);
            $code = Zend_Auth_Result::SUCCESS;
            $message = $this->_facebookModel->fetchMessage(
                Zend_Auth_Result::SUCCESS
            );
        } catch (Exception $ex) {
            $code = $ex->getCode();
            $message = $this->_facebookModel->fetchMessage($ex->getCode());
        }
        return new Zend_Auth_Result($code, $this->_user, array($message));
    }
}
