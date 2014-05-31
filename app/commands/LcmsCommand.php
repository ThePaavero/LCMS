<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LcmsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'lcms';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$action = $this->argument('action');

		switch($action)
		{
			case 'block_type':
				$this->createBlockType();
				break;

			case 'template':
				$this->createTemplate();
				break;

			case 'block':
				$this->createBlock();
				break;

			case 'nukedb':
				$this->nukeDb();
				break;
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('action', InputArgument::REQUIRED, 'What to do'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

	private function createBlockType()
	{
		$name = trim($this->ask('Block name?'));

		if(empty($name))
		{
			$this->error('I need a name');
			exit;
		}

		$this->info('Creating block type "' . $name . '"...');

		$block_type = new BlockTypes;
		$block_type->name = $name;
		$block_type->save();

		$this->info('Done.');
	}

	private function createTemplate()
	{
		$name = trim($this->ask('Template name?'));

		if(empty($name))
		{
			$this->error('I need a name');
			exit;
		}

		$this->info('Creating template "' . $name . '"...');

		$template = new Template;
		$template->name = $name;
		$template->save();

		// Create file
		$path = app_path() . '/views/lcms/templates/' . $name . '.blade.php';
		$content = <<<END
<h1>{{ \$content['title'] }}</h1>
<div class='content'>
	{{ \$content['body'] }}
</div><!-- content -->
END;
		file_put_contents($path, $content);

		$this->info('Database row and template file created.');
	}

	public function createBlock()
	{
		$content = trim($this->ask('Initial content?'));

		if(empty($content))
		{
			$content = '---';
		}

		$this->info('Creating block...');

		$block = new Block;

		$block->contents = $content;
		$block->type     = 0;
		$block->page     = 0;

		$block->save();
		$id = $block->id;

		$this->info('Block ID: ' . $id);
	}

	public function nukeDb()
	{
		if( ! $this->confirm('Really reset entire database? [yes|no]'))
		{
			$this->info('Aborted.');
			return;
		}

		Cache::flush();

		$db_path = app_path() . '/database/production.sqlite';

		if(file_exists($db_path))
		{
			unlink($db_path);
		}

		touch($db_path);

		$this->call('migrate');
		$this->call('db:seed');
		$this->createBasicSitemap();
		$this->info('Created default pages');
	}

	public function createBasicSitemap()
	{
		$cms = new CMS;

		$cms->createNewPage([
				'title'     => 'About US',
				'url'       => 'about_us',
				'published' => new DateTime,
				'template'  => 1
			]);

		$cms->createNewPage([
				'title'     => 'Our Services',
				'url'       => 'our_services',
				'published' => new DateTime,
				'template'  => 1
			]);

		$cms->createNewPage([
				'title'     => 'Web Development',
				'url'       => 'our_services/web_development',
				'published' => new DateTime,
				'template'  => 1
			]);

		$cms->createNewPage([
				'title'     => 'HTML 6',
				'url'       => 'our_services/web_development/html_6',
				'published' => '9999-1-1 00:00:00',
				'template'  => 1
			]);
	}

}