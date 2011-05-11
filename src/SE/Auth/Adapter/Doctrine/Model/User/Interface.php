<?php

/**
 * Generic interface for the user model.
 * @author Onur Yaman <onuryaman@gmail.com>
 */
interface SE_Auth_Adapter_Doctrine_Model_User_Interface {
    /**
     * @return int
     */
    public function fetchId();
}