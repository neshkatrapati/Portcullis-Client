
<html>
<head>
<link href="css/uni-form.css" media="screen" rel="stylesheet" />
<link href="css/default.uni-form.css" title="Default Style"
	media="screen" rel="stylesheet" />
<link href="css/demo.css" media="screen" rel="stylesheet" />

</head>
<?php require_once 'connectioncli.php'; ?>
<body>
<center>
<table cellpadding='20px'>
	<tr>
		<td><a href="http://jntu.ac.in/" title="JNTU"><img
			src="Portcullisimage.png" alt="" width='100' height="100" />&emsp;<img
			src="images/jntulogo.jpg" alt="" /></a>&emsp;</td>
		&emsp;
		<td>&emsp;
		<h2>Jawaharlal Nehru Technological University Hyderabad<br>
		Kukatpally,Hyderabad - 500 085, Andhra Pradesh, India</h2>

		<h2><?php echo COLLEGENAME; ?></h2>
		</td>
	</tr>
</table>
</center>
<center><?php

$q = mysql_query("select * from MRESULTT where rtabname like '".$_GET["resid"]."'");
$row = mysql_fetch_array($q);
$resname = $row["rname"];
echo "<h3>".$resname."</h3>";
echo "<form action='?resid=".$_GET["resid"]."' class='uniForm' method='post'>";?>
<fieldset>
<h3>Enter Your Roll Number</h3>

<div class="ctrlHolder">Rollnumber :&emsp;<input name="srno" id="name"
	data-default-value="Rollnumber" style='display: inline;' size="15"
	maxlength="50" type="text" class="textIn" required='true' "/> Search
By:&nbsp;<input name='type' type='radio' checked value='roll'
	style='display: inline;'>Roll Number</input><input name='type'
	type='radio' value='name' style='display: inline;'>Name</input></div>
</fieldset>
<?php
if(isset($_POST["phase1"]) || $_GET["srno"]!="")
{
	$type = $_POST["type"];
	if($type == "roll" || $_GET["srno"]!="")
	{
		$srno = $_REQUEST["srno"];
		//echo "Hello";
		$q = mysql_query("select * from ".$_GET["resid"]." where srno like '".$srno."'");
		$q2 = mysql_query("select * from ".$_GET["resid"]." where srno like '".$srno."'");
		$row = mysql_fetch_array($q2);
			
		$name = $row["sname"];
		$srno = $row["srno"];
			
		echo "<table class='bttable blue'>";
		echo "<tr><td>Roll Number</td><td>".$srno."</td></tr>";
		echo "<tr><td>Name</td><td>".$name."</td></tr>";
		echo "</table>";
			
		echo "<table class='bttable blue'>";
		echo "<th class='purple'>Subject</th>";
		echo "<th class='purple'>Internals</th>";
		echo "<th class='purple'>Externals</th>";
		echo "<th class='purple'>Totals</th>";
		echo "<th class='purple'>Credits</th>";
		echo "<tbody class='zebra-striped'>";
		$tott = 0;
		$tote = 0;
		$toti = 0;
		$totc = 0;
		while($row = mysql_fetch_array($q))
		{
			echo "<tr>";
			echo "<td>".$row["subname"]." </td>";
			echo "<td>".$row["intm"]." </td>";
			$tote += $row["extm"];
			$toti += $row["intm"];
			$totc += $row["cre"];
			echo "<td>".$row["extm"]." </td>";
			$tott += ($row["intm"]+$row["extm"]);
			echo "<td>".($row["intm"]+$row["extm"])."</td>";
			echo "<td>".$row["cre"]." </td>";
			echo "</tr>";

		}
		echo "<tr>";
		echo "<td>TOTALS</td>";
		echo "<td>".$toti." </td>";
		echo "<td>".$tote." </td>";
		echo "<td>".$tott." </td>";
		echo "<td>".$totc." </td>";
		echo "</tr>";
		echo "</tbody></table>";
	}
	else if($type == "name")
	{

		$q = mysql_query("select distinct(sname) from ".$_GET["resid"]." where sname like '%".$_POST["srno"]."%'");
		echo "<br><table class='bttable' style='text-align:center;width:70%'>";
		echo "<th>Rollnumber</th>";
		echo "<th>Name</th>";
		while($row = mysql_fetch_array($q))
		{
			$q2 = mysql_query("select distinct(srno) as srno from ".$_GET["resid"]." where sname like '".$row["sname"]."'");
			$x = mysql_fetch_array($q2);
			$snro = $x["srno"];

			echo "<tr><td>".$snro."</td><td><a href='?resid=".$_GET["resid"]."&srno=".$snro."'>".$row["sname"]."</a></td></tr>";

		}
		echo "</table>";
	}
}
?>

<div class="buttonHolder" style='text-align: left;'><?php  ?>
<button type="submit" class="primaryAction" name='phase1'>Submit</button>
<?php ?> <a href='resulthome.php' title='Return to the previous page'
	class='link'>&laquo; Go Home</a></div>
</form>
</center>
<div id="footer">
<h2>Jawaharlal Nehru Technological University Hyderabad Kukatpally,
Hyderabad - 500 085, Andhra Pradesh, India</h2>
<h2></h2>
</div>
</body>
</html>
