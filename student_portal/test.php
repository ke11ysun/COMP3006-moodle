<?php

$host = "localhost" ;
$username = "d123";
$password = "d123";
$dbname = "dgroup2";
$pdo = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);

//$flag = 'R';

if(isSet($_POST['flag'])){
	$flag = $_POST['flag'];
if($flag == 'V'){
	if(isset($_POST['uname']))
		$uname = $_POST['uname'];
	if(isset($_POST['psw']))
		$psw = $_POST['psw'];
	// $uname = 'C143456';
	// $psw = 'ABCDE123';
	$query = ("select * from student where sid = '$uname' and spwd = '$psw' ");
	$res=$pdo->query($query);
	if($res->rowCount()==0)
		$callback=array('status'=>3);
    else
    	$callback=array('status'=>1);
}
elseif($flag == 'C'){
	$sid = $_POST['sid'];
	//$sid = 'C143456';
	//database query 
	$sth = $pdo->query("select DISTINCT C.CID, C.CNAME from COURSE C where C.CID = c.cid not in (select STUDENT_COURSE.CID from STUDENT_COURSE  
		where STUDENT_COURSE.SID= \"$sid\");");
	$result = $sth->fetchAll();
	$callback = array();
	foreach ($result as $rows) {
		array_push($callback,array('cid' => $rows['CID'],'cname' => $rows['CNAME']));
		# code...
	}
 }
 elseif ($flag == 'S') {
 	//$sid = 'C143456';
	$sid = $_POST['sid'];
	$sth = $pdo->query("select DISTINCT A1.AID, A1.A_FILENAME, C1.CID, C2.CNAME from ASSIGNMENT A1, COURSE_ASSIGNMENT C1, COURSE C2 where C1.AID =  A1.AID and C2.CID = C1.CID and C1.CID= c1.cid not in (select S.CID from STUDENT_COURSE S where S.SID= \"$sid\");");
	$result = $sth->fetchAll();
	$callback = array();
	foreach ($result as $rows) {
		array_push($callback,array('did' => $rows['AID'],'dname' => $rows['A_FILENAME'],'cid' => $rows['CID'],'cname'=>$rows['CNAME']));
	}
 }
 elseif($flag == 'R'){
	$aid = $_POST['did'];//aid
	$sid = $_POST['sid'];
 	// $sid = 'C143456';
 	// $aid = '11';
	$sth = $pdo->query
	("select C1.CID, A1.A_FILENAME, A1.A_FILE, A1.DUEDATE, 
	S1.DID, S1.S_FILENAME, S1.S_FILE, S1.TIME, S1. SCORE, A1.MAX, A1.MIN, A1.MEAN
 	from ASSIGNMENT A1, SUBMISSION S1, ASSIGNMENT_SUBMISSION A2, STUDENT_COURSE C1,COURSE_ASSIGNMENT C2
 	where S1.SID = \"$sid\" and A1.AID=\"$aid\" and A2.AID = \"$aid\" and S1.DID=A2.DID and C1.SID=\"$sid\" and C2.CID = C1.CID and C2.AID = \"$aid\"");
	$result = $sth->fetchAll();
	$callback = array();
	foreach ($result as $rows) {
		array_push($callback,array('cid' => $rows['CID'],'dueDate' => $rows['DUEDATE'],'did' => $rows['DID'], 'dname' => $rows['S_FILENAME'],'url'=>$rows['S_FILENAME'],'time'=>$rows['TIME'], 'score' => $rows['SCORE'], 'max' => $rows['MAX'], 'min' => $rows['MIN'],'mean' => $rows['MEAN']));
	}
}
}



else {
	if (isSet($_FILES['submissionUpload'])){
		$callback = array('status' => false);
		$temp = $_FILES['submissionUpload'];
		if ( !($file_in = fopen($temp['tmp_name'],"rb")) ) { 
			$callback = array('status' => 1);
 		}
		else{
		$image = addslashes(fread($file_in,filesize($temp['tmp_name'])));
		$filename = $temp['name'];
		$did = $_POST['did'];
		$test = $pdo->query(" update submission set S_FILE = \"$image\" where DID = '$did'");
			if($test){
				$pdo->query("update submission set S_FILENAME =  \"$filename\" where DID = \"$did\" ");
				$pdo->query("update submission set TIME = now() where DID = \"$did\"");
				$callback = array('status' => true);
			}
		}
	}
}

echo json_encode($callback);
?>