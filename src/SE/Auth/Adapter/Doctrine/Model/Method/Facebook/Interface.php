<?php

require_once realpath(__DIR__) . '/../Interface.php';

/**
 * Generic interface for the Facebook authentication model.
 * @author Onur Yaman <onuryaman@gmail.com>
 */
interface SE_Auth_Adapter_Doctrine_Model_Method_Facebook_Interface extends SE_Auth_Adapter_Doctrine_Model_Method_Interface {
    /**
     * @return int
     */
    public function fetchFacebookId();

    /**
     * @return string
     */
    public function fetchAccessToken();

    /**
     * Facebook access tokens differ from each other in that they can be used
     * on different places (e.g. User's own wall, Administered page's wall)
     * @return string
     */
    public function fetchAccessTokenScope();

    /**
     * @return SE_Auth_Adapter_Doctrine_Model_User_Interface
     * @throws Exception
     */
    public function fetchUser($facebookId = '');
}