<?php

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class HourlySyncFromErply extends ScheduledCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'osavmo:sync';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Sync Data from ERPLY hourly.';

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
	 * When a command should run
	 *
	 * @param Scheduler $scheduler
	 * @return \Indatus\Dispatcher\Scheduling\Schedulable
	 */
	public function schedule(Schedulable $scheduler)
	{
		//return $scheduler;
		return [
			$scheduler->hours([0,1,2,3,4,5,6,7,24])->everyMinutes(120),
			App::make(get_class($scheduler))->hours([8,9,10,11,12,13,14,15,16,17,18])->everyMinutes(5),
			App::make(get_class($scheduler))->hours([20,21,22,23])->everyMinutes(30)
		];
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		SyncHelper::syncProducts(array('days'=>'auto'));
		$this->info('Sync Products successfuly');
		SyncHelper::syncProductStocks(array('days'=>'auto'));
		$this->info('sync ProductStocks successfuly');
		SyncHelper::syncSalesDocuments(array('days'=>'auto'));
		$this->info('sync SalesDocuments successfuly');
		SyncHelper::syncPriceListItems(array('days'=>'auto'));
		$this->info('sync PriceListItems successfuly');
		SyncHelper::syncSuppliers(array('days'=>'auto'));
		$this->info('Sync Suppliers successfuly');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
