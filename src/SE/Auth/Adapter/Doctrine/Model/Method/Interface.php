<?php

/**
 * Generic interface for the authentication method model.
 * @author Onur Yaman <onuryaman@gmail.com>
 */
interface SE_Auth_Adapter_Doctrine_Model_Method_Interface {
    /**
     * @return string
     */
    public function fetchSlug();

    /**
     * @return string
     */
    public function fetchName();

    /**
     * @return string
     */
    public function fetchStatus();

    /**
     * @return string
     */
    public function fetchMessage($errorCode);
}