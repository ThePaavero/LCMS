<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ShowUsersCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'showusers';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Show all users.';

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
		$users = Sentry::findAllUsers();

		foreach($users as $i)
		{
			$this->info($i['id'] . "\t\t" . $i['email'] . "\t\t" . $i['created_at']);
		}
	}

}