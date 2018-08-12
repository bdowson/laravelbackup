<?php
namespace Lattlay\LaravelBackup\Commands;

use Illuminate\Console\Command;
use Lattlay\LaravelBackup\ZIPHandler;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class BackupCommand extends Command {
	protected $signature = 'backup:start';
	protected $description = 'Backup current Laravel project';

	public function handle() {
		try {
			$fileObjects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path()), RecursiveIteratorIterator::SELF_FIRST);
			$totalFileCount = iterator_count($fileObjects);
			$progressBar = $this->output->createProgressBar($totalFileCount);
			$progressBar->setFormat(' %current%/%max% [%bar%] %message%');
			$zip = new ZIPHandler();

			foreach($fileObjects as $name => $object) {
				$progressBar->advance();
				if(basename($name) === '.' || basename($name) === '..') {
					continue;
				}
				$relativeFilepath = str_replace(base_path(), '', $name);
				$progressBar->setMessage($relativeFilepath);
				$zip->addFile($name);
			}
			$zip->closeZip();
			$progressBar->finish();
			$this->info('');
			$this->info('Backup Complete!');
		} catch (\Throwable $e) {
			$this->info('');
			$this->error($e->getMessage());
		}
	}

}