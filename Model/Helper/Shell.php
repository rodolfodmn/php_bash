<?php
class Shell
{
    public static function shellExec($shell = null, $notVoid = false){
        if($notVoid){
            if (isset(explode('\n',json_encode(shell_exec($shell." echo $?")))[1])) {
                $res = explode('\n',json_encode(shell_exec($shell." echo $?")))[1]; 
            }
            return ($res) ? $res : '' ;
        }

        return shell_exec($shell);   
    }

    public static function shellSql($params, $db, $notVoid = false){
        return self::shellExec(
            "mysql -u root -proot -e \"use $db; $params\";",
            $notVoid
        );
    }
}