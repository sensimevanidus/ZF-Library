<?php

require_once 'Zend/Auth/Adapter/Interface.php';

/**
 * Concrete implementation of the Zend's authentication adapter interface for
 * using Doctrine ORM in order to authenticate using e-mail/password pair.
 * @author Onur Yaman <onuryaman@gmail.com>
 */
class SE_Auth_Adapter_Doctrine_Email implements Zend_Auth_Adapter_Interface {

    /**
     * E-mail address
     * @var string
     */
    protected $_email;

    /**
     * Password for the corresponding e-mail address
     * @var string
     */
    protected $_password;

    /**
     * Corresponding user
     * @var SE_Auth_Adapter_Doctrine_Model_User_Interface
     */
    protected $_user;
    
    /**
     * @var SE_Auth_Adapter_Doctrine_Model_Method_Email_Interface
     */
    protected $_emailModel;

    public function __construct($email, $password, SE_Auth_Adapter_Doctrine_Model_Method_Email_Interface $emailModel) {
        $this->_email = $email;
        $this->_password = $password;
        $this->_emailModel = $emailModel;
    }

    /**
     * Tries to authenticate the user using the email/password pair.
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        try {
            $this->_user = $this->_emailModel->fetchUser($this->_email, $this->_password);
            $code = Zend_Auth_Result::SUCCESS;
            $message = $this->_emailModel->fetchMessage(
                Zend_Auth_Result::SUCCESS
            );
        } catch (Exception $ex) {
            $code = $ex->getCode();
            $message = $this->_emailModel->fetchMessage($ex->getCode());
        }
        return new Zend_Auth_Result($code, $this->_user, array($message));
    }

}