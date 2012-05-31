<?php
require 'classes.php';
?>
    	<html>
	<head>
	<title>Portcullis- Client </title>
	<link rel="stylesheet" type="text/css" href="demo.css"></link>
<link rel="stylesheet" type="text/css" href="login.css"></link>
	<link rel="stylesheet" type="text/css" href="./style.css" />
	<script type="text/javascript" src="lib/jquery.js"></script>
	<link rel="stylesheet" href="lib/nyromodal/styles/nyroModal.css" type="text/css" media="screen" />
    <script type="text/javascript" src="lib/nyromodal/js/jquery.nyroModal.custom.js"></script>
    
    
		<style type='text/css'>
.he{
	 background-image: -khtml-gradient(linear, left top, left bottom, from(#80BED6), to(#222222));
 background: -webkit-gradient(linear, left top, left bottom, from(#0272A7), to(#013953));
    background: -moz-linear-gradient(top, #0272A7, #013953);
  background: -o-linear-gradient(#333333, #222222);
  
	}
.modal .modal-footer .btn {
  float: right;
  margin-left: 10px;
}
.btn {
  display: inline-block;
  background-color: #e6e6e6;
  background-repeat: no-repeat;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), color-stop(0.25, #ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -moz-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -ms-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -o-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  padding: 4px 14px;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  color: #333;
  font-size: 13px;
  line-height: 18px;
  border: 1px solid #ccc;
  border-bottom-color: #bbb;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
}
.btn:hover {
  background-position: 0 -15px;
  color: #333;
  text-decoration: none;
}
.loginlabel{
		font-size:10px;
	}

		</style>
		<script type='text/javascript'>
			$(function() {
	
  $('.nyroModal').nyroModal();
  $('.nyroModal').resize();
});
$(function() {
  $.nmObj({
    sizes : {initW:"1000",initH:"1000"}
  });
});

			</script>
	</head>
	
	<body >
		
		<div id="main_container">
			<!-- LOGO -->
			
			<!--LOGO ENDS  -->
<div class='he' style="display:block:float:left;"><h1 style='margin-left:20px;color:white;padding-bottom:10px'>
<?php if($_GET["conf"]=="true"){echo "Configure Portcullis";}else{echo"Install Portcullis";}?></h1></div>
<center><h2 style='color:white'><a href='howto.php' class='nyroModal'  target='_blank' title='Instructions'>Read Instructions</a></h2></center>
		
		
		<a onclick="jQuery('html, body').animate( { scrollTop: 0 }, 'slow' );"  href="" class="bookmark" title="Top"><img src="./images/top.gif" alt="" title="" border="0" /></a>

<div class="fullwidth_content">
<div id="formWrapper" style='width:550px;'>
	
	<div id="formCasing" style='padding-top:0px;padding-bottom:20px'>
		<div id="loginForm" style='margin-left:0px'>	
			<form method="post" action="#" onsubmit="" name="login" id="login" ><br>
				<table cellspacing=10 >
				<tr><td ><label for="ologin" class='loginlabel' style='font-size:20px;color:white'><b>DB Host</b></label></td>
				<td><input type="text" name="dbhost" id="ologin" value="" style=''></input></td></tr><tr>
				<tr><td ><label for="ologin" class='loginlabel' style='font-size:20px;color:white'><b>DB Username</b></label></td>
				<td><input type="text" name="dbuname" id="ologin" value="" style=''></input></td></tr><tr>
				<tr><td ><label for="ologin" class='loginlabel' style='font-size:20px;color:white'><b>DB Password</b></label></td>
				<td><input type="text" name="dbpass" id="ologin" value="" style=''></input></td></tr><tr>
				<tr><td ><label for="ologin" class='loginlabel' style='font-size:20px;color:white'><b>Database Name</b></label></td>
				<td><input type="text" name="dbname" id="ologin" value="" style=''></input></td></tr><tr>
				<tr><td ><label for="ologin" class='loginlabel' style='font-size:20px;color:white'><b>College Name</b></label></td>
				<td><input type="text" name="cname" id="ologin" value="" style=''></input></td></tr>
				</table>
				<input type="submit" class='btn' name="submit" value="Submit" style="width:25%;float:right;margin-right:10px">
				<br><br><br>
				</form>		
				
		</div>
			
	</div>
	<div id="formFooter"></div>

</div>

<br></br>
<div style="width:850px; float:left; margin:10px 0px 0px 0 15px;">Portcullis - JNTU <a href="http://www.jntu.ac.in">jntu.ac.in</a></div>
</div><!--end of main_container--> 
<?php	
function gen($dbhost,$dbuser,$dbpass,$dbname,$cname){
		return "<?php \ndefine(\"COLLEGENAME\",\"$cname\");\ndefine(\"DBHOST\",\"$dbhost\");\ndefine(\"DBNAME\",\"$dbname\");"."\n$"."con = mysql_connect(\"$dbhost\", \"$dbuser\",\"$dbpass\");\nmysql_select_db(\"$dbname\", "."$"."con);\n?>";
	}

if(isset($_POST["submit"]))	{
	
	$host = $_POST["dbhost"];
	$uname = $_POST["dbuname"];
	$pass = $_POST["dbpass"];
	$db = $_POST["dbname"];
	$cname = $_POST["cname"];
	$link = mysql_connect($host,$uname,$pass);
	if (!$link) {
	    echo "<script type='text/javascript'>alert('Wrong Credentials!!');window.location='install.php'</script>";
	}
	else if(!mysql_select_db($db)){
		echo "<script type='text/javascript'>alert('Cant Connect to Database!!');window.location='auth.php'</script>";
	}
	
	if($_GET["conf"]!="true" && table_exists("MRESULTT") == FALSE){
				mysql_query("CREATE TABLE MRESULTT(rtabname text,rname text)");
	}
	
	$x = gen($host,$uname,$pass,$db,$cname);
	$op = fopen("connectioncli.php","w");
	fwrite($op,$x);
	echo "<script type='text/javascript'>window.location='phase1.php';</script>";
}
function table_exists($tablename){
		$x = mysql_query("show tables like '$tablename'");
		if(mysql_num_rows($x) > 0)
			return TRUE;
		else
			return FALSE;
	
}
?>
<div id="additional">
</div>
</body>
</html>
