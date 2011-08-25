<?php

class SE_Controller_Helper_EmailAuthentication extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($email, $password) {
        // check whether the email and password matches
        $doctrineEmailAdapter = new SE_Auth_Adapter_Doctrine_Email(
            $email, $password, new EmailAuth()
        );

        // try to authenticate the user
        $authResult = Zend_Auth::getInstance()->authenticate($doctrineEmailAdapter);

        return SE_Auth_Adapter_Doctrine_Model_Method_Constants::SUCCESS == $authResult->getCode();
    }

    /**
     * @todo Exception handling and correct error messages
     * Given the name, email and password values, tries to register a new user.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function register($name, $email, $password) {
        return EmailAuth::registerUser($name, $email, md5($password));
    }
}