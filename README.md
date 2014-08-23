# TWplan
### The advanced Trbialwars mass-attack planning tool.


## Directory Structure
- **app** contains the twplan PHP app, built with the CakePHP framework
- **lib** contains associated libraries for the app (currently only the cakephp submodule)
- **static-twplan** contains static files for the CDN
- **index.php** is the base PHP file which proxies incoming requests to Cake
- **twplan_config.php** holds environment details for local and prod development

## Add New World Data
- Add a record to the `worlds` table so it's picked up by the database loading scripts
- Update `controllers/header.js` and `controllers/settings.js` with the new world number
- Update `factories/world_info.js` with the world speed data

## Local Dev
- Configure Apache to serve the twplan directory from localhost
- Start MySQL server: `mysql.server start`

## Remote Dev (AWS)
- Spin up an EC2 instance with Amazon-flavor linux
- SSH into the instance
- Set up the stack
    - `sudo yum update`
    - `sudo yum remove php-common-5.3.28-1.5.amzn1.x86_64` remove php53
    - `sudo yum install php54`
    - `sudo yum install php54-pdo`
    - `sudo yum install mysql`
    - `sudo yum install php-mysql`
    - `sudo yum install httpd24 && sudo service httpd start` (should see generic Apache page)
- Git stuff
    - `sudo yum install git`
    - Create a new SSH key and add to GitHub
    - `cd ~ && git clone git@github.com:mattdahl/twplan.git`
- Configure Apache
    - `vim /etc/httpd/conf/httpd.conf`
    - Set `DocumentRoot "/home/ec2-user/twplan/app"`
    - Set `<Directory "/home/ec2-user/twplan/app">`
    - Set `AllowOverride All`
    - Update privs
        - `sudo chgrp -R apache /home/ec2-user/`
        - `chmod -R 2750 home/ec2-user/`
    - Restart: `sudo service httpd restart`
- Pull in Cake
    - `git submodule init`
    - `git submodule update` (may have to clone over HTTPS)
- Spin up a RDS instance with mySQL
    - Login: `mysql -h SUBDOMAIN.rds.amazonaws.com --port 3306 -u twplan_admin -p`
    - `CREATE DATABASE twplan;`
    - `USE twplan;`
    - Add the table schemas: `source PATH/TO/SCHEMA;` (located in app/Config/Schema/schemas)
    - `SHOW TABLES;` to double-check
- Edit `twplan_config.php` with the appropriate environment settings

## CDN
- Files are managed in `static-twplan` using GoogleAppEngine
- Open the GoogleAppEngineLauncher app and click Deploy on the static-twplan application to update the CDN
