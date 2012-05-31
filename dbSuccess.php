
<html>
    <head>
      <script type = "text/javascript" >
function disableBackButton()
{
window.history.forward();
}

</script>
        <link href="css/uni-form.css" media="screen" rel="stylesheet"/>
    <link href="css/default.uni-form.css" title="Default Style" media="screen" rel="stylesheet"/>
    <link href="./css/demo.css" media="screen" rel="stylesheet"/>
    </head>
    <body onload="disableBackButton()">
          <center>
    <table cellpadding=10><tr><td><a href="http://jntu.ac.in/" target="_blank" title="JNTU"><img src="images/jntulogo.jpg" alt=""/><img src="Portcullisimage.png" alt=""  width='100' height="100"/>&emsp;</a></td>
    <td><h2>
      Jawaharlal Nehru Technological University Hyderabad<br>
      Kukatpally,Hyderabad - 500 085, Andhra Pradesh, India</h2></td></tr></table></center>
    
<?php
include("lib/lib.php");
    echo "<form action='#' class='uniForm' method='post'>";
    notify("Data Deleted Successfully");
     echo "<a href='resulthome.php' title='Return to the home page'>&laquo; Go home</a>
     <a href='manageDB.php' title='Delete More data' class='link'>&laquo; Go Back</a>";
    ?></form>
     <div id="footer">
      Jawaharlal Nehru Technological University Hyderabad
      Kukatpally, Hyderabad - 500 085, Andhra Pradesh, India
    </div>
    </body>
    </html>
