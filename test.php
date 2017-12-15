<?php
 $flag = $_POST['flag'];
  if($flag == 'V'){
  	$callback=array(
    'status'=>0,
    'msg'=>'username can not match the password,please retype your password and username'
	);
	$check_login = true;//boolean,check whether username matches the password or not
  	if($check_login){
    	$callback=array(
        	'status'=>1);
  }
 }
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
	'cid' => 'comp3006',
	'cname' => 'SOFTWARE',
	),
	2 => array(
	'did' => 'comp3005001',
	'dname' => 'phase2',
	'cid' => 'comp3005',
	'cname' => 'ALGORITHM',
	),
	);
 }
 elseif($flag == 'R'){
 	$upload_dir = $_SERVER['DOCUMENT_ROOT']."/";
	$aid = $_POST['did'];
	$sid = $_POST['sid'];
	if ($aid == 'comp3005001') {
	$callback = array(
	'status' => true,
	'1' => array(
	'did' => 'comp3005001',
	'dname' => 'phase2',
	'cid' => 'comp3005',
	'cname' => 'ALGORITHM',
	'score' => 18,
	'min' => 15,
	'max' => 16,
	'mean' =>20,
	'dueDate' => 1211,
	'time' => 12,
	'url' => 'scraperForTB.py'
	)
	);}
	else {
	$callback = array(
	'status' => true,
	'1' => array(
	'did' => 'comp3006001',
	'dname' => 'phase1',
	'cid' => 'comp3006',
	'cname' => 'SOFTWARE',
	'score' => 0,
	'min' => 22,
	'max' => 16,
	'mean' =>20,
	'dueDate' => 10,
	'time' => 12,
	'url' => ''
	)
	);
	}
 }
 elseif(!isset($flag)){
 	$callback = array('status' => false);
	$did = $_POST["did"];
	$upload_dir = $_SERVER['DOCUMENT_ROOT']."/";
	
	$moved = move_uploaded_file($_FILES["submissionUpload"]["tmp_name"], $upload_dir.$_FILES["submissionUpload"]["name"]);
	//check whether the file name is same; if not same, delete previous one;
	if($moved) {
		$callback = array('status' => true);
	}
 }
echo json_encode($callback);
?>