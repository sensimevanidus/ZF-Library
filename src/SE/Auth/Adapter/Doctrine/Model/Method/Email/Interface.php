<?php

require_once realpath(__DIR__) . '/../Interface.php';

/**
 * Generic interface for the e-mail authentication model.
 * @author Onur Yaman <onuryaman@gmail.com>
 */
interface SE_Auth_Adapter_Doctrine_Model_Method_Email_Interface extends SE_Auth_Adapter_Doctrine_Model_Method_Interface {
    /**
     * @return string
     */
    public function fetchEmail();

    /**
     * @return string
     */
    public function fetchPassword();

    /**
     * @return SE_Auth_Adapter_Doctrine_Model_User_Interface
     * @throws Exception
     */
    public function fetchUser($email = '', $password = '');
}