<html>
<head>
<LINK href="style.css" rel="stylesheet" type="text/css">
	
	<style>
		.box {
color: #EBEBEB;
font: 12px Arial, Helvetica, sans-serif;
background-image: -khtml-gradient(linear, left top, left bottom, from(#80BED6), to(#222));
background: -webkit-gradient(linear, left top, left bottom, from(#0272A7), to(#013953));
background: -moz-linear-gradient(top, #0272A7, #013953);
background: -o-linear-gradient(#333, #222);
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#333333', endColorstr='#222222', GradientType=0)";
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#333333', endColorstr='#222222', GradientType=0);
background-image: linear-gradient(#333, #222);
-webkit-border-radius: 10px;
-moz-border-radius: 10px;
}
.inp {
	-webkit-border-radius: 10px;
-moz-border-radius: 10px;
	}
		</style>
		<script type="text/javascript">
function showResult(str)
{
if (str.length==0)
  { 
  document.getElementById("livesearch").innerHTML="";
  document.getElementById("livesearch").style.border="0px";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
    document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
xmlhttp.open("GET","livesearch.php?q="+str,true);
xmlhttp.send();
}
function addFilter(num){
				valx = document.getElementById("valx"+num);
				valy = document.getElementById("valy"+num).value;
				valx.innerHTML = valy;
				barx = document.getElementById("barx"+num);
				bary = document.getElementById("bary"+num).value;
				barx.innerHTML = bary 
				filx = document.getElementById("filx"+num);
				fily = document.getElementById("fils"+num).value;
				filx.innerHTML = getFullOption(fily);
				compute(num);	
				var detail = getStandardDetail();
				var element = document.getElementById('filters');
				element.innerHTML = element.innerHTML +  detail;
				
				
		}
		function getStandardDetail(){
			var ele = document.getElementById("filcount");
			var dc = parseInt(ele.value);
			
			var x = "<tr id='row"+dc+"'><td id='barx"+dc+"'><input type='text' id='bary"+dc+"'></td><td id='filx"+dc+"'><select id='fils"+dc+"' style='width:200'><option value='none'>--SELECT-- </option><option value='gt'>Greater Than \"&gt;\"</option><option value='lt'>Less Than \"&lt;\"</option><option value='gte'>Greater Than or Equal To '&gt;='</option><option value='lte'>Less Than or Equal To '&lt;='</option><option value='eq'>Equal To \"=\"</option><option value='neq'>Not Equal To '!='</option><option value='in'>In [List]</option><option value='nin'>Not In [List]</option><option value='like'>Like [RegExp]</option><option value='nlike'>Not Like [RegExp]</option></select></td><td id='valx"+dc+"'><input type='text' id='valy"+dc+"'>&emsp;<button type='button' class='btn' onclick='addFilter("+dc+")' id='btn"+dc+"'>Add</button></td></tr>";
			
			ele.value = dc+1;
			return x;
		}
		function getFullOption(op){
				switch(op){
					case "gt":return "Greater Than";
					case "lt":return "Less Than";
					case "gte":return "Greater Than Or Equal To";
					case "lte":return "Less Than Or Equal To";
					case "in":return "In [List]";
					case "nin":return "Not In [List]";
					case "nlike":return "Not Like[RegExp]";
					case "like":return "Like [RegExp]";
					case "neq":return "Not Equal To";
					case "eq":return "Equal To";
					
				}
		}
		function compute(num){
			p1 = document.getElementById("barx"+num).innerHTML;
			p2 = document.getElementById("valx"+num).innerHTML;
			p3 = document.getElementById("filx"+num).innerHTML;
			f = document.getElementById("filsum");
			p = p1+":"+p3+":"+p2+";";
			f.value = f.value+ p;
			
		}
</script>
		<link rel="stylesheet" href="piechart/css/piechart.css" type="text/css" media="all" />
<script type="text/javascript" src="piechart/scripts/mootools-beta-1.2b2.js"></script> 

<!--[if IE]>
	<script type="text/javascript" src="scripts/moocanvas.js"></script>
<![endif]-->
	
<script type="text/javascript" src="piechart/scripts/piechart.js"></script> 	

<style type="text/css">

body    {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	line-height: 16px;
	margin: 20px 40px;
}

h1 {
	font-size: 24px;
	margin: 5px 0 0 0;
	padding: 0 0 12px 0;
}		

a {
	color: #690;
	text-decoration: none;
	}

a:hover {
	color: #e60;
	text-decoration: none;
	}

p {
	margin: 0 0 9px 0;
	padding: 0;
}

</style>
</head>
<body>
	<?php

$tabname = $_GET["tabname"];
$view = $_GET["view"];
	
	echo "<div style=''>
		<a href='?tabname=$tabname&view=principal' >Principal View</a>&emsp;
		<a href='?tabname=$tabname&view=branch'>Branch View</a>&emsp;
		<a href='?tabname=$tabname&view=cbranch'>Compare Branches View</a>&emsp;
		<a href='?tabname=$tabname&view=cstud'>Compare Students View</a>&emsp;
		<a href='?tabname=$tabname&view=filter'>Filter View</a>
	</div>"
	
	?>
	
<?php
require "connectioncli.php";
echo "<div style='margin-top:5%;display:inline'>";
if($view == "principal"){

	echo "<br>";
	$p = mysql_query("select rname from MRESULTT where rtabname like '$tabname'");

	$qs = mysql_fetch_array($p);
	$rpqs = $qs["rname"];
	echo "<h2>Principal View For -- $rpqs</h2>";
		echo "<br>";
			echo "<br>";
	$result = mysql_query("select * from $tabname group by(srno)");
	$data = array();
	$past = "";
	$check = 0;
	$i = 0;
	$fail = 0;
	$pass = 0;
	for($i=0;$i<mysql_num_rows($result);$i++){
		$row = mysql_fetch_array($result);
		$current = $row["srno"];
		if($current != $past && $i!=0){
			if($check == 0){
				$pass++;
			}
			else
			$fail++;
			$check = 0;
				
		}
		if($row["cre"] == 0)
		$check = -1;

	}
	if($check == 0){
		$pass++;
	}
	else
	$fail++;

		plot($pass,$fail,"ALL CLEAR","FAIL");
	
	$codes = array("01","02","03","04","05","06","07","08","10","11","12","13","15","19","21","22","23","38","57","58");
	for($i=0;$i<count($codes);$i++){
			$t = $codes[$i];
			
			branchPlot($t,$tabname);
		
	}
	
}
else if($view == "branch"){
	echo "<br>";
	echo "<form action='' method='post'>";
	echo "<input type='search' class='inp' name='bcode'/>";
	echo "<input type='submit' name='bsub' value='Submit'/>";
	echo "</form>";
	if(isset($_POST["bsub"]) || $_GET["bcode"] != ""){
		$code = $_REQUEST["bcode"];
		echo "<h4 style='color:white'><a href='?tabname=$tabname&view=csub&bcode=$code'>Compare Subjects View</a>&emsp;</h4>";
		echo "<h3>Branch Overview</h3><br>";
		
		branchPlot($code,$tabname);
		
		$res = mysql_query("SELECT distinct subcode FROM `$tabname` where  (select srno REGEXP '......$code..') = 1");
		
		echo "<br><h3>Subject Overview</h3><br>";
		while($row = mysql_fetch_array($res)){
		
			$subcode = $row["subcode"];
			$r = mysql_query("select subname from $tabname where subcode = '$subcode'");
			$x = mysql_fetch_array($r);
		   	echo $x["subname"]."<br><br><br>"; 	
		   	subPlot($row["subcode"],$tabname,$code);
		   	echo "<br>";
		
		}	
	}
	
	
}

else if($view == "cbranch"){
	echo "<br>";
		if(!isset($_POST["phase1"]) && !isset($_POST["phase2"])){
				
				echo "<form action='' method='post'>";
				echo "<input type='number' class='inp' name='nbr'/>";
				echo "<input type='submit' name='phase1' value='Submit'/>";
				echo "</form>";
				
			}
		if(isset($_POST["phase1"])){
				$nbr = $_POST["nbr"];
				echo "<form action='' method='post'>";
				for($i=0;$i<$nbr;$i++){
						echo "<input type='text' class='inp' name='br[]'/><br>";
				}
				
				
				echo "<input type='submit' name='phase2' value='Submit'/>";
				
				echo "</form>";
			
		}
		if(isset($_POST["phase2"])){
			$br = $_POST["br"];
		
		echo "<h3>Pass Comparision</h3><br>";	
			echo "	<table class='pieChart'>";
        for($i=0;$i<count($br);$i++){
			$n2 = $br[$i];
			$d2 = branchReturn($n2,$tabname,"pass");
				echo "<tr><td>$n2</td> <td>$d2</td></tr>";
		}
		
		echo "</table>" ;
		
		echo "<h3>Fail Comparision</h3><br>";
		echo "	<table class='pieChart'>";
        for($i=0;$i<count($br);$i++){
			$n2 = $br[$i];
			$d2 = branchReturn($n2,$tabname,"fail");
				echo "<tr><td>$n2</td> <td>$d2</td></tr>";
		}
		
		echo "</table>" ;
	
			
		}
	
}

else if($view == "cstud"){
	echo "<br>";
		if(!isset($_POST["phase1"]) && !isset($_POST["phase2"])){
				
				echo "<form action='' method='post'>";
				echo "<input type='number' class='inp' name='nbr'/>";
				echo "<input type='submit' name='phase1' value='Submit'/>";
				echo "</form>";
				
			}
		if(isset($_POST["phase1"])){
				$nbr = $_POST["nbr"];
				echo "<form action='' method='post'>";
				for($i=0;$i<$nbr;$i++){
						echo "<input type='text' class='inp' name='br[]'/><br>";
				}
				
				
				echo "<input type='submit' name='phase2' value='Submit'/>";
				
				echo "</form>";
			
		}
		if(isset($_POST["phase2"])){
			$br = $_POST["br"];
		
		echo "<h3>Marks Comparision</h3><br>";	
			echo "	<table class='pieChart'>";
        for($i=0;$i<count($br);$i++){
			$n2 = $br[$i];
			$p = mysql_query("select sum(extm)+sum(intm) as sum from $tabname where srno like '$n2'");
			$q = mysql_fetch_array($p);
			$d2 = $q["sum"];
				echo "<tr><td>$n2</td> <td>$d2</td></tr>";
		}
		
		echo "</table>" ;
		
		echo "<h3>Credits Comparision</h3><br>";
			echo "	<table class='pieChart'>";
        for($i=0;$i<count($br);$i++){
			$n2 = $br[$i];
			$p = mysql_query("select sum(cre) as sum from $tabname where srno like '$n2'");
			$q = mysql_fetch_array($p);
			$d2 = $q["sum"];
				echo "<tr><td>$n2</td> <td>$d2</td></tr>";
		}
		
		echo "</table>" ;
	
			
		}
	
}

else if($view == "csub"){
	echo "<br>";
	$code = $_GET["bcode"];
		if(!isset($_POST["phase1"]) && !isset($_POST["phase2"])){
				
				echo "<form action='' method='post'>";
				echo "<input type='number' class='inp' name='nbr'/>";
				echo "<input type='submit' name='phase1' value='Submit'/>";
				echo "</form>";
				
			}
		if(isset($_POST["phase1"])){
			
			$res = mysql_query("SELECT distinct subcode FROM `$tabname` where  (select srno REGEXP '......$code..') = 1");
			$put = "<select name='sub[]'>";
			while($row = mysql_fetch_array($res)){
				$subcode = $row["subcode"];
				$r = mysql_query("select subname from $tabname where subcode = '$subcode'");
				$x = mysql_fetch_array($r);
				$put .= "<option value='$subcode'>".$x["subname"]."</option>"; 	
				
			}	
			$put .= "</select>";
				$nbr = $_POST["nbr"];
				echo "<form action='' method='post'>";
				for($i=0;$i<$nbr;$i++){
						echo $put."<br>";
				}
				
				
				echo "<input type='submit' name='phase2' value='Submit'/>";
				
				echo "</form>";
			
		}
		if(isset($_POST["phase2"])){
			
			$br = $_POST["sub"];
		
		echo "<h3>Pass Comparision</h3><br>";	
		echo "	<table class='pieChart'>";
        for($i=0;$i<count($br);$i++){
			$n2 = $br[$i];
			$d2 = subReturn($n2,$tabname,$code,"pass");
			$r = mysql_query("select subname from $tabname where subcode = '$n2'");
			$x = mysql_fetch_array($r);
			$kddf = $x["subname"];
				echo "<tr><td>$kddf</td> <td>$d2</td></tr>";
		}
		
		echo "</table>" ;
		
		echo "<h3>Fail Comparision</h3><br>";
		echo "	<table class='pieChart'>";
        for($i=0;$i<count($br);$i++){
			$n2 = $br[$i];
			$d2 = subReturn($n2,$tabname,$code,"fail");
			$r = mysql_query("select subname from $tabname where subcode = '$n2'");
			$x = mysql_fetch_array($r);
			$kddf = $x["subname"];
				echo "<tr><td>$kddf</td> <td>$d2</td></tr>";
		}
		
		echo "</table>" ;
	
			
		}
	
}

else if($view == "filter"){
		
		if(!isset($_POST["phase1"]) && !isset($_POST["phase2"])){
			
				echo "<form action='' method='post'>";
				echo "<input type='number' class='inp' name='nbr'/>";
				echo "<input type='submit' name='phase1' value='Submit'/>";
				echo "</form>";

		}
		if(isset($_POST["phase1"]) ){
			$n = $_POST["nbr"];
			if($n!=0){
				$nj = $n-1;
				$x = $_POST["filsum"];
				echo $x;
				echo "<form action='' method='post'>";
				echo "<table id='filters'><th>Query String</th><th>Query Filter</th><th>Query Value</th><tr id='row0'><td id='barx0'><input type='text' id='bary0'></td><td id='filx0'><select onchange='displayQueryBar(\"barx0\",\"valx0\",this.value)' id='fils0' style='width:200'><option value='none'>--SELECT-- </option><option value='gt'>Greater Than \"&gt;\"</option><option value='lt'>Less Than \"&lt;\"</option><option value='gte'>Greater Than or Equal To '&gt;='</option><option value='lte'>Less Than or Equal To '&lt;='</option><option value='eq'>Equal To \"=\"</option><option value='neq'>Not Equal To '!='</option><option value='in'>In [List]</option><option value='nin'>Not In [List]</option><option value='like'>Like [RegExp]</option><option value='nlike'>Not Like [RegExp]</option></select></td><td id='valx0'><input type='text' id='valy0'>&emsp;<button type='button' class='btn' onclick='addFilter(0)' id='btn0'>Add</button></td></tr></table>";
				echo "<input type='hidden' id='filcount' name='filcount' value='1'></input>";
				echo "<input type='hidden' id='filsum' name='filsum' value='$x&'></input>";
				echo "<input type='hidden' value='$nj' class='inp' name='nbr'/>";
				echo "<input type='submit' name='phase1' value='Submit'/>";
				echo "</form>";
			}
			else{
				$x = $_POST["filsum"];
				echo $x."<br>";
				echo "<br><br><br>";
				$pon = explode("&",$x);
				//print_r($pon);
				echo "	<table class='pieChart'>";
				for($i=0;$i<count($pon);$i++){
					if($pon[$i]!=''){
						$n1 = getWhereClause($pon[$i]);
						$w = "Select * From $tabname Where ".$n1;
						$r = mysql_query($w);
						$d1 = mysql_num_rows($r);
						echo $w;
						echo " <tr><td>$n1</td> <td>$d1</td></tr>";
						
					}
				}
				echo "</table>";
			
			}
		}
	}

echo "</div>";	

function getSymbols($op){
		switch($op){
					case "Greater Than":return ">";
					case "Less Than":return "<";
					case "Greater Than Or Equal To":return ">=";
					case "Less Than Or Equal To":return "<=";
					case "In [List]":return "IN";
					case "Not In [List]":return "NOT IN";
					case "Not Like[RegExp]":return "NOT LIKE";
					case "Like [RegExp]":return "LIKE";
					case "Not Equal To":return "!=";
					case "Equal To":return "=";
					
				}
	
}
function getWhereClause($part){
		
		$a = explode(";",$part);
		
		for($i=0;$i<count($a);$i++)
		{
				$p = $a[$i];
				if($p!=""){
					
					$x = explode(":",$p);
					$s = $x[0];
					$f = $x[1];
					$v = $x[2];
					$symbol = getSymbols($f);
					$str[] =  "$s $symbol '$v'";
				}
			
		}
		
		return implode(" AND ",$str);
		

}
function subReturn($subcode,$tabname,$bcode,$pf){
		
		$result = mysql_query("select * from $tabname where subcode like '$subcode' and  (select srno REGEXP '......$bcode..') = 1 group by(srno)");
		//echo "select * from $tabname where subcode like '$subcode' and srno like '%$bcode%' and srno not like '%$bcode' group by(srno)";
		$data = array();
		$fail = 0;
		$pass = 0;
		for($i=0;$i<mysql_num_rows($result);$i++){
			$row = mysql_fetch_array($result);
			if($row["cre"] == 0)
				$fail++;
			else 
				$pass++;

		}
		if($pf == "pass")
			return $pass;
		else
			return $fail;
	
}

function subPlot($subcode,$tabname,$bcode){
		$result = mysql_query("select * from $tabname where subcode like '$subcode' and  (select srno REGEXP '......$bcode..') = 1 group by(srno)");
		//echo "select * from $tabname where subcode like '$subcode' and srno like '%$bcode%' and srno not like '%$bcode' group by(srno)";
		$data = array();
		$fail = 0;
		$pass = 0;
		for($i=0;$i<mysql_num_rows($result);$i++){
			$row = mysql_fetch_array($result);
			if($row["cre"] == 0)
				$fail++;
			else 
				$pass++;

		}
		
		plot($pass,$fail,"PASS","FAIL");
	
}


function plot($d1,$d2,$n1,$n2){
		echo "	<table class='pieChart'>
    
    <tr><td>$n1</td> <td>$d1</td></tr>
    <tr><td>$n2</td> <td>$d2</td></tr>
</table>" ;
}



function branchReturn($bcode,$tabname,$pf){
$result = mysql_query("select * from $tabname where (select srno REGEXP '......$bcode..') = 1 group by(srno)");
	//echo "select * from $tabname where (select srno REGEXP '......$bcode..') = 1 group by(srno)";
	$data = array();
	$past = "";
	$check = 0;
	$i = 0;
	$fail = 0;
	$pass = 0;
	if(mysql_num_rows($result) > 0){
		//echo "<h3><a href='?tabname=$tabname&view=branch&bcode=$bcode'>Branch - $bcode</h3><br><br>";
		for($i=0;$i<mysql_num_rows($result);$i++){
		$row = mysql_fetch_array($result);
		
				$current = $row["srno"];
				if($current != $past && $i!=0){
					if($check == 0){
						$pass++;
					}
					else
						$fail++;
					$check = 0;
				}
				if($row["cre"] == 0)
				$check = -1;
			
		}
			if($check == 0){
				$pass++;
			}
			else
				$fail++;
	if($pf == "pass")
		return $pass;
	else
		return $fail;
}
}



function branchPlot($bcode,$tabname){
	$result = mysql_query("select * from $tabname where (select srno REGEXP '......$bcode..') = 1 group by(srno)");
	//echo "select * from $tabname where (select srno REGEXP '......$bcode..') = 1 group by(srno)";
	$data = array();
	$past = "";
	$check = 0;
	$i = 0;
	$fail = 0;
	$pass = 0;
	if(mysql_num_rows($result) > 0){
		echo "<h3><a href='?tabname=$tabname&view=branch&bcode=$bcode'>Branch - $bcode</h3><br><br>";
		for($i=0;$i<mysql_num_rows($result);$i++){
		$row = mysql_fetch_array($result);
		
				$current = $row["srno"];
				if($current != $past && $i!=0){
					if($check == 0){
						$pass++;
					}
					else
						$fail++;
					$check = 0;
				}
				if($row["cre"] == 0)
				$check = -1;
			
		}
			if($check == 0){
				$pass++;
			}
			else
				$fail++;
	plot($pass,$fail,"ALL CLEAR","FAIL");
	return 1;
	}

	return 0;
	
}
?>
