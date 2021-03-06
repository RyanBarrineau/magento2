<h2>Welcome</h2>
The installation instructions that used to be here are now published on our GitHub site. Use the information on this page to get started or go directly to the <a href="http://devdocs.magento.com/guides/v2.0/install-gde/bk-install-guide.html" target="_blank">guide</a>.

<h2>Step 1: Verify your prerequisites</h2>

Use the following table to verify you have the correct prerequisites to install the Magento software.

<table>
	<tbody>
		<tr>
			<th>Prerequisite</th>
			<th>How to check</th>
			<th>For more information</th>
		</tr>
	<tr>
		<td>Apache 2.2 or 2.4</td>
		<td>Ubuntu: <code>apache2 -v</code><br>
		CentOS: <code>httpd -v</code></td>
		<td><a href="http://devdocs.magento.com/guides/v2.0/install-gde/prereq/apache.html">Apache</a></td>
	</tr>
	<tr>
		<td>PHP 5.6.x</td>
		<td><code>php -v</code></td>
		<td><a href="http://devdocs.magento.com/guides/v2.0/install-gde/prereq/php-ubuntu.html">PHP Ubuntu</a><br><a href="http://devdocs.magento.com/guides/v2.0/install-gde/prereq/php-centos.html">PHP CentOS</a></td>
	</tr>
	<tr><td>MySQL 5.6.x</td>
	<td><code>mysql -u [root user name] -p</code></td>
	<td><a href="http://devdocs.magento.com/guides/v2.0/install-gde/prereq/mysql.html">MySQL</a></td>
	</tr>
</tbody>
</table>

<h2>Step 2: Prepare to install</h2>

After verifying your prerequisites, perform the following tasks in order to prepare to install the Magento software.

1.	<a href="http://devdocs.magento.com/guides/v2.0/install-gde/install/composer-clone.html#instgde-prereq-compose-install">Install Composer</a>
2.	Clone Repository: ```git clone git@github.com:BlueAcornInc/magento2ee.git```
3.	Install Dependencies: ```composer install```
4.	Set Permissions: ```sudo find . -type d -exec chmod 770 {} \; && sudo find . -type f -exec chmod 660 {} \; && sudo chmod +x bin/magento```
5.	Import DB:
	* Option 1 - Clean Install: ```./bin/magento setup:install --base-url=http://magento2.dev 
--backend-frontname=admin --db-host=localhost --db-name=magento2 --db-user=@@db_user --db-password=@@db_password --admin-firstname=@@firstname --admin-lastname=@@lastname --admin-email=@@email --admin-user=@@admin_user --admin-password=@@admin_password --language=en_US --currency=USD --timezone=America/New_York --use-rewrites=1```
7.	Install sample data if none eists ```./bin/magento sampledata:deploy```
8.	Run Setup Upgrade ```./bin/magento setup:upgrade```
9.	Set Permissions ```sudo find . -type d -exec chmod 770 {} \; && sudo find . -type f -exec chmod 660 {} \; && sudo chmod +x bin/magento```
9.	Clear Cache ```./bin/magento cache:flush```
9.	Setup vhost and restart apache

<h2>Step 3: Install and verify the installation</h2>

1.	<a href="http://devdocs.magento.com/guides/v2.0/install-gde/install/prepare-install.html">Update installation dependencies</a>
2.	Install Magento 2 EE:
	*	<a href="http://devdocs.magento.com/guides/v2.0/install-gde/install/install-web.html">Install Magento software using the web interface</a>
	*	<a href="http://devdocs.magento.com/guides/v2.0/install-gde/install/install-cli.html">Install Magento software using the command line</a>
2.	<a href="http://devdocs.magento.com/guides/v2.0/install-gde/install/verify.html">Verify the installation</a>

