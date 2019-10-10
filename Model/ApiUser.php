<?php

include 'Helper/Shell.php';

class ApiUser {

    public $userId;    
    public $levelId;    
    public $ruleId;

    public $storeDb;

    public function __construct($storeDb = null) {
        $this->storeDb = $storeDb;
        
        $this->createUser();
        $this->createLevel();
        $this->createRule();
    }
    
    public function setUsetId($userId){
        $this->userId = $userId;
    }

    public function setLevelId($levelId){
        $this->levelId = $levelId;
    }
   
    public function setRuleId($ruleId){
        $this->ruleId = $ruleId;
    }

    public function getUsetId(){
        $res = Shell::shellSql("SELECT user_id FROM api_user WHERE email = 'back@bis2bis.com.br';", $this->storeDb, true);
        $this->setUsetId($res);

        return $res;
    }

    public function getGLevelId(){
        return Shell::shellSql("SELECT role_id FROM api_role WHERE role_name = 'adminApi'", $this->storeDb, true);        
    }

    public function getLevelId(){
        $res = Shell::shellSql("SELECT role_id FROM api_role WHERE role_name = ".$this->getUsetId(), $this->storeDb, true);        
        $this->setLevelId($res);

        return $res;
    }

    public function getRuleId(){
        $res = Shell::shellSql("SELECT rule_id FROM api_rule WHERE role_id = ".$this->getLevelId(), $this->storeDb, true);
        $this->setLevelId($res);

        return $res;        
    }

    public function createUser(){
        Shell::shellSql("INSERT INTO api_user (firstname, lastname, email, username, api_key, created, modified, lognum, reload_acl_flag, is_active) VALUES ('Suporte', 'BisTwoBis', 'back@bis2bis.com.br', 'admin', md5('igorigor'), '0000-00-00 00:00:00', NULL, '0', '0', '1')", $this->storeDb);
    }

    public function createLevel(){
        Shell::shellSql("INSERT INTO api_role (parent_id, tree_level, sort_order, role_type, user_id, role_name) VALUES ('0', '1', '0', 'G', '0', 'adminApi')", $this->storeDb);
        //level U.
        Shell::shellSql("INSERT INTO api_role (parent_id, tree_level, sort_order, role_type, user_id, role_name) VALUES ('".$this->getGLevelId()."', '1', '0', 'U', '".$this->getUsetId()."', 'Suporte')", $this->storeDb);
    }

    public function createRule(){
        return Shell::shellSql("INSERT INTO api_rule (role_id, resource_id, privileges, assert_id, role_type, permission)
        VALUES ('".$this->getGLevelId()."', 'all', '', '0', 'G', 'allow')", $this->storeDb);
    }
}
