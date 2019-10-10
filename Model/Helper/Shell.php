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

    public static function dirFilesList($dir)
    {
        $dir = dir($dir);

        $files = [];
        while ($file = $dir->read()) {
            $files[] = $file;
        }
        $dir->close();

        return $files;
    }

    public static function inStr($in, $string)
    {
        if(strpos($string, $in) !== false)
            return true;

        return false;
    }

    public static function findStoreDumpFile($files, $store)
    {
        foreach ($files as $file) {
            if(strpos($file, $store) !== false)
                return $file;
        }

        return false;
    }

    public static function getLabDump($storeName = null)
    {
        $dumps = self::dirFilesList('/home/rodolfo/dev/dbs');
        $file = self::findStoreDumpFile($dumps, $storeName);
        $sqlFile = self::makeSqlStoreFile($file);
        return $sqlFile;
    }

    public static function makeSqlStoreFile($file){
        if (self::inStr('.gz', $file)) {
            $arr = explode('_', $file)[0];
            self::shellExec("mv /home/rodolfo/dev/dbs/$file $arr.sql.gz");
            echo "gunzip /home/rodolfo/dev/dbs/$arr";exit;
            // self::shellExec("gunzip /home/rodolfo/dev/dbs/$arr.sql.gz");
            return "$arr.sql";
        }
        return "$file.sql";
    }
}