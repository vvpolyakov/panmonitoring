Panmonitoring
=============

Simple linux servers monitoring tool

updates:
07.09.2013 - Email notifications if ("%" >= 80) AND (previous "%" < 80)

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

##Advanced info
* Each pixel column on the graph is a 1 hour, each graph contains the information for 48 hours
* To draw graphs commands must return numeric values in percent. 0% - good, 100% - bad
* Values greater than 80% are displayed in red

![ScreenShot](http://dasich.panweb.com/app/file/696183809.jpg)
