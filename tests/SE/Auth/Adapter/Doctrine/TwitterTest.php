<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Constants.php';
require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Twitter.php';
require_once 'Model/Method/TwitterMock.php';

class SE_Auth_Adapter_Doctrine_TwitterTest extends LibraryClassTest {

    public function testShouldAuthenticate() {
        $doctrineTwitterAdapter = new SE_Auth_Adapter_Doctrine_Twitter(
            'twitter user id',
            'twitter access token',
            'twitter access token secret',
            new SE_Auth_Adapter_Doctrine_Model_Method_TwitterMock()
        );

        $authResult = $doctrineTwitterAdapter->authenticate();

        $this->assertTrue($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::SUCCESS, $authResult->getCode());
        $this->assertNotNull($authResult->getIdentity());
        $this->assertEquals(1, $authResult->getIdentity()->fetchId());
    }

    public function testShouldNotAuthenticateDueToNonExistingAccount() {
        $doctrineTwitterAdapter = new SE_Auth_Adapter_Doctrine_Twitter(
            'twitter missing user id',
            'twitter access token',
            'twitter access token secret',
            new SE_Auth_Adapter_Doctrine_Model_Method_TwitterMock()
        );

        $authResult = $doctrineTwitterAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::CREDENTIAL_INVALID, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

    public function testShouldNotAuthenticateDueToInactiveAccount() {
        $doctrineTwitterAdapter = new SE_Auth_Adapter_Doctrine_Twitter(
            'twitter user id',
            'twitter access token',
            'twitter access token secret',
            new SE_Auth_Adapter_Doctrine_Model_Method_TwitterMock(
                SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_INACTIVE
            )
        );

        $authResult = $doctrineTwitterAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

}
