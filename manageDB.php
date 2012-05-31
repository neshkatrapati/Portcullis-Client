<html lang="en-us" dir="ltr">
  <head>
  <meta charset="utf-8">
    <title>Manage Database</title>
    <script type='text/javascript'> 
		function check()
		{
        if (document.getElementById("master").checked == true){
			var state = true;
		}
		else{
			var state = false;
		}
		var inputs = document.getElementsByTagName("input");
		var checkboxes = [];
		for (var i = 0; i < inputs.length; i++) {
          if (inputs[i].type == "checkbox") {
			inputs[i].checked = state;
				}
			}
		
		}
    
    </script>
   
    <link href="css/uni-form.css" media="screen" rel="stylesheet"/>
    <link href="css/default.uni-form.css" title="Default Style" media="screen" rel="stylesheet"/>
    <link href="css/demo.css" media="screen" rel="stylesheet"/>
    <script type="text/javascript" src="../lib/jquery.js"></script>
    </head>
    <body>
    <center>	
  <table cellpadding=10><tr><td><a href="http://jntu.ac.in/" target="_blank" title="JNTU"><img src="images/jntulogo.jpg" alt=""/><img src="Portcullisimage.png" alt=""  width='100' height="100"/>&emsp;</a></td>
    <td><h2>
      Jawaharlal Nehru Technological University Hyderabad<br>
      Kukatpally,Hyderabad - 500 085, Andhra Pradesh, India</h2></td></tr></table></center>
    <div id='topper'></div>
    <?php
    include("lib/lib.php");
    include("connectioncli.php");
  	require_once 'classes.php';
	authorize("manageDB");
    if(!isset($_POST['phase1'])){
    ?>
   
    <form action="#" class="uniForm" method='post'>
      <fieldset>
        <h3>Manage Database</h3>
        <label for=""><h4><em>*</em>Select The data to be deleted</h4></label>
        <?php
            echo "<table>";
            $result=mysql_query("select * from MRESULTT");
            $num=mysql_num_rows($result);
            if($num==0)
            {
              echo "<br>-------No Data Available-------";
            }
            else{
				echo "<tr><td><input type='checkbox' id='master' onclick='check()'></input></td><td>Check/Uncheck All</td></tr>";
				while($res=mysql_fetch_array($result))
				{
					echo "<tr>";
					$rname=$res['rname'];
					$rtabname=$res['rtabname'];
					echo "<td><input type='checkbox' name='rtabname[]' value='$rtabname'></td>";
					echo "<td>$rname</td>";
					echo "</tr>";
                
				}
			}
            echo "</table>"; ?>
            
         </div>
             </fieldset>
      
      <div class="buttonHolder" style='text-align:left;'>
        <?
        if($num!=0)
        {?>
         <button type="submit" class="primaryAction" name='phase1' value='Delete Data'>Submit</button>
        <?}?>
        
                <a href='phase1.php' title='Return to the Home page' class='link'>&laquo; Go Home</a>
                
      </div>

    </form>   
      
    <?}
   if(isset($_POST['phase1']))
        {
            $rtabname=$_POST['rtabname'];
            $len = count($rtabname);
            for($i=0;$i<$len;$i++)
            {
                $tab=$rtabname[$i];
                mysql_query("delete from MRESULTT where rtabname='$tab'") or die(mysql_error());
                mysql_query("drop table $tab") or die(mysql_error());
                
            }
            
          redirect("dbSuccess.php");
        } 
    
    
    
    ?>
            
          
       
                
    <div id="footer">
      Jawaharlal Nehru Technological University Hyderabad
Kukatpally, Hyderabad - 500 085, Andhra Pradesh, India
    </div>
    </fieldset>
     </body>
</html>        
