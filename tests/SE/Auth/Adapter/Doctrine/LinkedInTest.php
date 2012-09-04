<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/Method/Constants.php';
require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/LinkedIn.php';
require_once 'Model/Method/LinkedInMock.php';

class SE_Auth_Adapter_Doctrine_LinkedInTest extends LibraryClassTest {

    public function testShouldAuthenticate() {
        $doctrineLinkedInAdapter = new SE_Auth_Adapter_Doctrine_LinkedIn(
            'linkedin user id',
            'linkedin access token',
            'linkedin access token secret',
            new SE_Auth_Adapter_Doctrine_Model_Method_LinkedInMock()
        );

        $authResult = $doctrineLinkedInAdapter->authenticate();

        $this->assertTrue($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::SUCCESS, $authResult->getCode());
        $this->assertNotNull($authResult->getIdentity());
        $this->assertEquals(1, $authResult->getIdentity()->fetchId());
    }

    public function testShouldNotAuthenticateDueToNonExistingAccount() {
        $doctrineLinkedInAdapter = new SE_Auth_Adapter_Doctrine_LinkedIn(
            'linkedin missing user id',
            'linkedin access token',
            'linkedin access token secret',
            new SE_Auth_Adapter_Doctrine_Model_Method_LinkedInMock()
        );

        $authResult = $doctrineLinkedInAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::CREDENTIAL_INVALID, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

    public function testShouldNotAuthenticateDueToInactiveAccount() {
        $doctrineLinkedInAdapter = new SE_Auth_Adapter_Doctrine_LinkedIn(
            'linkedin user id',
            'linkedin access token',
            'linkedin access token secret',
            new SE_Auth_Adapter_Doctrine_Model_Method_LinkedInMock(
                SE_Auth_Adapter_Doctrine_Model_Method_Constants::STATUS_INACTIVE
            )
        );

        $authResult = $doctrineLinkedInAdapter->authenticate();

        $this->assertFalse($authResult->isValid());
        $this->assertEquals(SE_Auth_Adapter_Doctrine_Model_Method_Constants::INACTIVE, $authResult->getCode());
        $this->assertNull($authResult->getIdentity());
    }

}
