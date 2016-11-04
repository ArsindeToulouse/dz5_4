<?php

/**
* 
*/
class DB{
	public static function getTablesList($pdo){
	    $stmt = $pdo->prepare("SHOW TABLES");
	    $stmt->execute();
	    return $stmt->fetchAll();
	}
	public static function getTableDescription($pdo, $tableName){
	    $stmt = $pdo->prepare("DESCRIBE {$tableName}");
	    $stmt->execute();
	    return $stmt->fetchAll();
	}
	public static function getTypeInfo($type){
	    //preg_match('/\(([^()]*)\)/', $type, $m);  //  /\((.+)\)/ - до скобок
	    preg_match('/([^\)]+)\((.*)\)/', $type, $m);
	    return (!empty($m)) ? $m : array(1=>$type, 2=>'');
	}
	public static function deleteColumn($pdo, $tableName, $columnName){
	    $stmt = $pdo->prepare("ALTER TABLE {$tableName} DROP COLUMN `{$columnName}`");
	    $stmt->execute();
	    return true;
	}
	public static function addColumn($pdo, $columns){
	    $tableName = $columns['table_name'];
	    $field = $columns['Field'];
	    if (!empty($columns['Count'])) {
	        $type = "{$columns['Field_type']}({$columns['Count']})";
	    }else{
	        $type = $columns['Field_type'];
	    }
	    if (isset($columns['chbx'])) {
	        if ($columns['chbx'] === 'NULL') {
	            $nl = 'NULL';
	        }
	    }else{
	        $nl = 'NOT NULL';
	    }
	    if (!empty($columns['Default'])) {
	        $default = $columns['Default'];
	    }else{
	        $default = '';
	    }

	    $sql = "ALTER TABLE {$tableName} ADD COLUMN `{$field}` {$type} {$nl} {$default}";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    return true;
	}
	public static function updateColumn($pdo, $columns){
	    $tableName = $columns['table_name'];
		$sql = "ALTER TABLE {$tableName} ";

		if ($columns['prev_column_name'] === $columns['Field']) {
			$sql .= "MODIFY {$columns['Field']}";
		}else{
			$sql .= "CHANGE {$columns['prev_column_name']} {$columns['Field']}";
		}

		switch ($columns['Field_type']) {
			case 'VARCHAR':
				$sql .= (!empty($columns['Count']))?" {$columns['Field_type']}({$columns['Count']})":" {$columns['Field_type']}(255)";
				break;
			case 'CHAR':
				$sql .= (!empty($columns['Count']))?" {$columns['Field_type']}({$columns['Count']})":" {$columns['Field_type']}(10)";
				break;
			default:
				$sql .= " {$columns['Field_type']}";
				break;
		}

		if (isset($columns['chbx'])) {
	        if ($columns['chbx'] === 'NULL') {
	            $sql .= " NULL";
	        }
	    }else{
	        $sql .= " NOT NULL";
	    }

	    if (!empty($columns['Default'])) {
	        $sql .= " {$columns['Default']}";
	    }

	    $stmt = $pdo->prepare($sql);
	    if(!$stmt->execute()){
	    	throw new Exception("Ошибка в определении полей колонки. ");
	    }
	    return true;
	}
	public static function addTable($pdo, $tableName){
	    $sql = "CREATE TABLE IF NOT EXISTS {$tableName} (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE=InnoDB, COLLATE='utf8_general_ci'";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    return true;
	}
	public static function deleteTable($pdo, $tableName){
	    $sql = "DROP TABLE {$tableName}";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute();
	    return true;
	}
}