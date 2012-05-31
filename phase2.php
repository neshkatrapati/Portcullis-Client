<html>
		<head>	
			<link rel="stylesheet" type="text/css" media="all" href="cal/jsDatePick_ltr.min.css" />
			<script type="text/javascript" src="cal/jsDatePick.min.1.3.js"></script>
			<link rel="stylesheet" type="text/css" media="all" href="basic.css" />
			<script type="text/javascript">
			window.onload = function(){
				new JsDatePick({
					useMode:2,
					target:"inputField",
					isStripped:false,
					dateFormat:"%d-%M-%Y",
					cellColorScheme:"torqoise"                     
					});
				new JsDatePick({
					useMode:2,
					target:"inputField2",
					cellColorScheme:"beige",                        
					dateFormat:"%d-%M-%Y",
					imgPath:"../aux/calendar/img/"
					});
				};
			</script>	
			<LINK href="style.css" rel="stylesheet" type="text/css">
			<title>Portcullis- Client </title>		
		</head>	
			
		
	<?php if(!file_exists("connectioncli.php")){echo "<script type='text/javascript'>window.location='install.php'</script>";} ?>
	<?php
		if(($_COOKIE['username']=="") || ($_COOKIE['passphrase']=="") || ($_COOKIE['key']=="") || ($_COOKIE['keymas']=="") || ($_COOKIE['token']==""))
		{
		?>		
		
		   <script type="text/javascript">
		   function delayer()
		   {
		   window.location = "phase1.php"
		   }
		   </script>
			
			<body onLoad="setTimeout('delayer()', 5000)">
			<center><div class="header">
			<img src="Portcullisimage.png" height="100" width="100" align="left"/>
			<h2> Sorry! You Are Not Authenticated By Portcullis @ JNTU. </h2>
			</br>Prepare to be redirected to Login page.
			</br>
			</div>	
			
			
		<?php
		}
		else
		{
		?>
			<body>
				
				<?php include_once("basic.php"); ?>

	<div class="fullwidth_content" >
	<center>
	<div style="padding: 10px 0px 0px 50px" >
			<div id="login-box" style='height:50%'>
			<?php if(!isset($_POST["submit2"]) && !isset($_POST["submit3"])) {?>
			<h3>Enter Date Range</h3><br>
			<form action='#' method='post'><center>
			<table style='color:white' cellspacing="10"><tr>
			<td>From Date:</td><td><input type='text' name='from' id='inputField' required=true style='text-align:center;width:auto'></td></tr><tr>
    		<td>To Date:</td><td><input type='text' name='to' id='inputField2' required=true style='text-align:center;width:auto'></td></tr>
    		</table>
    		<br>
			<input type='submit' class='btn' name='submit2' value='Submit'></input></form>
		 <?php } ?>
		<?php
		}			
		if(isset($_POST['submit2']) && !isset($_POST["submit3"]))
		{
		?><div class="dashboard"><?php
                require("classes.php");
                require_once "settings.php";
		$from=strtotime($_POST['from']);
		$to=strtotime($_POST['to']);
		$url = getSHOST()."?mode=daterange&range=".$from.":".$to."&token=".$_COOKIE['token'];
		//echo $url."<br>";
		
        	$ch = curl_init();
        	curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        	curl_setopt($ch, CURLOPT_REFERER, "www.google.com");
        	$body = curl_exec($ch);
        	curl_close($ch);
                //echo $body;
                $crypto = new Crypto($_COOKIE['keymas']);
        	$json = json_decode($body);
        	$choices = $json->choices;
        	echo "<h4 style='color:white;text-decoration:bold;'>Select from These Choices</h4><br><form action='#' method='post'>";
        	echo "<select name='choices[]' style='width:300px'>";
        	for($i=0;$i<count($choices);$i++)
        	{
            	$msg = $crypto->aesDecrypt(utf8_decode($choices[$i]->result));
            	$size = $choices[$i]->size;
            	$branches = implode(":",$choices[$i]->branches);
            	$rbvalue = implode(";", array($choices[$i]->id,$size,$branches));
            	echo "<option value='".$rbvalue."'>".$msg."</option>";
            }
            
            echo "</select><br>";
            ?><br><input type="submit" class="btn" value='Submit' name='submit3'></input></form></div>
		<?php
                } else if(isset($_POST["submit3"]))
                {
                    echo "<div class='dashboard'>";
                    require_once("classes.php");
                    require_once "settings.php";
                    $choicearray  = explode(";",$_POST["choices"][0]);
                    $choice = $choicearray[0];
					$size = $choicearray[1];
					
                    if($size == "SMALL")
                    {
						
                        $url = getSHOST()."?mode=choice&choice=".$choice."&token=".$_COOKIE['token'];
              	      	//echo $url."<br>";
              	      	
                	    $times = time();
                    	//echo "<br><br>Time Start ".$times;
                    	$ch = curl_init();
                    	curl_setopt($ch, CURLOPT_URL, $url);
                    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    	curl_setopt($ch, CURLOPT_REFERER, "www.google.com");
                    	$body = curl_exec($ch); 
                    	curl_close($ch);      
                    	$timee = time();
                    	//echo "<br><br>Time End ".$timee;
                    	echo "<br><h2>Got In ".($timee-$times)." seconds</h2>";
                    	$data = $body;
                    	include_once("aes/AES.class.php");
                    	$key =  substr($_COOKIE['keymas'],0,16);
                    	$cryptox = new Crypto($key);
                    	$cont = json_decode($body);
                    	$result = $cont->results;
                    	$table = uniqid();
                    	$resname = $cont->name;
                      	insertResult($resname, $table);
                    	createTable($table);
                    	//print_r($result);
                    	dbproc($result,$table);
              
                    } 
                    else
                    {
						$branches = explode(":", $choicearray[2]);
                    	$cnt = count($branches);
                    	$table = uniqid();
                    	createTable($table);
                    	$chstring = $_POST["choices"][0];
                    	echo "<h2>Fetch Results</h2><br><br><br>";
                    	echo "<form action='phase3.php?bid=0' method='post'>";
                    	echo "<input type='hidden' name='chstring' value='$chstring'></input>";
                    	echo "<input type='hidden' name='choice' value='$choice'></input>";
                    	echo "<input type='hidden' name='table' value='$table'></input>";
                    	echo "<input type='hidden' name='cnt' value='$cnt'></input>";
                    	echo "<input type='submit' class='btn' name='sub' value='Proceed'></input>";
                    	echo "</form>";
                    }
                }
		?>

</div>
</div>              

<div style="width:850px; float:left; margin:10px 0px 0px 0 15px;float:right;padding-top:25px">Portcullis - JNTU <a href="http://www.jntu.ac.in">jntu.ac.in</a></div>
</div><!--end of main_container--> 
			
			</body>
			</html>
