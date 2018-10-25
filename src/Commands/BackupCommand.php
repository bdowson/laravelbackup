<?php
namespace Lattlay\LaravelBackup\Commands;

use Illuminate\Console\Command;
use Lattlay\LaravelBackup\Databases\DatabaseFactory;
use Lattlay\LaravelBackup\ZIPHandler;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class BackupCommand extends Command {
	protected $signature = 'backup:start';
	protected $description = 'Backup current Laravel project';
	private $zip;
	private $backupName;
	private $databaseBackup;

	public function __construct() {
		parent::__construct();
		$this->backupName = 'backup_' . date('YmdHi');
	}


	public function handle() {
		try {
		    $this->zip = new ZIPHandler($this->backupName);
			$this->info('Backup Starting');

			if(config('backup.backup_database')) {
			    $this->backupDatabase();
            }

			if(config('backup.backup_files')) {
                $this->backupFiles();
            }

            $this->info('Zipping files');
            $this->zip->closeZip();
            if(config('backup.backup_database')) {
                $this->databaseBackup->deleteTempFile();
            }
			$this->info('');
			$this->info('Backup Complete!');
		} catch (\Throwable $e) {
			$this->info('');
			$this->error($e->getMessage());
		}
	}

	private function backupDatabase() {
		$this->info('Backing up database');
		$this->databaseBackup = DatabaseFactory::getDatabase(config('database.default'), $this->backupName);
		$this->databaseBackup->backupDatabase();
		$this->zip->addFile(storage_path('backups/') . $this->databaseBackup->getDBBackupName());
		$this->info('Database backup complete');
	}

	private function backupFiles() {
		$this->info('Backing up files');
        $fileObjects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path()), RecursiveIteratorIterator::SELF_FIRST);
        $totalFileCount = iterator_count($fileObjects);
        $skipFolders = config('backup.ignore_folders');
        $progressBar = $this->output->createProgressBar($totalFileCount);
        $progressBar->setFormat(' %current%/%max% [%bar%] %message%');
        foreach($fileObjects as $name => $object) {
            $progressBar->advance();
            $filePath = explode('/', $name);
            if(basename($name) === '.' || basename($name) === '..' || !empty(array_intersect($skipFolders, $filePath))) {
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