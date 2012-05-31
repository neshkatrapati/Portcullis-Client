<?php
ob_start();
require 'classes.php';
?>
    	<html>
	<head>
	<title>Portcullis- Client </title>
	<link rel="stylesheet" type="text/css" href="demo.css"></link>
<link rel="stylesheet" type="text/css" href="login.css"></link>
	<link rel="stylesheet" type="text/css" href="./style.css" />
	<script type="text/javascript">
		<style text='text/css'>

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

		</style><script>
		function validate_email()
		{
		var st1=document.reg.email.value;
		var atpos=st1.indexOf("@");
		var st2=st1.substring(atpos,st1.length);
		if(st2!="@jntu.ac.in")
		  {
		  alert("Username must be in the format username@jntu.ac.in");
		  }
		}
	</script>
	<?php if(!file_exists("connectioncli.php")){echo "<script type='text/javascript'>window.location='install.php'</script>";} ?>
	<?php if($_GET["err"]=="true"){echo "Not Authenticated Try Again!";}?>
	</head>
	
	<body >
		<div id="main_container">
			<!-- LOGO -->
			
			<!--LOGO ENDS  -->

						<div id="main_navigation" class="main-menu ">	<!--  MAIN  NAVIGATION--> 
				<ul> 
					
					<li><a  target="_blank" href="resulthome.php">Results</a></li> 
					<li><a  target="_blank" href="install.php?conf=true">Configure Portcullis</a></li>
					<li><a  target="_blank" href="auth.php?goto=manageDB">Manage Database</a></li>
					<li><a  target="_blank" href="http://results.jntuh.ac.in/Registration/core/register.php" title="Register">Register</a></li>
					<li><a  target="_blank" href="http://results.jntuh.ac.in/">About</a></li> 
				</ul> 
			
</div>
		<a onclick="jQuery('html, body').animate( { scrollTop: 0 }, 'slow' );"  href="" class="bookmark" title="Top"><img src="./images/top.gif" alt="" title="" border="0" /></a>

<div class="fullwidth_content">
<div id="formWrapper">
	<center><img src='images/logo.png' id='rotate' width="200" height="200"></img></center><br><br>
	<div id="formCasing" style='padding-top:0px;padding-bottom:20px'>
		
		<h2 style='color:white'><center>Portcullis Login<center></h2>
		<div id="loginForm">	
			<form method="post" action="#" onsubmit="" name="login" id="login">
				<table cellspacing=10>
				<tr><td><label for="ologin" class='loginlabel'>Username</label></td>
				<td><input type="text" name="email" id="ologin" value="" style=''></input></td></tr><tr>
				<td><label for="opass" class='loginlabel'>Password</label></td>
				<td><input type="password" name="pass" value=""></input>&emsp;<input type="submit" class='btn' name="submit" value="Submit" style="width:25%"></td>
				</table>
				<center><a target='_blank' href='http://results.jntuh.ac.in/Registration/core/forgotPswd.php'> Forgot Password?</a></center>
				</form>		
				
		</div>
			
	</div>
	<div id="formFooter"></div>

</div>

<br></br>
<div style="width:850px; float:left; margin:10px 0px 0px 0 15px;">Portcullis - JNTU <a href="http://www.jntu.ac.in">jntu.ac.in</a></div>
</div><!--end of main_container--> 
<?php	
if($_GET["err"] == "true"){
		echo "<script type='text/javascript'>alert('Wrong Credentials!! .. Please Relogin!!');window.location='phase1.php'</script>";
	}
if(array_key_exists("token",$_COOKIE)){

				setcookie("username","",time()+60);
				setcookie("passphrase","",time()+60);
				setcookie("key","",time()+60);
				setcookie("keymas","",time()+60);
				setcookie("token","",time()+60);
			}

if(isset($_POST["submit"]))	{
			
			$username=$_POST['email'];	
			$passphrase=$_POST['pass'];
			$o = new Operator();
			$o->phase1($username,$passphrase);
			
		}
		?>
		<div id="additional">
</div>
<?php ob_end_flush(); ?>
</body>
</html>
