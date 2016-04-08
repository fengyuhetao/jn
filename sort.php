<?php
/**
 * 二维数组排序练习
 * @var array
 */
$arr = array(
	array('name' => 'hetao', 'age' => 32),
	array('name' => 'hetao1', 'age' => 33),
	array('name' => 'hetao2', 'age' => 31),
	);

usort($arr, 'cmp');
var_dump($arr);

function cmp($a, $b)
{
	if($a['age'] == $b['age']){
		return 0;
	}
	return ($a['age'] > $b['age']) ? -1 : 1;
}

?>