<?php
   
   $flag = $_POST['flag'];
elseif($flag == 'R'){
	$psw = $_POST['did'];
	$callback = array(
	'status' => true,
	'1' => array(
	'did' => 'comp3005001',
	'dname' => 'phase2',
	'cid' => 'comp3005',
	'cname' => 'ALGORITHM',
	'score' => 14,
	'dueDate' => 12,
	'time' => 12,
	'url' => null
	)
	);
}

echo json_encode($callback);
?>