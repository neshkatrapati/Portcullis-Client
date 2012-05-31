
<html>
    <head>
    <link href="css/uni-form.css" media="screen" rel="stylesheet"/>
    <link href="css/default.uni-form.css" title="Default Style" media="screen" rel="stylesheet"/>
    <link href="css/demo.css" media="screen" rel="stylesheet"/>
    </head>
    <body>
          <center>
   <table cellpadding='20px'><tr><td><a href="http://jntu.ac.in/" title="JNTU"><img src="Portcullisimage.png" alt=""  width='100' height="100"/>&emsp;<img src="images/jntulogo.jpg" alt=""/></a>&emsp;</td>
    &emsp;<td>&emsp;<h2>
      Jawaharlal Nehru Technological University Hyderabad<br>
      Kukatpally,Hyderabad - 500 085, Andhra Pradesh, India</h2></td></tr></table></center>
    
    <center>
<?php
	require_once 'connectioncli.php';
	echo  "<h1>Available Results</h1>";
	echo "<form action='#' class='uniForm' method='post'>";
	$q = mysql_query("select * from MRESULTT");
	
	while($row = mysql_fetch_array($q))
	{
		
		$table = $row["rtabname"];
		$resname = $row["rname"];
		echo "<a href='pview.php?tabname=".$table."&view=principal' style='display:block'>".$resname."</a><br>";
		
	}
	    
    ?></form>
    </center>
    <div id="footer"><h2>Jawaharlal Nehru Technological University Hyderabad
Kukatpally, Hyderabad - 500 085, Andhra Pradesh, India</h2><h2></div>
    </body>
    </html>

