<?php 
$content = (string)$this->obj->Content;
$data = include 'Zhaxin.php';
// 循环语言包
foreach ($data as $k => $v) {
	if ($content == $k) {
		return $v;
	}
}
// 都不匹配，返回嗯嗯
return '嗯嗯';