<?php
namespace Lattlay\LaravelBackup\Databases;

/*
 * Base class for database backups
 */
abstract class Database {
	protected $connection;
	protected $backupName;
	protected $dbType;

	public function __construct(string $backupName) {
		$this->backupName = $backupName . '.database';
		$this->connection = 'database.connections.' . config('database.default');
	}

	public function getDBBackupName() {
	    return $this->backupName;
    }

	public function backupDatabase() {
		exec($this->getDumpCommand());
	}

	public function restoreDatabase() {
	    exec($this->getRestoreCommand());
    }

	public function deleteTempFile() {
		unlink(storage_path('backups/' . $this->backupName));
	}

	public abstract function getDumpCommand(): string;
	public abstract function getRestoreCommand(): string;

}