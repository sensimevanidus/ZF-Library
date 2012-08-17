<?php

require_once 'Zend/Auth/Adapter/Interface.php';

// Twitter PHP-SDK library source file shall be found on your include path
#require_once 'twitter.php';

class SE_Auth_Adapter_Doctrine_Twitter implements Zend_Auth_Adapter_Interface {

    protected $_twitterId;
    protected $_accessToken;
    protected $_accessTokenSecret;

    /**
     * Corresponding user
     * @var SE_Auth_Adapter_Doctrine_Model_User_Interface
     */
    protected $_user;

    /**
     * @var SE_Auth_Adapter_Doctrine_Model_Method_Twitter_Interface
     */
    protected $_twitterModel;

    public function __construct($twitterId, $accessToken, $accessTokenSecret, SE_Auth_Adapter_Doctrine_Model_Method_Twitter_Interface $twitterModel) {
        $this->_twitterId = $twitterId;
        $this->_accessToken = $accessToken;
        $this->_accessTokenSecret = $accessTokenSecret;
        $this->_twitterModel = $twitterModel;
    }

    /**
     * Tries to authenticate the user using the Twitter session and the
     * corresponding secret.
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        try {
            $this->_user = $this->_twitterModel->fetchUser($this->_twitterId);
            $code = Zend_Auth_Result::SUCCESS;
            $message = $this->_twitterModel->fetchMessage(
                Zend_Auth_Result::SUCCESS
            );
        } catch (Exception $ex) {
            $code = $ex->getCode();
            $message = $this->_twitterModel->fetchMessage($ex->getCode());
        }
        return new Zend_Auth_Result($code, $this->_user, array($message));
    }
}
