<?

/*
$services=array(
    name1 => command1,
    name2 => command2,
    etc...
);
*/
$services=array(
"Hostname"=>"hostname",
"Uptime"=>"uptime | sed 's/,.*//' | sed 's/.*up //'",
"CPU"=>"top -bn1 | awk '/^Cpu/ {printf(\"%s %s\",$2,$6)} /^%Cpu/ {printf (\"%s%%us %s%%wa\",$2,$10)}'",
"Mem"=>"awk 'BEGIN {} /^Mem/ {total=$2} /buffers/ {used=$3} END {printf(\"%u%%\", 100*used/total);}' <(free -m)",
"Swap"=>"awk '/^Swap/ {printf(\"%u%%\", 100*$3/$2);}' <(free -m)",
"HDD"=>"df -h | awk '/\// {printf(\"%s - %u%% (%s из %s)\\n\",$1,$5,$3,$2)}' | grep '/dev'"
);


$functions_1min=array(
"HTTP status"=>"http"
);


$email="alarm@spam.su";

/*
$servers=array(
    hostname1  => login1,
    hostname2  => login2
    etc...
);
*/
$servers=array(
    "localhost"=>"root"
);

/*
    to generate keys use `ssh-keygen` command
    to copy keys to remote servers use `ssh-copy-id` command
*/

$pubkey = "/root/.ssh/id_rsa.pub";
$privkey = "/root/.ssh/id_rsa";

?>