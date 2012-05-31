<?php

                function dbproc($results,$table)
                {
                	$key =  substr($_COOKIE['keymas'],0,16);
                    $cryptox = new Crypto($key);
                   	//echo count($results);
                	for($i=0;$i<count($results);$i++)
                	{
                		$q = "insert into ".$table." values(\"";
                		for($j=0;$j<count($results[$i]);$j++)
                		{
		                		
                			$valx = utf8_decode($results[$i][$j]);
                			$val = mysql_aes_decrypt($valx, $key);
                			
                			if($j == count($results[$i])-1)
                				$q .= $val."\"";
                			else
                				$q .= $val."\",\"";
                		
                		}	
                		
                		mysql_query($q.")");
                	}	
                	echo "&emsp;<h2>Rows : ".$i."</h2>";
                }
                function createTable($table)
                {
                	
                	require_once 'connectioncli.php';
                	mysql_query("create table ".$table." (srno text,sname text,subcode text,subname text,intm text,extm text,cre text)");
                	
                }
				function insertResult($resname,$table)
                {
                	require_once 'connectioncli.php';
                	//echo "insert into MRESULTT values(\"".$table."\",\"".$name."\")";
                	mysql_query("insert into MRESULTT values(\"".$table."\",\"".$resname."\")");

                }
                
                function mysql_aes_decrypt($val,$ky) 
				{ 
    				$key="\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0"; 
    				for($a=0;$a<strlen($ky);$a++) 
      					$key[$a%16]=chr(ord($key[$a%16]) ^ ord($ky[$a])); 
    				$mode = MCRYPT_MODE_ECB; 
    				$enc = MCRYPT_RIJNDAEL_128; 
    				$dec = @mcrypt_decrypt($enc, $key, $val, $mode, @mcrypt_create_iv( @mcrypt_get_iv_size($enc, $mode), MCRYPT_DEV_URANDOM ) ); 
    				return rtrim($dec,(( ord(substr($dec,strlen($dec)-1,1))>=0 and ord(substr($dec, strlen($dec)-1,1))<=16)? chr(ord( substr($dec,strlen($dec)-1,1))):null)); 
				} 
                
function authorize($string){
  if(array_key_exists("auth",$_COOKIE)){

    	//echo $_COOKIE["auth"];
	$pbkdf2 = new PBKDF2();
	$key = $pbkdf2->deriveKey($string);
	$crypto = new Crypto($key);
	$c = $crypto->aesDecrypt($_COOKIE["auth"]);
	if($c != $string)
		echo "<script type='text/javascript'>window.location='auth.php?goto=$string'</script>";
    }
    else
	 echo "<script type='text/javascript'>window.location='auth.php?goto=$string'</script>";
}

class Crypto {

    public function __construct($key) {
             
        include_once("aes/AES.class.php");
        $this->aes = new AES($key);
        $this->key = $key;
    }

    public function aesEncrypt($contents) {
       
        $data = $contents;
        $aes = $this->aes;
        return $aes->encrypt($data);
    }

    public function aesDecrypt($contents) {
        
        $data = $contents;
        $aes = $this->aes;
        return $aes->decrypt($data);
    }

}


class PBKDF2 {

    public function __construct() {
        $this->salt = "12345678";
        $this->iterations = 2000;
        $this->keyLen = 32;
    }

    public function deriveKey($p) {

        return substr(strtoupper($this->strToHex($this->pbkdf2($p, $this->salt, $this->iterations, $this->keyLen, 'sha1'))),0,32);
    }

     function pbkdf2($p, $s, $c, $kl, $a = 'sha256', $st=0) {
        $kb = $st + $kl;                        // Key blocks to compute 
        $dk = '';                                    // Derived key 

        for ($block = 1; $block <= $kb; $block++) {

            $ib = $h = hash_hmac($a, $s . pack('N', $block), $p, true);


            for ($i = 1; $i < $c; $i++) {

                $ib ^= ($h = hash_hmac($a, $h, $p, true));
            }

            $dk .= $ib;                                // Append iterated block 
        }


        return substr($dk, $st, $kl);
    }
    function strToHex($string) {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }


}
function strToHex($string) {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }
function hexToStr($string) {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= hexdec($string[$i]) ;
        }
        return $hex;
    }

class pJSON
{
    
    public static function getJSON($array)
    {
        
        $json = json_encode($array);
        return $json;
        
    }
    public static function getParam($json,$param,$decode = "false")
    {
        if($decode == "true")
        {
            $x = json_decode($json);
            return utf8_decode($x->$param);
            
        }
        else
            return $x->$param;
        
    }
    
}
class Operator{
	
		public function phase1($username,$passphrase){
			
			$challenge=uniqid();
			$x=$username.$passphrase;
		
			$pbkdf2 = new PBKDF2();
			$key = $pbkdf2->deriveKey($x);
			$keymas = $pbkdf2->deriveKey($key.":".$challenge);
			$crypto = new Crypto($keymas);
			require_once "settings.php";
			$url = getSHOST()."?mode=handshake&values=".$username.":".$challenge;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        	curl_setopt($ch, CURLOPT_REFERER, "www.google.com");
        	$body = curl_exec($ch);
        	$json = json_decode($body);
			$emsg = utf8_decode($json->message);
			$token = $crypto->aesDecrypt(utf8_decode($json->token));
			$plain = $crypto->aesDecrypt($emsg);
			$pl = $plain;
			
			if($pl == "Standard Message#1")
        	{
				
			setcookie("username",$username);
			setcookie("passphrase",$passphrase);
			setcookie("key",$key);
			setcookie("keymas",$keymas);
			setcookie("token",$token);
			echo "<script type='text/javascript'>window.location = \"phase2.php\";</script>";
			
			}
			else
			{
				//redirect("?err=true");
			}
		}
		
	
	function redirectTo($location){
		echo "Hello";
		
		
	}
}
?>
