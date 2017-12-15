
//need to modify to automatically generate aid, did 
//mainPageTeacher.html

function getCourseList(tid){
<?php
if(isset($_GET['tid']))
	{
		$tid = $_GET['tid'];
	}
$dbh = new PDO("mysql:host=localhost;dbname=dgroup2”, "dgroup2”, "123456");
$cresult = $dbh->query("select C.CNAME from COURSE C where C.CID =
	select T.CID from TEACHER_COURSE T where T.TID = \"$tid\"");
$cname = array[];
$i = 0;
foreach($cresult as $row){
	$cname[i] = $row['C.CNAME'];
	$i++;
}
echo 'var cname = ' . json_encode($cname) . ';';
$dbh = null;
?>
//use the string array "cname" to display course list
}



function getAssignmentList(courseId){
<?php
if(isset($_GET['courseId']))
	{
		$cid = $_GET['courseId'];
	}
$dbh = new PDO("mysql:host=localhost;dbname=dgroup2”, "dgroup2”, "123456");
$aresult = $dbh->query("select A1.AID, A1.A_FILENAME from ASSIGNMENT A1 where A1.AID = 
(select A2.AID from COURSE_ASSIGNMENT A2 where A2.CID = \"$cid\")");
$a_filename = array[];
$i = 0;
foreach($aresult as $row){
	$a_filename[i] = $row['A1.A_FILENAME'];
	$i++;
}
echo 'var a_filename = ' . json_encode($a_filename) . ';';
$dbh = null;
?>
//use the string array "a_filename" to display assignment list
}





//assignmentDetail.html

function getAssignmentDetail(){
<?php

$dbh = new PDO("mysql:host=localhost;dbname=dgroup2”, "dgroup2”, "123456");
$aresult = $dbh->query("select D.SID, D.DID, D.SCORE from SUBMISSION D where D.DID = 
	(select AS.DID from ASSIGNMENE_SUBMISSION AS where AS.AID = 
		(select A.AID from ASSIGNMENT A))");
		$a_detail = array[];
		$i = 0;
		foreach($aresult as $row){
			$a_detail[i] = $row ; 
			$a_detail[i]->a_score = $row['D.SCORE'];
			$a_detail[i]->a_sid = $row['D.SID'];
			$a_detail[i]->a_did = $row['D.DID'];
			//if needed, select student detail and submission detail
			$i++;
		}
echo 'var a_detail = ' . json_encode($a_detail) . ';';	
$dbh = null;	
?>
//use 2D array "a_detail"
}


function setAssignmentDetail(assignmentDetail){
<?php
if(isset($_GET['assignmentDetail']))
	{
		$a_detail = $_GET['assignmentDetail'];
	}
try{
$dbh = new PDO("mysql:host=localhost;dbname=dgroup2”, "dgroup2”, "123456");
$newscore = $a_detail->a_score;
$did = $a_detail->a_did;
$stmt = $dbh->prepare("update SUBMISSION set SCORE = \"$newscore\" where DID = \"$did\"");
$stmt->execute();
echo $stmt->rowCount() . "score updated successfully."; 
}
catch(PDOException $e){
	echo $e.getMessage();
}
$dbh = null;
?>
}


function setAssignmentStatistics(min, max, average){//need to pass a_filename 
<?php
if(isset($_GET['min'])&&isset($_GET['max'])&&isset($_GET['average']))
	{
		$min = $_GET['min'];
		$max = $_GET['max'];
		$average = $_GET['average'];
	}
	try{
	$dbh = new PDO("mysql:host=localhost;dbname=dgroup2”, "dgroup2”, "123456");
	$stmt = $dbh->prepare("update ASSIGNMENT set MIN = \"$min\" where A_FILENAME = \"$a_filename\"");
	$stmt->execute();
	$stmt = $dbh->prepare("update ASSIGNMENT set MAX = \"$max\" where A_FILENAME = \"$aid\"");
	$stmt->execute();
	$stmt = $dbh->prepare("update ASSIGNMENT set MEAN = \"$average\" where AID = \"$a_filename\"");
	$stmt->execute();
	echo $stmt->rowCount() . "score updated successfully."; 
	}
	catch(PDOException $e){
		echo $e.getMessage();
	}
	$dbh = null;	
?>
}


function setAssignment(){//need to pass cname,releaseDate
//......
//inside else

<?php
if(isset($_GET['assignmentName'])&&isset($_GET['dueDate'])&&isset($_GET['descriptionFile'])&&isset($_GET['releaseDate']))
	{
		$a_filename = $_GET['descriptionFile'];
		//we set the uploaded filename as the assignment name in the db
		$dueDate = $_GET['dueDate'];
		$releaseDate = $_GET['releaseDate'];
	}
	try{
	$dbh = new PDO("mysql:host=localhost;dbname=dgroup2”, "dgroup2”, "123456");
	$file_in = fopen("$a_filename","rb") || die("Cannot open input file.<br>\n");
	$a_file = fread($file_in,filesize("$a_filename"));
	$dbh->exec("insert into ASSIGNMENT values(\"$aid\", \"$releaseDate\", \"$dueDate\", \"$a_filename\", \"$afile\", null, null, null)");
}catch(PDOException $e){
	echo $e->getMessage();
}
$dbh = null;
?>

}



//[create new assignment]
$cid = "";

mysql_query("insert into ASSIGNMENT values(\"$aid\", \"$releaseDate\", \"$dueDate\", \"$a_filename\", \"$afile\", null, null, null);") || die ("Cannot insert file into archive.<br>\n");
mysql_query("insert into COURSE_ASSIGNMENT values(\"$cid\", \"$aid\");");






















<?php
$dbh = new PDO("mysql:host=localhost;dbname=dgroup2”, "dgroup2”, "123456");


//[display course list for teacher]
$cresult = $dbh->query("select C.CNAME from COURSE C where C.CID =
	select T.CID from TEACHER_COURSE T where T.TID = \"$tid\"");
$cname = array[];
$i = 0;
foreach($cresult as $row){
	$cname[i] = $row['C.CNAME'];
	$i++;
}
return $cname;


//[display assignment list for teacher]
$aresult = $dbh->query("select A1.AID, A1.A_FILENAME from ASSIGNMENT A1 where A1.AID = 
(select A2.AID from COURSE_ASSIGNMENT A2 where A2.CID = 
(select C.CID from TEACHER_COURSE C where C.TID = \"$tid\"))");

foreach($aresult as $row){
	$aid = $row['A1.AID'];
	$a_filename = $row['A1.A_FILENAME'];
	//[display aid a_filename]
}


//[display teacher list for certain course]
$tresult = $dbh->query("select T.TNAME, T.TDPT, T.CONTACT, T.TEMAIL from TEACHER T where T.TID = 
(select TC.TID from TEACHER_COURSE TC where TC.CID = 
(select C.CID from COURSE C where CNAME = \"$cname\"))");

foreach($tresult as $row){
	$tname = $row['T.TNAME'];
	$tdpt = $row['T.TDPT'];
	$tcontact = $row['T.TCONTACT'];
	$temail = $row['T.TEMAIL'] ;	
	//[display aid a_filename]
}


//[display submission list for teacher][check over due]
$sresult = $dbh->query("select S.S_FILENAME, S.SNAME, S.SCORE, S.TIME from SBUMISSION S where S.DID = 
(select A1.DID from ASSIGNMENT_SUBMISSION A1 where A1.AID = 
(select A2.AID from ASSIGNMENT A2 where A2.A_FILENAME = \"a_filename\")
)");

$dueDate = $dbh->query("select DUEDATE from ASSIGNMENT where A_FILENAME = \"$a_filename\"");

foreach($sresult as $row){
	$s_filename = $row['S.S_FILENAME'];
	$sname = $row['S.SNAME'];
	$score = $row['S.SCORE'];
	$time = $row['S.TIME'] ;	
	if($time > $dueDate) [display this row in a different format]
	else  [display a normal row of s_filename, sname, score, time]
}


//[download s_file]
$file_out = fopen("$s_filename","w") || die("Cannot open file for write.<br>\n");

$sresult = $dbh->query ("select S_FILE from SUBMISSION where S_FILENAME =  \"$s_filename\"") ;
if (!$sresult) die ("Cannot select record from archive.<br>\n");
foreach($sresult as $row){
	$s_file = $row['S_FILE'];
}
fwrite($file_out, $s_file ) || die ("Cannot write file.<br>\n");
fclose( $file_out ) ;
[display "download successful" message or pop up window or whatever]
[dunno the download path]



//[display course list (student)]
$course = $dbh->query
("select C.CID, C.CNAME from COURSE C where C.CID =  
	(select STUDENT_COURSE.CID from STUDENT_COURSE  
		where STUDENT_COURSE.SID= \"$sid\");");
$i=0;
$cid=[];
$cname=[];
foreach($course as $row){
	$cid[$i] = $row['C.CID'];
	$cname[$i] = $row['C.CNAME'];
	$i++;
}



//[display assignment list (student)]
$asg = $dbh->query
("select A1. AID, A1.A_FILENAME, A1.A_FILE, A1.RELEASEDATE, A1.DUEDATE from ASSIGNMENT A1  where A1.AID =  
	(select A2.AID from COURSE_ASSIGNMENT A2, STUDENT_COURSE S
		where A2.CID=S.CID and S.SID= \"$sid\");");
foreach($asg as $row){
	$aid=$row['A1.AID'];
	$a_filename=$row['A1.A_FILENAME'];
	$a_file=$row['A1.A_FILE'];
	$releaseDate=$row['A1.RELEASEDATE'];
	$dueDate=$row['A1.DUEDATE'];
	//[display assignment]
}


//[display submission list (student)]
$sub = $dbh->query
("select S_FILENAME, S_FILE, TIME, SCORE from SUBMISSION where SID = \"$sid\"");
$dueDate=$dbh->query
("select A.DUEDATE from ASSIGNMENT A, ASSIGNMENT_SUBMISSION M, SUBMISSION S
    where A.AID=M.AID and S.DID=M.DID and S.SID=\"$sid\";")
foreach($sub as $row){
	$s_filename=$row['S_FILENAME'];
	$s_file=$row['S_FILE'];
	$time=$row['TIME'];
	$score=$row['SCORE'];
	if($time>$dueDate){
		//[display overdue]
	}else{
		//[display normal]
	}
}




//[display one submission score details (student)]
$dScore = $dbh->query
("select MAX, MEAN, MIN from ASSIGNMENT where AID= 
	(select AID from ASSIGNMENT_SUBMISSION A, SUBMISSION S 
		where S.SID = \"$sid\" and A.DID=S.DID and S.DID=\"$did\");");
foreach($dScore as $row){
	$max=$row['MAX'];
	$mean=$row['MEAN'];
	$min=$row['MIN'];
	if(!$max=="" && !$mean=="" && !$min=""){
		//[display max min mean]
	}else{
		//[no display]
	}
}












































//[finish: calculations]
$aresult = $dbh->query("select S.SCORE from SUBMISSION S where S.DID = 
(select A1.DID from ASSIGNMENT_SUBMISSION A1 where A1.AID =
(select A2.AID from ASSIGNMENT A2 where A2.A_FILENAME = \"$a_filename\"))");

foreach($sresult as $row){
	$score = $row['S.SCORE'];	
	$max = 
	$min = 
	$mean = 
}

mysql_query("update ASSIGNMENT set MAX = \"$max\" where A_FILENAME = \"$a_filename\"");
mysql_query("update ASSIGNMENT set MIN = \"$min\" where A_FILENAME = \"$a_filename\"");
mysql_query("update ASSIGNMENT set MEAN = \"$mean\" where A_FILENAME = \"$a_filename\"");


//[create new assignment]
$cid = "";
$file_in = fopen("$a_filename","rb") || die("Cannot open input file.<br>\n");
$a_file = fread($file_in,filesize("$a_filename"));
mysql_query("insert into ASSIGNMENT values(\"$aid\", \"$releaseDate\", \"$dueDate\", \"$a_filename\", \"$afile\", null, null, null);") || die ("Cannot insert file into archive.<br>\n");
mysql_query("insert into COURSE_ASSIGNMENT values(\"$cid\", \"$aid\");");



//[save: update score]
$scores = array();
[array element format may be (sname, score)]
foreach($scores as $score){
mysql_query("update SUBMISSION set SCORE = \"$score\" where SNAME = \"$sname\"");
}


//[exit: return to menu]



//[upload submission (student)]
$file_in = fopen("$s_filename","rb") || die("Cannot open input file.<br>\n");
$s_file = fread($file_in,filesize("$a_filename"));

mysql_query("update SUBMISSION set S_FILENAME= \"$s_filename\" where SID=\"$sid\" ;") || die ("Cannot upload file into archive.<br>\n");
mysql_query("update SUBMISSION set S_FILE= \"$s_file\" where SID=\"$sid\" ;");



//[download submission (student)]
$file_out = fopen("$s_filename","w") || die("Cannot open file for write.<br>\n");
$submission = $dbh->query("select S_FILE from SUBMISSION where S_FILENAME =  \"$s_filename\"") ;
if (!$submission) die ("Cannot select record from archive.<br>\n");
if ( mysql_numrows( $result ) < 1 ) die ("File was not check in.<br>\n") ; 
fwrite($file_out, $s_file ) || die ("Cannot write file.<br>\n");
fclose( $file_out ) ;
//[display "download successful" message or pop up window or whatever]
//[dunno the download path]
//end display submission

?>