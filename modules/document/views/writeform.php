<?php
$this->load->helper('url'); 
?>
<html>

<head>

<title></title>
<meta http-equiv="content-type" content="text/html" charset="utf-8" />
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
        google.load("jquery", "1.3");
</script>
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"
	type="text/javascript">
</script>
	<script src="<?=base_url()?>modules/document/views/js/tiny_mce/tiny_mce.js"> </script>

<script type="text/javascript">
    tinyMCE.init({
            mode : "none",
            theme : "advanced",
            skin : "o2k7",
            skin_variant : "black",
            plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            
            forced_root_block : false,
            force_br_newlines : true,
            force_p_newlines : false,
				 				
            // Theme options
			 theme_advanced_buttons1 : "preview,undo,redo,bold,italic,underline,strikethrough,forecolor,backcolor,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,bullist,numlist,outdent,indent,blockquote,search,charmap",
			 theme_advanced_toolbar_location : "top",
	        theme_advanced_toolbar_align : "center",
            theme_advanced_statusbar_location : "none",
            theme_advanced_resizing : true
    });
</script>
<style>
body {
	background-color: black;
/* 	display: block; */
}

div {
	display: block;
}

#container,#pageHeader,#boundaryLine,#pageBody {
	padding: 5px;
/* 	width: 1300px; */
	width: 100%;
	margin: 0 auto;
}

#pageHeader {
	height: 50px;
	background-color: #311093;
}

#boundaryLine {
	height: 0.5px;
	background-color: #E7E586;
}

#pageBody {
	float: left;
	position: relative;
	height: 100%;
	background-color: #EEEDE2;
	position: relative;
}

#leftContents {
	float: left;
	position: relative;
	width: 823px;
	height: 100%;
	margin-left: 1px;
	background-color: white;
}

#midContents {
	float: left;
	position: relative;
	width: 20px;
	height: 100%;
	margin-left: 1px;
	background-color: #EEEDE2;
}

#rightContents {
	float: left;
	position: relative;
	width: 440px;
	height: 100%;
	margin-left: 1px;
	background-color: white;
}

#textContainer {
/* 	position: absolute; */
	width: 100%;
	height: 100%;
	background-color: white;
}

#toggleBtn {
	position: absolute;
	top: 40%;
	width: 100%;
	height: 100px;
	top: 40%;
}

#rightContentsHeader {
	position: relative;
	height: 50px;
	margin: 0;
	padding: 0;
	background-color: #EEEDE2;
}

#rightContentsBody {
	position: relative;
	height: 100%;
	margin: 0;
	padding: 0;
}

.menuBtn {
	margin: 0;
	padding: 0;
	width: 100px;
	height: 50px;
	border-style: none;
	background-color: #EEEDE2;
	font-style: bold;
	font-size: 1.2em;
}

#imageBtn {
	background-color: white;
}

#movieBtn {
	
}

#etcBtn {
	
}

#textTitleArea {
	width: 100%;
	height: 65px;
	background-color: white;
	padding-left: 2.5%;
	padding-top: 10px
}

#textTitle {
	width: 95%;
	height: 55px;
	border-radius: 5px;
	border: 1px solid black;
	background-color: white;
	padding: 10px;
	margin: auto;
	font: 25px bold, "Vollkorn";
	/* 	border-color:red; */
	/* 	border: none; */
	/* -moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	padding: 25px;
	text-align: center;
	color: #BBB;
	 */
}

#textBodyArea {
 	position: absolute; 
	width: 100%;
	height: 50%;
	background-color: white;
	padding-left: 2.5%;
	padding-top: 10px;
}

#textBodyWep {
 	position: absolute; 
	width: 100%;
	background-color: white;
	padding-left: 2.5%;
	padding-top: 10px;
}

.tempDivArea {
	width: 95%;
	height: 150px;
	border-radius: 5px;
	border: 1px solid black;
	background-color: white;
	margin-top: 3px;
	padding: 0;
}

#smartBox {
	width: 100%;
	height: 100%;
	background-color: white;
	margin: auto;
	padding: auto;
}

#smartTextArea {
	width: 99%;
	height: 80%;
	border: 1px dashed green;
	border-radius: 10px;
	float: left;
}

#addText,#deleteText {
	width: 4%;
	height: 10%;
	border-radius: 10px;
	float: left;
}

#addTextBtn {
	border-radius: 10px;
	/* 	border-color : white; */
	border: none;
	background-color: red;
	color: white;
	font-size: 2em;
}

#deleteTextBtn {
	border-radius: 10px;
	/* 	border-color : white; */
	border: none;
	background-color: green;
	color: white;
	font-size: 2em;
}

#saveTextBtn {
	border-radius: 10px;
	/* 	border-color : white; */
	border: none;
	background-color: yellow;
	color: white;
	font-size: 2em;
}
#asas {
	width:100%;
	height:100px;
}
</style>
<script type="text/javascript">
function submitForm() {
tinyMCE.triggerSave();
document.forms[0].submit();
}
</script>


<script type="text/javascript">
textAreaCnt = 0;
textAreaId = '';
divAreaId = '';
tempTextAreaId ='';
tempDivAreaId='';
function dd(){
	tinyMCE.activeEditor.remove();
	var i = document.getElementById('textBodyWep');
	alert(i.innerHTML);
}
/*
function te(event)
{
	event.returnValue = false;
	  if(!event)
	   {
	       event =window.event;
	   }
	   if(!event.stopPropagation)
	   {
	       event.cancelBubble=true;
	   }
	   else
	   {
	       event.stopPropagation();
	   }
	event.cancelBubble = true;
	divElement = document.createElement("div");
	//divElement.setAttrebute("type","button");
	//divElement.innerHTML = 'ddddd';
	divElement.setAttribute("id","tarea");
	$('div#tarea').HTML= '<textarea id="asd" class="asd" onclick="te()"></textarea>';
		divElement.setAttribute("width","400");
		divElement.setAttribute("color","green");
	k = document.getElementById('smartArea').appendChild(divElement);
	alert(document.getElementById('smartArea').innerHTML);
	event.cancelBubble = "true";
	alert(document.getElementById('tarea').innerHTML);
	$replyText = jQuery('#tarea'); 
}
 */
$(document).ready(function(){
	tinyMCE.triggerSave();
	$("#saveTextBtn").click(function() {
		var ht = document.getElementById('textBodyWep');
		alert(ht.innerHTML);
	})
	$("#textTitle").focus(function(){
		if(this.value == "TextTitle") this.value = "";
	})
	$("#textTitle").blur(function(){
		if(this.value == "") this.value = "TextTitle";
	})

	$("#textBodyArea").click(function() {
		textAreaCnt++;
		var temp;
		tinyMCE.execCommand('mceRemoveControl', false, tempDivAreaId);
		tempDivAreaId = "tempDivArea"+textAreaCnt;

		textDivElement = document.createElement("div");
		textDivElement.setAttribute("id",tempDivAreaId);
		textDivElement.setAttribute("name","mydiv");
		textDivElement.setAttribute("class","tempDivArea");//tempTextArea
		document.getElementById('textBodyWep').appendChild(textDivElement);
		
	tinyMCE.execCommand('mceAddControl', false, tempDivAreaId);
		
	$("#saveTextBtn").click(function() {
		var ht = document.getElementById('smartTextArea');
		alert(ht.innerHTML);
	})

		$(".tempDivArea").on("click",function(){
			var tempTxt =tinyMCE.get(tempDivAreaId).getContent();
			tinyMCE.activeEditor.remove();
			document.getElementById(tempDivAreaId).innerHTML=tempTxt;//
			var getId = this.id;
			
			tinyMCE.execCommand('mceAddControl', false, getId);
			tempDivAreaId = getId;
		})
	}) 





	});
	//$("#textBody").blur(function() {
	//	alert("blur");
	//	tinyMCE.execCommand('mceRemoveControl', false, 'textBody');
	//})
	/*
	$("#addTextBtn").click(function() {
		textAreaCnt++;
		tempDivAreaId = "tempDivArea"+textAreaCnt;
		tempTextAreaId = "tempTextAreaId" + textAreaCnt;

		textDivElement = document.createElement("div");
		textDivElement.setAttribute("id",tempDivAreaId);
		textDivElement.setAttribute("class","tempDivArea");//tempTextArea
		textDivElement.setAttribute("name","tempDivArea");
		document.getElementById('smartTextArea').appendChild(textDivElement);
		tinyMCE.execCommand('mceAddControl', false, tempDivAreaId);

		$(".tempTextArea").on("focus",function(){
				//var getId =  this.id;
				 tinyMCE.triggerSave();

				
				tinyMCE.execCommand('mceRemoveControl', false, textAreaId);
				textAreaId = this.id;
				//divAreaId = textAreaId.parentNode.id;
				alert(document.getElementById('smartTextArea').innerHTML);
				//alert(textAreaId.parent);
				//	tinyMCE.execCommand('mceRemoveControl', false, textAreaId);	
			    //   tinyMCE.execCommand('mceAddControl', false, getId);
			       tinyMCE.execCommand('mceAddControl', false, textAreaId);
			       document.getElementById('smartTextArea').removeChild(textDivElement);
			       //alert(	tinyMCE.get('textAreaId').getContent() );
				//	textAreaId = getId;
				})
		$("#deleteTextBtn").on("click",function() {
			tinyMCE.triggerSave();		
			var temp = tinyMCE.activeEditor.getContent();
			alert(temp);
			tinyMCE.execCommand('mceRemoveControl', false, tempDivAreaId);
			//textAreaId.parentNode.innerHTML =temp;
//			document.getElementById('smartTextArea').deleteChild();
		})
	})
	$("#smartBox").click(function(){
		divElement = document.createElement("div");
		divElement.setAttribute("id","tarea");
		//divElement.setAttribute("type","button");
		//divElement.setAttribute("onclick","kk()");
		divElement.innerHTML = '<textarea id="asd" class="asd" ></textarea>';
		document.getElementById('smartArea').appendChild(divElement);
		//$(this).innerHTML="ddddddddds";
		alert("smartBox");
		$("#asd").on("click",function(){

		alert("#asd");
			})

				

		*//*event.returnValue = false;
			if(!event)
		   {
		       event =window.event;
		   }
		   if(!event.stopPropagation)
		   {
		       event.cancelBubble=true;
		   }
		   else
		   {
		       event.stopPropagation();
		   }
		   
		event.cancelBubble = true;
		event.cancelBubble = "true";

				
		alert("#tarea");
		})
		$("#asd").click(function(){

		alert("asd");
		})});
		*/
	/*
	$("#toggleBtn").click(function(){ 
		
		//if($("#rightContents").width() == 0){
			if(flag == 1){
		$("#container").css('width','1300px'); 
		$("#pageHeader").css('width','1300px');
		$("#boundaryLine").css('width','1300px');
		$("#pageBody").css('width','1300px');
		//$("#rightContents").css('width','24em');
		//$("#midContents").css('left','860px');
		$("#rightContents").show();
			//$("#toggleBtn").css('left','860px');
			//$("#imageBtn").show();
			//$("#movieBtn").show();
			//$("#etcBtn").show();
			flag=0;
		}else {
			flag=1;
			$("#container").css('width','845px'); 
			$("#pageHeader").css('width','845px');
			$("#boundaryLine").css('width','845px');
			$("#pageBody").css('width','845px');
			//alert($(document).width());
		//	var size = ( $(document).width() - $("#container").width() ) /2;
			//$("#rightContents").css('width','0em');
			//alert($("#pageBody").right());
	//		$("#midContents").css('right',$("#pageBody").width()+'px');
			$("#rightContents").hide();
		//$("#imageBtn").hide();
		//$("#movieBtn").hide();
		//$("#etcBtn").hide();
		}
	})
	$("#imageBtn").click(function(){
		$(this).css('background-color','white');
		$("#movieBtn").css('background-color','#EEEDE2');
		$("#etcBtn").css('background-color','#EEEDE2');
		
	})
	$("#movieBtn").click(function(){
		$(this).css('background-color','white');//#EEEDE2
		$("#imageBtn").css('background-color','#EEEDE2');
		$("#etcBtn").css('background-color','#EEEDE2');
		})
	$("#etcBtn").click(function(){
		$(this).css('background-color','white');//#EEEDE2
		$("imageBtn").css('background-color','#EEEDE2');
		$("#movieBtn").css('background-color','#EEEDE2');
		})
	$("#smartBox").click(function(){
		//flag++;
	//	var divElement = document.createElement("p");
	//	divElement.setAttrebute("id","tarea");
	//	divElement.setAttrebute("widht","400");
	//	divElement.setAttrebute("color","green");
	//	document.body.appendChild(divElement);
	//	myObj = document.createElement("DIV");     // ①
     //   document.body.appendChild(myObj);          // ②
      //  var img = "<img src='img" + (Math.floor(Math.random() * 100000) % 3 + 1 ) + ".gif'>";
       // myObj.innerHTML = img;

		
//		alert("	click   ");
		alert("smartBox");
		//document.getElementById('smartArea').innerHTML +='<div id="smartDiv'+flag+'" class="test"><textarea id="smartTextArea'+flag+'"></textarea></div>';
		//tinyMCE.execCommand('mceAddControl', false, 'smartTextArea');
	//this.innerHTML +='<textarea ></textarea>';
	//alert(document.getElementById('textContainer').id);
		alert(document.getElementById('smartBox').innerHTML);
	
	})
	
	//tinyMCE.execCommand('mceAddControl', false, 'tempTextArea');
	//$("[id*='smartArea']").click(function(){
		
		//})
$("[id*='smartDiv']").focus(function(){
			alert("ddddd");
		})
	//var te= $("#tempTextArea").getContent();
//[id*='smartBox']
		//tinyMCE.triggerSave();
		//textAreaId.value(textAreaId.tinymce().getContent());
//		tinyMCE.execCommand('mceRemoveControl', false, textAreaId);
		//textAreaId =this.id;
		//tinyMCE.execCommand('mceAddControl', false, textAreaId);
//	$("[id*='textTitle']").blur(function(){
//		var getId = this.id;
//		tinyMCE.execCommand('mceRemoveControl', false, getId);
//	})
$("#smartDiv1").click(function(){   
	alert("smartDiv1"); 
	})
$("#addItems").click(function(){
//	flag++
alert(document.getElementById('smartDiv1').innerHTML);
	//var temp = document.getElementById('textContainer');
	//temp.innerHTML += '<div ><textarea id="tempTextArea'+ flag +'">ddddd</textarea></div>';
	//alert(temp.id);
	//divBox.innerHTML = tinyMCE.get('textAreaId').getContent();
	//tinyMCE.execCommand('mceAddControl', false, textAreaId);
//	alert(	tinyMCE.get('textAreaId').getContent() );
	//$('textarea[name=i]').tinymce().setContent('<p>안녕하세요</p>');
	//var te= $("#tempTextArea").getContent();
	//tinyMCE.get('tempTextArea').getContent()
	//this.innerHTML = tinyMCE.get('tempTextArea').getContent();
})
	$("#removeBtn").click(function(){
		//$(this).removeClass("textarea1");
		var tid = this.id;
		alert(tid);
		tinyMCE.execCommand('mceRemoveControl', false, 'textTitle');
	})
//	$("#textTitle").focus(function(){
		//$(this).removeClass("textarea1");
//		alert("kkkkkkkkkkkkkkkkkkkkkkkkkkkkk");
//	})
	
		/*		file upload		*/
	


//		});

		

</script>

</head>
<body>
	<div id="container">

		<div id="pageHeader"></div>
		<div id="boundaryLine"></div>
		<div id="pageBody">
			<div id="leftContents">
				<form name="myform" method="post" action="somepage">
					<div id="textContainer">
						<div id="textTitleArea">
							<strong><input type="text" id="textTitle" value="TextTitle"
								onclick="textTitleSet()"> </strong>
						</div>
						<div id="textBodyArea"></div>
						<div id="textBodyWep"></div>
					</div>
					<input type="button" id="saveTextBtn" />
				</form>
			</div>
			<div id="midContents">
				<input type="button" id="toggleBtn" value="+">
			</div>
			<div id="rightContents">
				<div id="rightContentsHeader">
					<input type="button" class="menuBtn" id="imageBtn" value="Image" />
					<input type="button" class="menuBtn" id="movieBtn" value="Movie" />
					<input type="button" class="menuBtn" id="etcBtn" value="Etc" />
				</div>
				<div id="rightContentsBody">

					<div id="drop_zone">Drop files here</div>
					<output id="list"></output>

				</div>
			</div>
		</div>
	</div>
</body>

</html>
