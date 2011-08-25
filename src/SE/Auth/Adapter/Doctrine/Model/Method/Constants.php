<?php

/**
 * Stores constant values to be used by the implementations of the
 * authentication mechanism.
 * @author Onur Yaman <onuryaman@gmail.com>
 */
final class SE_Auth_Adapter_Doctrine_Model_Method_Constants {
    /**
     * Tells that the corresponding credentials were not valid and no user
     * was found.
     * @var int
     */
    const CREDENTIAL_INVALID = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;

    /**
     * Tells that the provided password was wrong.
     * @var int
     */
    const IDENTITY_NOT_FOUND = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;

    /**
     * Tells that the corresponding user is inactive.
     * @var int
     */
    const INACTIVE = Zend_Auth_Result::FAILURE_UNCATEGORIZED;

    /**
     * Tells that an error occured.
     * @var int
     */
    const DEFAULT_ERROR = Zend_Auth_Result::FAILURE;

    /**
     * Tells that the credentials are valid and a user exists.
     * @var int
     */
    const SUCCESS = Zend_Auth_Result::SUCCESS;

    /**
     * Tells that the user is active.
     * @var string
     */
    const STATUS_ACTIVE = 'ACTIVE';

    /**
     * Tells that the user is not active.
     * @var string
     */
    const STATUS_INACTIVE = 'INACTIVE';
}