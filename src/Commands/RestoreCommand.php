<?php
namespace Lattlay\LaravelBackup\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Lattlay\LaravelBackup\Databases\DatabaseFactory;
use Lattlay\LaravelBackup\FilesRestore;

class RestoreCommand extends Command {
	protected $signature = 'backup:restore';
	protected $description = 'Restore Laravel project';

	public function handle() {
		$backups = File::allFiles(storage_path('backups'));
		$zips = [];
		foreach($backups as $info) {
		    $parts = explode('.', $info->getBasename());
		    if($parts[count($parts) - 1] === 'database') {
		        continue;
		    }
			$zips[] = $info->getBasename();
		}

		$backup = $this->choice('Which backup would you like to use?', $zips, 0);

		$this->info('Restoring files...');
		$restore = new FilesRestore($backup);
		$restore->restore();
		$this->info('Restoring database...');
        $databaseBackup = DatabaseFactory::getDatabase(config('database.default'), str_replace('.zip', '', $backup));
		$databaseBackup->restoreDatabase();
		$databaseBackup->deleteTempFile();
		$this->info('Restore Complete!');
	}
}