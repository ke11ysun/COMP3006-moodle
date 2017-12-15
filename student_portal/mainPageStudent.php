<!DOCTYPE html>


<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="boundary.css">
	<script src = "jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src = "general.js"></script>
	<title>Student Assignment Submission System</title>
</head>
<body>
<div class="header">
	<h1 class="title">
    <span class="capital">S</span><span class="remain">tudent</span>
    <span class="capital">A</span><span class="remain">ssignment</span>
    <span class="capital">S</span><span class="remain">ubmission</span>
    <span class="capital">S</span><span class="remain">ystem</span>
	</h1>
	<span id = "header" style="position: absolute;right: 0px; top:60px;font-family: Arial Black; font-size:40px; color:var(--red)"></span>
</div>
<div class="navibar">
<div id = 'navibar'>
<input type="button" class = "buttonInNavi2" onclick="toHomepage()" value="HOME > " />

<input type="button" class = "buttonInNavi" onclick="logout()" value="LOGOUT" /></div>

</div>


<div class="detail" id = "detail">
</div>

<div class="master">
<h4 class="leftTitle">Course List</h4>
<br><br>
<div id="master"></div>
</div>


<script type="text/javascript">
function getSubmissionList(sid){
	var list;
		$.ajax({
		url : 'test.php',
		type : 'post',
		async: false,
		data : {sid:sid,flag:"S"},
		success : function(data){
			list = data;
		},
		fail:function(){
			alert("failed");
		}
		});
	var parsed = JSON.parse(list);
	var arr = [];
	for(var x in parsed){
		arr.push(parsed[x]);
	}
	return arr;
}

function getCourseList(sid){
	var list;
		$.ajax({
		url : 'test.php',
		type : 'post',
		async: false,
		data : {sid:sid,flag:"C"},
		success : function(data){
			list = data;
		},
		fail:function(){
			alert("failed");
		}
	});
	var parsed = JSON.parse(list);
	var arr = [];
	for(var x in parsed){
		arr.push(parsed[x]);
	}
	return arr;
}

	checkCookie();
	var sid = getCookie(COOKIENAME);
	document.getElementById('header').innerHTML = sid;
	var courseList = getCourseList(sid);
	var submissionList = getSubmissionList(sid);
		var cid = '<?php if (isset($_GET["returnCourse"])) echo $_GET["returnCourse"];else echo 0 ?>';
		if(cid != 0)
			selectCourse(cid);
		else {
		arrangeFormatForMaster(courseList,null);
		arrangeFormatForDetail(submissionList);
		}

	function toHomepage(){
		checkCookie();
		arrangeFormatForDetail(submissionList);
		arrangeFormatForMaster(courseList,null);
		removeChild('navibar');
	}

	function selectCourse(cid){
		checkCookie();
		arrangeFormatForMaster(courseList,cid);
		removeChild('navibar');
		var assignList = [];
		submissionList.forEach(function(rows){
			if(cid == rows.cid)
				assignList.push(rows);
		})
		document.getElementById('navibar').innerHTML += '<input type="button" class = "buttonInNavi2" value="'+cid+' > " />';
		arrangeFormatForDetail(assignList);
		
	}

	function arrangeFormatForMaster(courseList,selectedid){
		var temp = '';

		courseList.forEach(function(rows){
			temp +=
			'<input type = "button" onclick = "selectCourse(\''+rows.cid+ '\')" class="'+ (selectedid==rows.cid?'courseSelected':'courseUnselected') +'" value = "'+rows.cname+'"/>';
		})
		document.getElementById('master').innerHTML = temp;
	}

	function arrangeFormatForDetail(list){
		var temp = '';
		if(list.length==0)
			temp += '<button class="assign">No Assignment</button>';
		else{
		temp+='<form action = "Submit.php" method = "GET">';
			list.forEach(function(rows){
				temp += '<button type = "submit" name = "assign" class="assign" value = "'+rows.did+'">'+ rows.cname + '----' + rows.dname + '</button>';
			})
		temp+='</form>';}
		document.getElementById('detail').innerHTML = temp;
	}

</script>
</body>
</html>