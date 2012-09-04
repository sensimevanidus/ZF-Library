<?php

require_once realpath(__DIR__) . '/../Interface.php';

/**
 * Generic interface for the LinkedIn authentication model.
 * @author Onur Yaman <onuryaman@gmail.com>
 */
interface SE_Auth_Adapter_Doctrine_Model_Method_LinkedIn_Interface extends SE_Auth_Adapter_Doctrine_Model_Method_Interface {
    /**
     * @return int
     */
    public function fetchLinkedInId();

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
    public function fetchUser($linkedInId = '');
}
