<?php
header ("Content-Type: text/html; charset=utf-8");
error_reporting(E_ALL);

require_once "ConnectDB.php";
require_once "DB.php";

define('HOST', 'localhost');
define('DB', 'global');
define('USER', 'mysql');
define('PASS', 'mysql');

define('TYPE_FIELD', array("TINYINT", "SMALLINT", "MEDIUMINT", "INT", "BIGINT", "FLOAT", "DOUBLE", "DATE", "DATETIME", "TIMESTAMP", "CHAR", "VARCHAR", "TINYTEXT", "TEXT", "MEDIUMTEXT", "LONGTEXT", "BLOB"));
