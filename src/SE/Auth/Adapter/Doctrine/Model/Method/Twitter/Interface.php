<?php

require_once realpath(__DIR__) . '/../Interface.php';

/**
 * Generic interface for the Twitter authentication model.
 * @author Onur Yaman <onuryaman@gmail.com>
 */
interface SE_Auth_Adapter_Doctrine_Model_Method_Twitter_Interface extends SE_Auth_Adapter_Doctrine_Model_Method_Interface {
    /**
     * @return int
     */
    public function fetchTwitterId();

    /**
     * @return string
     */
    public function fetchAccessToken();

    /**
     * @return string
     */
    public function fetchAccessTokenSecret();

    /**
     * @return SE_Auth_Adapter_Doctrine_Model_User_Interface
     * @throws Exception
     */
    public function fetchUser($twitterId = '');
}
