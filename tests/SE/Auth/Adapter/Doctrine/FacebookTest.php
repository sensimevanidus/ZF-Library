<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Constants.php';
require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Facebook.php';
require_once 'Model/Method/FacebookMock.php';

class SE_Auth_Adapter_Doctrine_FacebookTest extends LibraryClassTest {

    public function testShouldAuthenticate() {
        $doctrineFacebookAdapter = new SE_Auth_Adapter_Doctrine_Facebook(
            'facebook user id',
            'facebook access token',
            'facebook access token scope',
            new SE_Auth_Adapter_Doctrine_Model_Method_FacebookMock()
        );

        $authResult = $doctrineFacebookAdapter->authenticate();

        $this->assertTrue($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::SUCCESS, $authResult->getCode());
        $this->assertNotNull($authResult->getIdentity());
        $this->assertEquals(1, $authResult->getIdentity()->fetchId());
    }

    public function testShouldNotAuthenticateDueToWrongAccessToken() {
        $doctrineFacebookAdapter = new SE_Auth_Adapter_Doctrine_Facebook(
            'facebook user id',
            'facebook wrong access token',
            'facebook access token scope',
            new SE_Auth_Adapter_Doctrine_Model_Method_FacebookMock()
        );

        $authResult = $doctrineFacebookAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::IDENTITY_NOT_FOUND, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

    public function testShouldNotAuthenticateDueToNonExistingAccount() {
        $doctrineFacebookAdapter = new SE_Auth_Adapter_Doctrine_Facebook(
            'facebook missing user id',
            'facebook access token',
            'facebook access token scope',
            new SE_Auth_Adapter_Doctrine_Model_Method_FacebookMock()
        );

        $authResult = $doctrineFacebookAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::CREDENTIAL_INVALID, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

    public function testShouldNotAuthenticateDueToInactiveAccount() {
        $doctrineFacebookAdapter = new SE_Auth_Adapter_Doctrine_Facebook(
            'facebook user id',
            'facebook access token',
            'facebook access token scope',
            new SE_Auth_Adapter_Doctrine_Model_Method_FacebookMock(
                SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_INACTIVE
            )
        );

        $authResult = $doctrineFacebookAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

}