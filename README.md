# growTENT
Grow Tracker of Everything Non-Trivial

Recommended setup using auto-updating: https://www.portent.com/blog/design-dev/github-auto-deploy-setup-guide.htm

Configuration in tpl/config.php, tpl/sql.php and tpl/auth.php , rename auth-example.php and sql-example.php for examples
You'll also want to create "uploads", "qrcodes" and "backups" directories

## Installation
These instructions have been based around a DigitalOcean VPS, but should work similarly with Vultr, SiteHost etc

### Virtual Private Server creation

Start by creating a new VPS by choosing Create -> Droplet:

![image](https://github.com/Chill-Division/growTENT/assets/162461/d74181ae-1438-4b33-a970-c98803b24d28)

Choose your location closest to you, select Ubuntu 24.04 LTS to install, and then select the cheapest / most cost-effective option there is:

![image](https://github.com/Chill-Division/growTENT/assets/162461/524b829e-4358-4edc-83a5-d83a36ed3c48)

Enter your desired password (or select your SSH key), and click on "Create Droplet". You can optionally enable backups if you wish, though there is a backup function inside of GrowTENT

After a brief wait while it is created, you can choose "More -> Access Console", or alternatively log in through SSH if you are familiar with the process.

Now jot down the IPv4 address for eth0 that is provided. This will need to be setup by your domain / website provider as an A-record similar to growtent.yourdomain.co.nz

### Basic server setup

We first want to install nginx, php and mariadb-server as prerequisites, you can do this by copy and pasting:

<pre>apt-get install nginx mariadb-server php-fpm php-mysql</pre>

Next we want to enable SSL for secure access, which will be done with:

<pre>snap install --classic certbot && ln -s /snap/bin/certbot /usr/bin/certbot</pre>

If you have provided your IP address to your domain / website registrar (and they have setup the A-record DNS entry for you), then you should be ready to obtain the SSL certificate with:

<pre>certbot --nginx</pre>

Follow the prompts and enter the domain that has been setup for you when requested, such as growtent.yourdomain.co.nz

Next we will enable php from nginx. Start with:

<pre>nano -w +44 /etc/nginx/sites-enabled/default</pre>

Add "index.php" to the end of the line as instructed:

![image](https://github.com/Chill-Division/growTENT/assets/162461/0fc27daf-2f11-4450-91a5-d49d9d2f627f)

Next modify the php settings by removing the applicable hashes as shown, and changing the fastcgi_pass path too:

![image](https://github.com/Chill-Division/growTENT/assets/162461/54bc2d72-9150-4eae-ab33-d82a49aa98fa)

You will also need to scroll further down and repeat this under the SSL / Port 443 section.

Ctrl + X, Y, <enter> to save and quit. Test that the syntax is OK with:

<pre>nginx -t</pre>

If successful run:

<pre>systemctl reload nginx</pre>

### Database setup

We now need to make a database for it to use. Start with:

<pre>mariadb</pre>

Then run:

<pre>CREATE DATABASE growTENT;</pre>

Next, you'll need to modify this when you copy / paste it to have your own growtent user and password. We suggest choosing a strong password, as this is only ever used once during the setup process and so you won't need to memorize it:

<pre>CREATE USER 'growtent'@'%' IDENTIFIED BY 'P@ssw0rd';</pre>

Replacing the "P@ssw0rd" part specifically. If you need a password suggestion, use The [Bitmill Random Password Generator](https://www.thebitmill.com/tools/password.html)

Then provide access to your newly created "growtent" user to the database:

<pre>GRANT ALL PRIVILEGES ON *.* TO 'growtent'@localhost IDENTIFIED BY 'P@ssw0rd';</pre>

Again changing the password to whatever you previously set it to. Then to exit, run:

<pre>\q</pre>

### GrowTENT configuration

Next we need to set up GrowTENT configuration and connect it to the database we just made.

We'll start by removing the demo files from nginx that we no longer need:

<pre>rm -rf /var/www/html/*</pre>

And then copy the GrowTENT code:

<pre>git clone https://github.com/Chill-Division/growTENT.git /var/www/html/</pre>

Run the following command to copy all of the example configuration files:

<pre>cd /var/www/html/tpl/ && cp config-example.php config.php && cp auth-example.php auth.php && cp sql-example.php sql.php</pre>

Edit the SQL configuration with:

<pre>nano -w sql.php</pre>

Changing the username / password / server details as follows:

![image](https://github.com/Chill-Division/growTENT/assets/162461/2761a872-330c-4e30-8bab-9fbc287c244a)

Setting your password as you did previously.

Next we'll import the database structure with:

<pre>mariadb growtent < /var/www/html/structure.sql</pre>

Next we'll setup the main configuration:

<pre>nano -w config.php</pre>

Change the domainURL and installdir as follows:

![image](https://github.com/Chill-Division/growTENT/assets/162461/fca76ac9-ee85-4577-9713-9a6918460986)

And change your Escorting Staff names too if you'll be using this to track guest access.

Lastly, the authentication is very basic, edit your auth.php file and set some valid passwords:

<pre>nano -w auth.php</pre>

You should now be ready to visit growtent.yourdomain.co.nz/admin.php and be ready to log in.
