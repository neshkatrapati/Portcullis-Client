<html>
<head>
	<LINK href="style.css" rel="stylesheet" type="text/css">
			<link rel="stylesheet" type="text/css" href="demo.css"></link>
<link rel="stylesheet" type="text/css" href="login.css"></link>
<link rel="stylesheet" type="text/css" href="basic.css"></link>
</head>
<body>
	<?php if(!file_exists("connectioncli.php")){echo "<script type='text/javascript'>window.location='install.php'</script>";} ?>
<?php include_once("basic.php"); ?>
<center>
<div class="fullwidth_content" >
	
<div style="margin-top:30%;margin-left:40%" >
			<div id="login-box" style='height:50%'>
				<div class="dashboard">
<?php
require 'settings.php';
require 'classes.php';
require 'connectioncli.php';
if($_GET["bid"] != ""){
	$table = $_POST["table"];
		if($_POST["cnt"] > ($_GET["bid"]+1)){
			$chstring = $_POST["chstring"];
			$choice = $_POST["choice"];
			$table = $_POST["table"];
			$cnt = $_POST["cnt"];
			$b = $_GET["bid"] + 1;
			echo "<h3>Fetched Branch : $b</h3><br>";
			echo "<form action='?bid=$b' method='post'>";
			
			  	echo "<input type='hidden' name='chstring' value='$chstring'></input>";
                    	echo "<input type='hidden' name='choice' value='$choice'></input>";
                    	echo "<input type='hidden' name='table' value='$table'></input>";
                    	echo "<input type='hidden' name='cnt' value='$cnt'></input>";
			echo "<input type='submit'  class='btn' value='Click To Continue &raquo;' name='sub' style='width:300;' ></input>
			</form>";
			
		}
		else{
			
				echo "<br><h3 style='color:white'>Completed Fetching Check The Results <a href='result.php?resid=$table'>HERE</a></h3>";
			}
}
	
	
if($_GET["bid"] != "" && isset($_POST["sub"])){
                    	
                    	
                    	$bid = $_GET["bid"];
							$choicearray  = explode(";",$_POST["chstring"]);
							
						$branches = explode(":", $choicearray[2]);
                    	$cnt =0;
                    	$table = $_POST["table"];
                    	$choice = $_POST["choice"];
                    	$times = time();
                    		$url = getSHOST()."?mode=choice&choice=".$choice."&branch=".$branches[$bid]."&token=".$_COOKIE['token'];
               				//echo $url."<br>";
                    		$ch = curl_init();
                    		curl_setopt($ch, CURLOPT_URL, $url);
                    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    		curl_setopt($ch, CURLOPT_REFERER, "www.google.com");
                    		$body = curl_exec($ch); 
                    		curl_close($ch);
                    		
                    		$key =  substr($_COOKIE['keymas'],0,16);
                    		$cryptox = new Crypto($key);
                    		$cont = json_decode($body);
                    		$result = $cont->results;
                    		if($bid == 0)
                    		{
                    			$resname = $cont->name;
                    			insertResult($resname, $table);
                    			
                    		}
                    		$count = dbproc($result,$table);     		
                    	$timee = time();
                    	$secs = $timee - $times;
                    	echo "<br><h4 style='color:white'>Fetched $count Records in $secs</h4>";
					}

                
?>
</div>
</div>
</div>
</div></body>
</html>
