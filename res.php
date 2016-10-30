
				<?php
					foreach ($rows as $row) {
				?> 
					<tr>
				<?php
						$id = 0;
						$isDone = false;
						foreach ($row as $key => $value) {
							if ($key === 'id') {
								$id = $value;
							}
							if ($key === 'description') {
				?>
					<td class="td-title"><?=$value;?></td>
				<?php
							}elseif ($key === 'is_done') {
								if($value === '0'){
				?>
					<td>в процессе</td>
				<?php 
								}else{
									$isDone = true;
				?>
					<td>готово</td>
				<?php 
								}
							}else{
				?>

					<td class="t-center"><?=$value;?></td>
				<?php
							}				
						}
				?>
					<td>
				<?php
					if (!$isDone) {
				?>
						<a href="todo.php?id=<?=$id;?>&step=edit">
							<img src="img/edit.png" class="action">
						</a>
						<a href="todo.php?id=<?=$id;?>&step=done">
							<img  class="action" src="img/done.png">
						</a>
				<?php
					}
				?>
						<a href="todo.php?id=<?=$id;?>&step=delete">
							<img  class="action" src="img/del.png">
						</a>
					</td>
				</tr>
				<?php				
					}
				?>


Array
(
    [chbx] => name
    [table_name] => books
    [action] => edit
)

Array
(
    [select_tables] => tasks
    [select_tbls] => 
)

Array
(
    [table_name] => users
    [Field] => login
    [Type] => varchar
    [Count] => 120
    [Null] => NO
    [Key] => 
    [Default] => login
    [Extra] => 
    [update] => update
)
Array
(
    [chbx] => Столбец 2
    [table_name] => test
    [action] => delete
)

not null
Array
(
    [table_name] => test
    [Field] => col_2
    [Field_type] => TINYINT
    [Count] => 5
    [Default] => 
    [add] => add
)

if null checked
Array
(
    [table_name] => test
    [Field] => col_2
    [Field_type] => LONGTEXT
    [Count] => 
    [chbx] => NULL
    [Default] => 
    [add] => add
)

Array
(
    [name_table] => test
    [add_new_table] => 
)