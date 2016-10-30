<?php
session_start();
header ("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL);

define('DSN', 'mysql:host=localhost;dbname=global;charset=utf8');
define('USER', 'mysql');
define('PASS', 'mysql');

function getLink(){
	$opt = array(
	    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	$pdo = new PDO(DSN, USER, PASS, $opt);
	return $pdo;
}
function getTablesList(){
    $pdo = getLink();
    $stmt = $pdo->prepare("SHOW TABLES");
    $stmt->execute();
    return $stmt->fetchAll();
}
function getTableDescription($str){
    $pdo = getLink();
    $stmt = $pdo->prepare("DESCRIBE {$str}");
    $stmt->execute();
    return $stmt->fetchAll();
}
function getTypeInfo($type){
    //preg_match('/\(([^()]*)\)/', $type, $m);  //  /\((.+)\)/ - до скобок
    preg_match('/([^\)]+)\((.*)\)/', $type, $m);
    return $m;
}
function deleteColumn($tbl, $name){
    $pdo = getLink();
    $stmt = $pdo->prepare("ALTER TABLE {$tbl} DROP COLUMN `{$name}`");
    $stmt->execute();
    return true;
}
function addColumn($arr){
    $table_name = $arr['table_name'];
    $field = $arr['Field'];
    if (!empty($arr['Count'])) {
        $type = "{$arr['Field_type']}({$arr['Count']})";
    }else{
        $type = $arr['Field_type'];
    }
    if (isset($arr['chbx'])) {
        if ($arr['chbx'] === 'NULL') {
            $nl = 'NULL';
        }
    }else{
        $nl = 'NOT NULL';
    }
    if (!empty($arr['Default'])) {
        $dflt = $arr['Default'];
    }else{
        $dflt = '';
    }
    $pdo = getLink();
    $sql = "ALTER TABLE {$table_name} ADD COLUMN `{$field}` {$type} {$nl} {$dflt}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return true;
}
function addTable($name){
    $pdo = getLink();
    $sql = "CREATE TABLE IF NOT EXISTS {$name} (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE=InnoDB, COLLATE='utf8_general_ci'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return true;
}
function deleteTable($name){
    $pdo = getLink();
    $sql = "DROP TABLE {$name}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return true;
}