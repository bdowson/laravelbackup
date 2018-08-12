<?php
namespace Lattlay\LaravelBackup\Commands;

use Illuminate\Console\Command;
use Lattlay\LaravelBackup\DatabaseBackup;
use Lattlay\LaravelBackup\ZIPHandler;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class BackupCommand extends Command {
	protected $signature = 'backup:start';
	protected $description = 'Backup current Laravel project';
	private $zip;
	private $fileBackup;
	private $databaseBackup;

	public function __construct() {
		parent::__construct();
		$backupName = 'backup_' . date('YmdHi');
		$this->zip = new ZIPHandler($backupName);
		$this->databaseBackup = new DatabaseBackup($backupName);
	}


	public function handle() {
		try {
			$this->info('Backup Starting');
			$this->backupDatabase();
			$this->backupFiles();
			$this->info('Finishing up');
			$this->zip->closeZip();
			$this->databaseBackup->deleteTempFile();
			$this->info('');
			$this->info('Backup Complete!');
		} catch (\Throwable $e) {
			$this->info('');
			$this->error($e->getMessage());
		}
	}

	private function backupDatabase() {
		$this->info('Backing up database');
		$this->databaseBackup->backupDatabase();
		$this->info('Database backup complete');
	}

	private function backupFiles() {
		$this->info('Backing up files');
			$fileObjects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path()), RecursiveIteratorIterator::SELF_FIRST);
			$totalFileCount = iterator_count($fileObjects);
			$progressBar = $this->output->createProgressBar($totalFileCount);
			$progressBar->setFormat(' %current%/%max% [%bar%] %message%');
			foreach($fileObjects as $name => $object) {
				$progressBar->advance();
				if(basename($name) === '.' || basename($name) === '..') {
					continue;
				}
				$relativeFilepath = str_replace(base_path(), '', $name);
				$progressBar->setMessage($relativeFilepath);
				$this->zip->addFile($name);
			}
			$progressBar->finish();
			$this->info('');
			$this->info('File backup complete');
	}

}