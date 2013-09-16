<?
require("settings.php");

if (!is_dir(__DIR__."/data")) {
    mkdir(__DIR__."/data");
}
$date = date_create("now");
$f = fopen (__DIR__."/data/".date_format($date,"Ymd-H"),"r");
if (!$f) exit;
$j = fgets($f);
fclose($f);
$o = json_decode($j);

$date1h = date_create("now");
date_add($date1h,date_interval_create_from_date_string("-1 hour"));
$f1h = fopen (__DIR__."/data/".date_format($date1h,"Ymd-H"),"r");
$j1h = fgets($f1h);
fclose($f1h);
$o1h = json_decode($j1h);

$result = array();

foreach ($servers as $host=>$login) {
    foreach ($functions_1min as $name=>$fn) {
	if (!is_string($o1h->{$host}->{$name})) $o1h->{$host}->{$name} = "";
	if (!is_string($o->{$host}->{$name})) $o->{$host}->{$name} = "";
	$prev = substr($o1h->{$host}->{$name}.$o->{$host}->{$name}, -1);
	$result = call_user_func($fn['cmd'],$host);
	$o->{$host}->{$name} .= $result;
	if ($result == 0 && "$prev" !== "$result") {
	    print "ALARM!!!!!!!!!!!!!!!!!!!\n";
	    mail($email,"ALARM! $host - $name","ALARM! $host - $name");
	} 
    }
}


$f = fopen (__DIR__."/data/".date_format($date,"Ymd-H"),"w");
fprintf($f,"%s",json_encode($o));
fclose($f);

function ping($srv) {
    
}

function http($srv) {
    if( $curl = curl_init() ) {
	curl_setopt($curl, CURLOPT_URL, 'http://'.$srv."/");
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_NOBODY, 1);
	curl_setopt($curl, CURLOPT_HEADER, 1);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_USERAGENT, "panmonitoring ping bot");
	$out = curl_exec($curl);
//	print "-----------$out ";
	curl_close($curl);
	if (preg_match("/200 OK/",$out)) return 1;
	else return 0;
    }
    return "#";
}
?>