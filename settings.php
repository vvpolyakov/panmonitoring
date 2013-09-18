<?

/*
$services=array(
    name1 => command1,
    name2 => command2,
    etc...
);
*/
$defaultMax = 94;

$services=array(
"Hostname"=>array("cmd"=>"hostname"),
"Uptime"=>array("cmd"=>"uptime | sed 's/,.*//' | sed 's/.*up //'"),
"CPU"=>array("cmd"=>"top -bn1 | awk '/^Cpu/ {printf(\"%s %s\",$2,$6)} /^%Cpu/ {printf (\"%s%%us %s%%wa\",$2,$10)}'","max"=>95),
"Mem"=>array("cmd"=>"awk 'BEGIN {} /^Mem/ {total=$2} /buffers/ {used=$3} END {printf(\"%u%%\", 100*used/total);}' <(free -m)","max"=>20),
"Swap"=>array("cmd"=>"awk '/^Swap/ {printf(\"%u%%\", 100*$3/$2);}' <(free -m)","max"=>90),
"HDD"=>array("cmd"=>"df -h | awk '/\// {printf(\"%s - %u%% (%s из %s)\\n\",$1,$5,$3,$2)}' | grep '/dev'","max"=>80)
);


$functions_1min=array(
"HTTP status"=>"http"
);


$email="alarm@spam.su";

/*
$servers=array(
    hostname1  => array("login"=>"login1"),
    hostname2  => array("login"=>"login1","email"=>"email-for-notify-only-this@server.com")
    etc...
);
*/
$servers=array(
    "localhost"=>array("login"=>"root")
    //,"server.com"=>array("login"=>"root","email"=>"email2@spam.su")
);

/*
    to generate keys use `ssh-keygen` command
    to copy keys to remote servers use `ssh-copy-id` command
*/

$pubkey = "/root/.ssh/id_rsa.pub";
$privkey = "/root/.ssh/id_rsa";

?>