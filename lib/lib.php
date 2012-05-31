<?php
function notify($text)
	{
		
		echo "
		<div id='okMsg'  >
		<p> $text  </p></div>";
	}
	function notifyerr($text)
	{
		
		echo "
		<div id='errorMsg'>
		<p> $text  </p></div>";
	}
	function notifywar($text)
	{
		
		echo "
		<div id='warMsg'>
		<p> $text  </p></div>";
	}
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
	function redirectDel($location)
	{
		echo "
		<script type='text/javascript'>
			setTimeout('delayer()',0);
			function delayer(){
			window.location = '".$location."';
			}
		</script>
		";
		
	}
	function check($checker)
	{
		echo "
		<script type='text/javascript'>
			alert($checker)
		</script>
		";
		
	}
	 function validateURL($url)
      {
        $pattern = '/^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&amp;?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/';
        return preg_match($pattern, $url);
      }
	function goBack()
	{
		 echo "<a href='javascript:history.go(-1)' title='Return to the previous page'>&laquo; Go back</a>";
	}
?>