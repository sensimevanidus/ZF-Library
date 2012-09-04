<?php

require_once 'Zend/Auth/Adapter/Interface.php';

class SE_Auth_Adapter_Doctrine_LinkedIn implements Zend_Auth_Adapter_Interface {

    protected $_linkedInId;
    protected $_accessToken;
    protected $_accessTokenSecret;

    /**
     * Corresponding user
     * @var SE_Auth_Adapter_Doctrine_Model_User_Interface
     */
    protected $_user;

    /**
     * @var SE_Auth_Adapter_Doctrine_Model_Method_LinkedIn_Interface
     */
    protected $_linkedInModel;

    public function __construct($linkedInId, $accessToken, $accessTokenSecret, SE_Auth_Adapter_Doctrine_Model_Method_LinkedIn_Interface $linkedInModel) {
        $this->_linkedInId = $linkedInId;
        $this->_accessToken = $accessToken;
        $this->_accessTokenSecret = $accessTokenSecret;
        $this->_linkedInModel = $linkedInModel;
    }

    /**
     * Tries to authenticate the user using the LinkedIn session and the
     * corresponding secret.
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        try {
            $this->_user = $this->_linkedInModel->fetchUser($this->_linkedInId);
            $code = Zend_Auth_Result::SUCCESS;
            $message = $this->_linkedInModel->fetchMessage(
                Zend_Auth_Result::SUCCESS
            );
        } catch (Exception $ex) {
            $code = $ex->getCode();
            $message = $this->_linkedInModel->fetchMessage($ex->getCode());
        }
        return new Zend_Auth_Result($code, $this->_user, array($message));
    }
}
