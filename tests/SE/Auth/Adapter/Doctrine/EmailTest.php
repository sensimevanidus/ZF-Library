<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Constants.php';
require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Email.php';
require_once 'Model/Method/EmailMock.php';

class SE_Auth_Adapter_Doctrine_EmailTest extends LibraryClassTest {

    public function testShouldAuthenticate() {
        $doctrineEmailAdapter = new SE_Auth_Adapter_Doctrine_Email(
            'example@example.com',
            'example password',
            new SE_Auth_Adapter_Doctrine_Model_Method_EmailMock()
        );

        $authResult = $doctrineEmailAdapter->authenticate();

        $this->assertTrue($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::SUCCESS, $authResult->getCode());
        $this->assertNotNull($authResult->getIdentity());
        $this->assertEquals(1, $authResult->getIdentity()->fetchId());
    }

    public function testShouldNotAuthenticateDueToWrongPassword() {
        $doctrineEmailAdapter = new SE_Auth_Adapter_Doctrine_Email(
            'example@example.com',
            'example password1',
            new SE_Auth_Adapter_Doctrine_Model_Method_EmailMock()
        );

        $authResult = $doctrineEmailAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::WRONG_PASSWORD, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

    public function testShouldNotAuthenticateDueToNonExistingAccount() {
        $doctrineEmailAdapter = new SE_Auth_Adapter_Doctrine_Email(
            'example1@example.com',
            'example password',
            new SE_Auth_Adapter_Doctrine_Model_Method_EmailMock()
        );

        $authResult = $doctrineEmailAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::NOT_FOUND, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

    public function testShouldNotAuthenticateDueToInactiveAccount() {
        $doctrineEmailAdapter = new SE_Auth_Adapter_Doctrine_Email(
            'example@example.com',
            'example password',
            new SE_Auth_Adapter_Doctrine_Model_Method_EmailMock(
                SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_INACTIVE
            )
        );

        $authResult = $doctrineEmailAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

}