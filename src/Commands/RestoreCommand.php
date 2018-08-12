<?php
namespace Lattlay\LaravelBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Lattlay\LaravelBackup\FilesRestore;

class RestoreCommand extends Command {
	protected $signature = 'backup:restore';
	protected $description = 'Restore Laravel project';

	public function handle() {
		$backups = File::allFiles(storage_path('backups'));
		$zips = [];
		foreach($backups as $info) {
			$zips[] = $info->getBasename();
		}

		$backup = $this->choice('Which backup would you like to use?', $zips, 0);
		$restore = new FilesRestore($backup);
		$restore->restore();
	}
}