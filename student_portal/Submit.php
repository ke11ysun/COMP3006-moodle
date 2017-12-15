<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="boundary.css">
	<script src = "general.js"></script>
	<script src = "jquery-3.1.1.min.js"></script>
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
<div class="navibar"><div id = "navibar"><input type="button" class = "buttonInNavi" onclick="logout()" value="LOGOUT" /></div>

</div>

<div class="detail">
<h1 align="center" id = "title"></h1>
<h1>Submission Status</h1>
<table >
  <tr>
    <td class="leftCol">Description</td>
    <td ><a id = 'des' ></a></td>
  </tr>
  <tr>
    <td class="leftCol">Grading Status</td>
    <td id = "gradingStatus"></td>
  </tr>
  <tr>
    <td class="leftCol">Due Date</td>
    <td id = "dueDate"></td>
  </tr>
  <tr>
    <td class="leftCol">Last Modified</td>
    <td id = "lastModified"></td>
  </tr>
  <tr>
    <td class="leftCol">Submission</td>
    <td> <a id = "submission"></a></td>
  </tr>
</table>
<hr>
<div id = "modifyArea">
</div>
</div>

<div class="master">
<h4 class="leftTitle">Course List</h4><br><br>
<div id="master"></div>
</div>


<script type="text/javascript">
function getSubmission(did,sid){
	var list;
		$.ajax({
		url : 'test.php',
		type : 'post',
		async: false,
		data : {did:did,sid:sid,flag:'R'},
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
		arr.push(parsed[x]);}
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
	var dragged = false;
	var modify = false;
	var did = '<?php if (isset($_GET["assign"])) echo $_GET["assign"];else echo 0 ?>';
	if (did == 0) 
		did = '<?php if (isset($_POST["did"])) echo $_POST["did"];else echo 0 ?>';
	document.getElementById('header').innerHTML = sid;
	courseList = getCourseList(sid);

	submission = getSubmission(did,sid);
		arrangeFormatForMaster(courseList,submission[0].cid);
		arrangeFormatForDetail(submission[0]);
		arrangeFormatNavibar();
	console.log(submission[0]);
	function arrangeFormatNavibar(){
		var temp = '';
		temp += '<form action = "mainPageStudent.php" method = "GET" onsubmit = "return check()">'
		temp += '<button type="submit" class = "buttonInNavi2" name = "returnCourse" value= 0 >HOME > </button>\
					<input type="submit" class = "buttonInNavi2" name = "returnCourse" value= \''+ submission[0].cid +'\' />';
		temp += '</form>';
		document.getElementById('navibar').innerHTML += temp;
	}

	function arrangeFormatForDetail(a){
		document.getElementById('des').setAttribute("href",'encode.py');
		document.getElementById('des').innerHTML = 'encode.py'
		document.getElementById('title').innerHTML = a.did
		if (a.max>0){
			if(!a.score) a.score = 0
			document.getElementById('gradingStatus').innerHTML = "SCORE: " + a.score + ' MAX: ' + a.max + " MEAN: " + a.mean + " MIN: " + a.min
		}
		else document.getElementById('gradingStatus').innerHTML = "NOT GRADING";
		document.getElementById('dueDate').innerHTML = a.dueDate;
		document.getElementById('lastModified').innerHTML = a.time;
		if(a.dname){
			document.getElementById('submission').innerHTML = a.dname;
			document.getElementById('submission').setAttribute("href",a.dname);
		}
		else
			document.getElementById('submission').innerHTML = "Waiting for your submission...";
		writeLowerRright(modify);
	}
	

	function changeFlag(){
		modify = !modify;
		writeLowerRright();
	}

	function writeLowerRright(){
		var temp;
		if(!modify) {
			dragged = false;
			if(Date.parse(submission[0].dueDate)-new Date()>0) {
				temp = '<button type="button" onclick = "changeFlag()" class="button2">Add Submission</button>'; 
				document.getElementById('modifyArea').innerHTML = temp; }
		} else {
			temp = '<div id="dropContainer" class="dropContainer">Drag and Drop XD</div> \
					<form id = "form" align="right" style="margin: 10px;" action="Submit.php" method="POST" enctype="multipart/form-data" onsubmit = "return uploading()"> \
  					<input  type="file" name = "submissionUpload" id="submissionUpload" required /><br> \
  					<input type = "hidden" name = "did" value = "'+submission[0].did+'"/>\
  					<button type="button" class="button2" onclick = "changeFlag()">Cancel</button> \
  					<button type="submit" name = "did" class="button2">Submit</button> \
  					</form>';
					document.getElementById('modifyArea').innerHTML = temp;
					addListener();
  		}
	}

	function addListener(){
			dropContainer.ondragover = dropContainer.ondragenter = function(evt) { evt.preventDefault(); };
			dropContainer.ondrop = function(evt) {
				dragged = true;
				if(evt.dataTransfer.files.length>1){
					alert("You can only upload one file!")
				}
				else{
				submissionUpload.files= evt.dataTransfer.files;}
				evt.preventDefault();
			}
			submissionUpload.onchange = function() {
				dragged = true;
			}
	}

	function arrangeFormatForMaster(courseList,selectedid){
	var temp = '';
	temp += '<form action = "mainPageStudent.php" method = "GET" onsubmit = "return check()">'
	courseList.forEach(function(rows){
		temp +=
		'<button type = "submit" name = "returnCourse" class="'+ (selectedid==rows.cid?'courseSelected':'courseUnselected') +'" value = "'+rows.cid+'">'+rows.cname+'</button>';
	})
	temp += '</form>';
	document.getElementById('master').innerHTML = temp;
	}


	function check(){
		if(dragged)
			alert('Save your changes first!');
		return !dragged;
	}


	function uploading(){
    	var file = document.getElementById('submissionUpload').files[0];
    	if(!file.type){
    		alert("Not a File!")
    		return false;
    	}
    	if(file.size > 2*1024*1024){
    		alert("exceed 2MB!");
    		return false;
    	}
		var temp = new FormData(document.getElementById("form"));
		$.ajax({
		url : 'test.php',
		type : 'post',
		async: false,
		data : temp,
		processData: false,  // tell jQuery not to process the data
		contentType: false,   // tell jQuery not to set contentType
		success : function(callback){
			var a = JSON.parse(callback)
			console.log(callback)
			if(a.status==true){
				alert('success!')
				location.reload()}
			else {
				if(a.status==2){
					alert("exceed 2MB!")
				}
				else
					alert("ERROR....");
			}
		}
		});
		return false;
}
</script>


</body>
</html>