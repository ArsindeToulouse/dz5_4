<?php
require_once "utils.php";

if (isset($_POST)) {
	if (isset($_POST['action']) && $_POST['action'] === 'delete') {
		if(isset($_POST['chbx']) && !empty($_POST['chbx'])){
			$del_column = deleteColumn($_POST['table_name'], $_POST['chbx']);
		}
	}	
	if (isset($_POST['add']) && $_POST['add'] === 'add') {
		$add_column = addColumn($_POST);
	}
	if (isset($_POST['add_new_table'])) {
		$add_table = addTable($_POST['name_table']);
		$table_name = $_POST['name_table'];
	}
	if (isset($_POST['confirm_yes'])) {
		$delete_table = deleteTable($_POST['confirm_yes']);
		if ($delete_table) {
			$success_msg = "Таблица ";
			$rest_msg = " успешно удалена!";
		}
	}
	if(isset($_POST['add_tbl']) || isset($_POST['delete_tbl']) || (isset($_POST['confirm_yes']))){
		if (isset($_POST['delete_tbl'])) {
			echo $_POST['delete_tbl']."<br>";
			$msg = "Вы действительно хотите удалить таблицу ";//{$_POST['select_tables']}?";
		}
	}else{
		if(isset($_POST['select_tables']) && !empty($_POST['select_tables'])){
			$table_name = $_POST['select_tables'];
		}
		if(isset($_POST['table_name']) && !empty($_POST['table_name'])){
			$table_name = $_POST['table_name'];
		}
		if (isset($table_name)) {
			$desc_rows = getTableDescription($table_name);
		}
	}
}
$tables_rows = getTablesList();
/* 
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/

?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Lesson 5.4</title>
	<link rel="stylesheet" href="css/app.css">
</head>
<body>
	<header>
		<hgroup>
			<h1>панель управления таблицами</h1>
		</hgroup>
		<nav>
			<div class="main-menu"></div>
		</nav>
	</header>
	<article class="container-fluid">
		<div class="form">
			<form enctype="multipart/form-data" action="admindb.php" method="POST">
				<div class="search-form-group">
					<label class="select-label">выберите таблицу:</label>
					<select name="select_tables">
					<?php
						foreach ($tables_rows as $table) {
					?>
			            <option value="<?=$table['Tables_in_global']?>"><?=$table['Tables_in_global']?></option>
			        <?php
						}
					?>
			        </select>
        			<button class="select-button" type="submit" name="select_tbls" value=""><img src="img/tick.png"></button>
        			<button class="add-button" type="submit" name="add_tbl" value="">добавить таблицу</button>
        			<button class="delete-button" type="submit" name="delete_tbl" value="">удалить таблицу</button>
				</div>
			</form>
		</div>
	</article>
	<?php
		if (isset($msg)) {
	?>
	<article class="container-fluid">
		<div class="form">
			<form enctype="multipart/form-data" action="admindb.php" method="POST">
				<div style="border: 1px solid red; padding: 10px; border-radius: 3px; width: 620px;">
					<label style="color: red"><?=$msg;?><strong><?=$_POST['select_tables'];?></strong>?</label>
					<button class="confirm-button" type="submit" name="confirm_yes" value="<?=$_POST['select_tables'];?>">да</button>
					<button class="confirm-button" type="submit" name="confirm_no" value="">отменить</button>
				</div>
			</form>
		</div>
	</article>
	<?php
		}
		if (isset($success_msg)) {
	?>
	<article class="container-fluid">
		<div class="form">
			<div style="border: 1px solid green; padding: 10px; border-radius: 3px; width: 620px;">
				<p style="font-family: Raleway, Arial, sans-serif; font-weight: 500; font-style: normal; font-size: .97em; padding: 3px 30px; color: green;"><?=$success_msg;?><strong><?=$_POST['confirm_yes'];?></strong><?=$rest_msg;?></p>
			</div>
		</div>
	</article>
	<?php
		}
		if(isset($_POST['add_tbl'])){
	?>
	<article class="container-fluid">
		<div class="form">
			<form enctype="multipart/form-data" action="admindb.php" method="POST">
				<div class="search-form-group">
					<label class="select-label">название таблицу:</label>
					<input type="text" name="name_table" value="" placeholder="название">
        			<button class="select-button" type="submit" name="add_new_table" value=""><img src="img/tick.png"></button>
				</div>
			</form>
	</article>
	<?php
		}
		if(isset($table_name)) {
	?>
	<div class="article-title">
		<h2 class="h2-article">таблица: <?=$table_name;?></h2>
	</div>
	<article class="container-fluid">
		<div class="db">
		<form enctype="multipart/form-data" action="admindb.php" method="post">
			<table class="db-table">
				<tr>
					<th class="th-id"></th>
					<th class="th-title">название поля</th>
					<th class="th-type">тип поля</th>
					<th>NULL</th>
					<th>ключ</th>
					<th>по умолчанию</th>
					<th>extra</th>
					<!--<th class="action-img">действия</th>-->
				</tr>
			<?php
				foreach ($desc_rows as $row) {
			?> 
				<tr>
					<td class="td-id"><input class="chbx" type="checkbox" name="chbx" value="<?=$row['Field'];?>"></td>
					<td class="td-title"><?=$row['Field'];?></td>
					<td><?=$row['Type'];?></td>
					<td class="td-center"><?=$row['Null'];?></td>
					<td class="td-center"><?=$row['Key'];?></td>
					<td class="td-center"><?=$row['Default'];?></td>
					<td class="td-center"><?=$row['Extra'];?></td>
				</tr>
			<?php				
				}
			?>
			</table>
			<div class="table-actions">
				<input type="hidden" name="table_name" value="<?=$table_name;?>">
				<button class="select-button" type="submit" name="action" value="edit"><img src="img/edit.png" title="редактировать"></button>
				<button class="select-button" type="submit" name="action" value="delete"><img src="img/delete.png" title="удалить"></button>
				<button class="select-button" type="submit" name="action" value="insert"><img src="img/insert.png" title="ввод нового поля"></button>
			</div>
		</form>
		</div>
		<?php
			if (isset($_POST['action']) && ($_POST['action'] === 'edit' || $_POST['action'] === 'insert')) {
		?>
		<div class="form">
			<form enctype="multipart/form-data" action="admindb.php" method="POST">
				<div class="search-form-group">
					<input type="hidden" name="table_name" value="<?=$table_name;?>">
			<?php
				if (isset($_POST['chbx']) && !empty($_POST['chbx'])) {
					foreach ($desc_rows as $description) {
						if($description['Field'] === $_POST['chbx']) {
							foreach ($description as $key => $name) {
								if ($key === 'Type') {
									$type_info = getTypeInfo($name);
									if (count($type_info) > 1) {
			?>
					<!--<input type="text" name="<?=$key;?>" value="<?=$type_info[1]?>" placeholder="<?=$key;?>">-->
					<select name="Field_type" class="field-type">
						<option value="<?=$type_info[1]?>"><?=$type_info[1]?></option>
						<option value="TINYINT">TINYINT</option>
						<option value="SMALLINT">SMALLINT</option>
						<option value="MEDIUMINT">MEDIUMINT</option>
						<option value="INT">INT</option>
						<option value="BIGINT">BIGINT</option>
						<option value="FLOAT">FLOAT</option>
						<option value="DOUBLE">DOUBLE</option>
						<option value="DATE">DATE</option>
						<option value="DATETIME">DATETIME</option>
						<option value="TIMESTAMP">TIMESTAMP</option>
						<option value="CHAR">CHAR</option>
						<option value="VARCHAR">VARCHAR</option>
						<option value="TINYTEXT">TINYTEXT</option>
						<option value="TEXT">TEXT</option>
						<option value="MEDIUMTEXT">MEDIUMTEXT</option>
						<option value="LONGTEXT">LONGTEXT</option>
						<option value="BLOB">BLOB</option>
					</select>
					<input type="text" name="Count" value="<?=$type_info[2]?>" placeholder="Count">
			<?php
									}else{
			?>
					<input type="text" name="<?=$key;?>" value="<?=$name;?>" placeholder="<?=$key;?>">
					<input type="text" name="Count" value="" placeholder="Count">
			<?php
									}
								}else{
									if ($key === 'Key' || $key === 'Extra') {
			?>
					<!--<input type="text" name="<?=$key;?>" value="<?=$name?>" placeholder="<?=$key;?>">-->
			<?php
									}else{
			?> 
					<input type="text" name="<?=$key;?>" value="<?=$name?>" placeholder="<?=$key;?>">
			<?php
									}
								}
							}
						}
					}
			?>
        			<button class="select-button" type="submit" name="update" value="update"><img src="img/tick.png"></button>
        	<?php
				}else{
			?>
					<input type="text" name="Field" value="" placeholder="Field">
					<select name="Field_type" class="field-type">
						<option value="TINYINT">TINYINT</option>
						<option value="SMALLINT">SMALLINT</option>
						<option value="MEDIUMINT">MEDIUMINT</option>
						<option value="INT">INT</option>
						<option value="BIGINT">BIGINT</option>
						<option value="FLOAT">FLOAT</option>
						<option value="DOUBLE">DOUBLE</option>
						<option value="DATE">DATE</option>
						<option value="DATETIME">DATETIME</option>
						<option value="TIMESTAMP">TIMESTAMP</option>
						<option value="CHAR">CHAR</option>
						<option value="VARCHAR">VARCHAR</option>
						<option value="TINYTEXT">TINYTEXT</option>
						<option value="TEXT">TEXT</option>
						<option value="MEDIUMTEXT">MEDIUMTEXT</option>
						<option value="LONGTEXT">LONGTEXT</option>
						<option value="BLOB">BLOB</option>
					</select>
					<input type="text" name="Count" value="" placeholder="Count">
					<input class="chbx" type="checkbox" name="chbx" value="NULL"></td>
					<!--<input type="text" name="Null" value="" placeholder="Null">
					<input type="text" name="Key" value="" placeholder="Key">-->
					<input type="text" name="Default" value="" placeholder="Default">
					<!--<input type="text" name="Extra" value="" placeholder="Extra">-->
					<button class="select-button" type="submit" name="add" value="add"><img src="img/tick.png"></button>
			<?php
				}
			?>
				</div>
			</form>
		</div>
		<?php
			}
		?>
	</article>
	<?php
		}
	?>
	<footer>
		<div class="end-phrase">"Вологодские леса" @ 2016</div>
	</footer>
</body>
</html>