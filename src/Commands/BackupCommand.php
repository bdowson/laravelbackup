<?php
namespace Lattlay\LaravelBackup\Commands;

use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use Symfony\Component\Console\Helper\ProgressBar;

class BackupCommand extends Command {
	protected $signature = 'backup:start';
	protected $description = 'Backup current Laravel project';

	public function handle() {
		$fileObjects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path()), RecursiveIteratorIterator::SELF_FIRST);
		$totalFileCount = iterator_count($fileObjects);
		$progressBar = $this->output->createProgressBar($totalFileCount);
		foreach($fileObjects as $name => $object){
			$progressBar->advance();

		}
		$progressBar->finish();
		$this->info('');
		$this->info('Backup Complete!');
	}

}