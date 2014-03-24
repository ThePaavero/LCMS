<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Custom install script for xxx Laravel Framework
 *
 * @author Pekka Siiriäinen <pekka.siiriainen@xxxx.com>
 * @package xxx Laravel Framework
 * @copyright 2013 xxxx
 */
class InstallCommand extends Command {

	/**
	 * The console command name
	 *
	 * @var string
	 */
	protected $name = 'install';

	/**
	 * The console command description
	 *
	 * @var string
	 */
	protected $description = 'Custom install script for xxx Laravel Framework.';

	/**
	 * Create a new command instance
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->info('xxx Laravel 4 Installer');
		$this->info('---------------------------------');

		$this->chmodStorageDir();
		$this->enableRewrite();
		$this->installGD();
		$this->installMcrypt();

		if($this->ask('Create new database? [yes|no]', 'no') === 'yes')
		{
			$this->createDatabase();
		}

		if($this->ask('Install Composer? [yes|no]', 'no') === 'yes')
		{
			$this->installComposer();
		}

		if($this->ask('Install Node? [yes|no]', 'no') === 'yes')
		{
			$this->installNode();
		}

		if($this->ask('Run migrations? [yes|no]', 'no') === 'yes')
		{
			$this->runMigrations();
		}

		if($this->ask('Run composer update? [yes|no]', 'no') === 'yes')
		{
			$this->updateComposer();
		}

		if($this->ask('Run npm install grunt? [yes|no]', 'no') === 'yes')
		{
			$this->installGrunt();
		}

		if($this->ask('Run npm update? [yes|no]', 'no') === 'yes')
		{
			$this->updateNPM();
		}

		if($this->ask('Install "cpanel" package (user management)? [yes|no]', 'no') === 'yes')
		{
			$this->installCpanel();
		}

		if($this->ask('Do you want to apply custom patches for vendor packages? [yes|no]', 'no') === 'yes')
		{
			$this->applyCustomPatches();
		}

		if(trim($this->ask('Enter table prefix (leave empty for default "laravel_template")')) !== '')
		{
			$this->replaceTablePrefix($replace);
		}

		$this->info('All done!');

		return;
	}

	/**
	 * Wrapper for exec()
	 *
	 * @param  string $cmd Command to be executed
	 * @return string
	 */
	private function exec($cmd)
	{
		return exec($cmd);
	}

	/**
	 * Replace default table prefix in database config file
	 *
	 * @param  string $to e.g. 'project_x'
	 * @return null
	 */
	private function replaceTablePrefix($to)
	{
		$this->line('Replacing table prefix...');

		// Make sure we have a trailing underscore
		$end = substr($to, strlen($to)-1, strlen($to));
		if($end !== '_')
		{
			$to = $to . '_';
		}

		// Database config
		$file    = 'app/config/database.php';
		$replace = "=> 'laravel_template_',";
		$content = file_get_contents($file);

		if( ! strstr($content, $replace))
		{
			$this->error('Database file has been tampered with, skipping...');
			return;
		}

		$to = "=> '" . $to . "',";
		$new_content = str_replace($replace, $to, $content);
		file_put_contents($file, $new_content);
	}

	/**
	 * Overwrite vendor dir with our own patches
	 *
	 * @return null
	 */
	private function applyCustomPatches()
	{
		$this->line('Applying custom patches...');
		exec('cp -r _vendor_patches/* vendor');
	}

	/**
	 * Create new database
	 *
	 * @return null
	 */
	private function createDatabase()
	{
		$changed = false;
		$default_db = Config::get('database')['connections']['mysql']['database'];
		$db_name = $this->ask('Name of DB (leave empty for "' . $default_db . '")', $default_db);
		if($db_name !== $default_db)
		{
			// Need to rename the config value, too
			$config_file = 'app/config/database.php';
			$old = file_get_contents($config_file);
			$new = str_replace("'database'  => '" . $default_db . "',", "'database'  => '" . $db_name . "',", $old);
			file_put_contents($config_file, $new);
			$changed = true;
		}
		$cmd = 'echo "create database ' . $db_name . '" | mysql -u root -p';
		$this->info('The password is "123"');
		$this->exec($cmd);

		if($changed === true)
		{
			$this->info('Database configuration changed, have to run installer again, sorry. Exiting...');
			exit;
		}
	}

	/**
	 * Change permissions for storage dir
	 *
	 * @return null
	 */
	private function chmodStorageDir()
	{
		$this->line('Making sure storage dir is writable...');
		$this->exec('chmod -R 777 app/storage');
	}

	/**
	 * Enable rewrite Apache module
	 *
	 * @return null
	 */
	private function enableRewrite()
	{
		$this->line('Making sure rewrite is enabled...');
		$this->exec('a2enmod rewrite');
	}

	/**
	 * Run "composer update"
	 *
	 * @return null
	 */
	private function updateComposer()
	{
		$this->line('composer update (this might take a while)...');
		$this->exec('composer update');
		$this->line('composer updated...');
	}

	/**
	 * Call Artisan command "migrate"
	 *
	 * @return null
	 */
	private function runMigrations()
	{
		$this->line('Running possible migrations...');
		$this->call('migrate');
		$this->line('Possible migrations done...');
	}

	/**
	 * Run cPanel's installer
	 *
	 * @return null
	 */
	private function installCpanel()
	{
		$this->line('Installing user management...');
		$this->call('cpanel:install');
		$this->line('Installed user management...');
	}

	/**
	 * Install Grunt
	 *
	 * @return null
	 */
	private function installGrunt()
	{
		$this->line('Installing/updating Grunt (this might take a while)...');
		$this->exec('npm install grunt');
		$this->line('Installing/updating Grunt done...');
	}

	/**
	 * Run "npm update"
	 *
	 * @return null
	 */
	private function updateNPM()
	{
		$this->line('Installing/updating Node modules (this might take a while)...');
		$this->exec('npm update');
		$this->line('Installing/updating Node modules done...');
	}

	/**
	 * Install Node
	 *
	 * @return null
	 */
	private function installNode()
	{
		$this->line('Installing Node (this might take a while)...');
		$this->exec('apt-get -q -y install node');
	}

	/**
	 * Install composer (globally)
	 *
	 * @return null
	 */
	private function installComposer()
	{
		$this->line('Installing Composer...');
		$this->exec('curl -sS https://getcomposer.org/installer | php');
		$this->exec('mv composer.phar /usr/local/bin/composer');
	}

	/**
	 * Install GD library for PHP
	 *
	 * @return null
	 */
	private function installGD()
	{
		$this->line('Installing GD for PHP (this might take a while)...');
		$this->exec('apt-get -q -y install php5-gd');
	}

	/**
	 * Install Mcrypt library for PHP (and restart apache service)
	 *
	 * @return null
	 */
	private function installMcrypt()
	{
		$this->line('Installing Mcrypt for PHP (this might take a while)...');
		$this->exec('apt-get -q -y install php5-mcrypt');
		$this->line('Restarting Apache...');
		$this->exec('service apache2 restart');
		$this->line('Apache restarted.');
	}

}