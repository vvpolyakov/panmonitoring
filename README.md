Panmonitoring
=============

Simple servers monitoring tool


#Installation

##Get panmonitoring
````bash
cd /path_to_WWW_dir
git clone https://github.com/vvpolyakov/panmonitoring.git
````

##Install PHP Bindings for libssh2
````bash
apt-get install libssh2-php
````

##Configure panmonitoring
edit settings.php file

##Create and copy SSH keys to monitored servers
create key on localhost
````bash
ssh-keygen
````

copy key to remote server
````bash
ssh-copy-id login@10.10.10.10
````

##Configure crontab
add check.php to cron, 1 time per hour
example
````
0 * * * * /usr/bin/php /PATH_TO_PANMONITORING/check.php
````


