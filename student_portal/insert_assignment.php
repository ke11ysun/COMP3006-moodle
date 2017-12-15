create table ASSIGNMENT
(AID varchar(45),
DUEDATE DATE,
A_FILE longblob,
A_FILENAME varchar(45),
MAX double,
MEAN double,
MIN double,
PRIMARY KEY (AID)
);

insert into assignment('1231','')

<?php
// Connect to the database server

$host = "localhost" ;
$username = "d123";
$password = "d123";
$dbname = "dgroup2";
$pdo = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
//Create and prepare the query

function insert($aid,$filename,$duedate){
	$date_for_database = date ("Y-m-d H:i:s", strtotime($duedate));
	global $pdo;
	if ( !($file_in = fopen("$filename","rb")) ) { 
		die("Cannot open input file.<br>\n");
 	}
	$image = addslashes(fread($file_in,filesize("$filename")));
	$pdo->query("insert into assignment values ( \"$aid\",\"$date_for_database\", \"\",") || die ("Cannot insert file into archive.<br>\n");
	print ("$filename check-in filearchive okay.<br>\n");
}

insert("1.png","u123","u123");
insert("2.png","u234","u234");
insert("3.png","u345","u345");

?>
</body>

insert into assignment values('11','2015-11-13 11:11:11',NULL,'1231',0,0,0);
insert into assignment values('12','2017-11-13 11:11:11',NULL,'1234',0,0,0);
insert into assignment values('13','2015-11-13 11:11:11',NULL,'1234',3,3,3);
insert into assignment values ('2345','2016-11-18',null,'essay in latin',95,39,73);

insert into COURSE_ASSIGNMENT values ('COMP3006','11');
insert into COURSE_ASSIGNMENT values ('COMP7777','12');
insert into COURSE_ASSIGNMENT values ('COMP3006','13');
insert into course_assignment values('LATI1005','2345');

insert into SUBMISSION values ('a11',null,null,null,null,'C143456');
insert into SUBMISSION values ('a12',null,null,null,null,'C143456');
insert into SUBMISSION values ('a13',null,null,null,null,'C143456');
insert into submission values ('1434560000',null,'C143456Essay',null,88,'C143456');

insert into ASSIGNMENT_SUBMISSION values ('11','a11');
insert into ASSIGNMENT_SUBMISSION values ('12','a12');
insert into ASSIGNMENT_SUBMISSION values ('13','a13');
insert into assignment_submission values('2345','1434560000');

insert into assignment values ('0001','2016-12-01',NULL,'asg01',null,null,null);
insert into course_assignment values ('COMP2016','0001');

insert into assignment values ('0M21','2016-12-10',NULL,'paper01',null,null,null);
insert into assignment values ('00P1','2016-12-12',NULL,'project2016',null,null,null);
insert into course_assignment values ('COMP2016','00P1');
insert into course_assignment values ('COMP2016','0M21');
