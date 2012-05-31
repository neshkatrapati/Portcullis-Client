<html><head>
<?php

function redirect($location)
	{
		echo "
		<script type='text/javascript'>
			setTimeout('delayer()',1000);
			function delayer(){
			
			window.location = '".$location."';
			}
		</script>
		";
		
	}
if(file_exists("connectioncli.php")){
redirect("resulthome.php");
}
else{
redirect("install.php");
}
?>
</head></html>
