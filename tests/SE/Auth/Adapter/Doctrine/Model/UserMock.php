<?php

require_once SRC_PATH . '/SE/Auth/Adapter/Doctrine/Model/User/Interface.php';

class SE_Auth_Adapter_Doctrine_Model_UserMock implements SE_Auth_Adapter_Doctrine_Model_User_Interface {

    public $id;

    public function  __construct($id = 1) {
        $this->id = $id;
    }

    public function fetchId() {
        return $this->id;
    }
}