###################
CRUD Operation using CodeIgniter 3
###################

CREATE/EDIT/DELETE employees records, the list is limited to ten records and maximum 4 records assigned per job role

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.


************
Installation
************
1. Import database nineXB.sql in phpmyadmin
2. Have Apache mod_rewrite enabled
3. Update .htacces file if required
4. Update config files:
	application/config/database.php
		-your database host (localhost:3306 is the default usually)
		-username / password
	application/config/config.php
		-Update the base_url with your localhost:port number for Apache
