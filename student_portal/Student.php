<?php
   
  
elseif($flag == 'C'){
	$psw = $_POST['sid'];
	$callback = array(
	'status' => true,
	1 => array(
	'cid' => 'comp3006',
	'cname' => 'SOFTWARE'
	),
	2 => array(
	'cid' => 'comp3005',
	'cname' => 'ALGORITHM'
	),
	);
}
elseif ($flag == 'S') {
	$psw = $_POST['sid'];
	$callback = array(
	'status' => true,
	1 => array(
	'did' => 'comp3006001',
	'dname' => 'phase1',
	//'cid' => 'comp3006',
	//'cname' => 'SOFTWARE',
	'score' => 12,
	'dueDate' => 123456,
	'time' => 12345,
	'url' => null
	),
	2 => array(
	'did' => 'comp3005001',
	'dname' => 'phase2',
	'cid' => 'comp3005',
	'cname' => 'ALGORITHM',
	'score' => 14,
	'dueDate' => 12,
	'time' => 12,
	'url' => null
	),
	);
}

echo json_encode($callback);
?>