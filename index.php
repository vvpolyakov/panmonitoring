<html>
<head>
<style>
.graf {
    bottom:0px;
    position:absolute;
}
.grafcontainer {
    position:relative;
    margin:3px;
    float:left;
    vertical-align:bottom;
    width:50px;
    height:25px;
    border:1px solid #ccc;
}
</style>
<body>

<?
    header("Content-type: text/html;charset=UTF-8");
    require("settings.php");
    
    $services = array_merge($services,$functions_1min);

    $date = date_create("now");
    $f = fopen ("data/".date_format($date,"Ymd-H"),"r");
    $j = fgets($f);
    $o = json_decode($j);
    fclose ($f);

    for ($i=0;$i<48;$i++) {
	
	$f = fopen ("data/".date_format($date,"Ymd-H"),"r");
	$j = fgets($f);
	$oh = json_decode($j);
	foreach ($servers as $host=>$login) {
	    foreach ($services as $serv=>$cmd) {
		$o->{$host}->{$serv."-history"}[] = $oh->{$host}->{$serv};
	    }
	}
	fclose ($f);
	date_add($date,date_interval_create_from_date_string("-1 hour"));

    }

    
    print "<table><tr><th>Host</th>\n";
    foreach ($services as $name=>$cmd) {
	print "<th>$name</th>";
    }
    print "</tr>\n";
    
    foreach ($servers as $host=>$login) {
	print "<tr><td>$host</td>";
	foreach ($services as $serv=>$cmd) {
	    $o->{$host}->{$serv} = preg_replace_callback("/([\d\.]+)%/", function ($p){
		if ($p[1]>$defaultMax)
		    return "<font style='font-weight:bold;color:red;font-size:150%'>$p[1]%</font>";
		else
		    return $p[1]."%";
	    } , $o->{$host}->{$serv});
	    print "<td><pre>".$o->{$host}->{$serv}."</pre></td>";
	}
	print "</tr>\n";
	print "<tr><td></td>";
	foreach ($services as $serv=>$cmd) {
	    print "<td valign=\"bottom\">";
	    $graf=array();
	    $num=0;
	    foreach($o->{$host}->{$serv."-history"} as $h) {
		if (preg_match_all("/((\d+\.)?\d+)\%/",$h,$number)) {
		    for ($i=0;$number[1][$i] != NULL;$i++) {
			//$graf[$i] = "<div class=\"graf\" style=\"height:".($number[1][$i]/4)."px\"></div>";
			$graf[$i] .= "<img style=\"right:".$num."px\" class=\"graf\" src=\"data:image/gif;base64,R0lGODlhAQABAIAAAAUEBAAAACwAAAAAAQABAAACAkQBADs=\" width=1 height=".($number[1][$i]/4).">";
		    }
		}
		$num++;
	    }
	    foreach ($graf as $g) {
		print "<div class=\"grafcontainer\">$g</div>";
	    }
	    print "</td>";
	}
	print "</tr>\n";
	
    }
    
    print "</table>";
    
?>
</body>
</html>