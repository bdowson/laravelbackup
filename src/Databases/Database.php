<?php
namespace Lattlay\LaravelBackup\Databases;

abstract class Database {
	protected $connection;
	protected $backupName;
	protected $dbType;

	public function __construct(string $backupName) {
		$this->backupName = $backupName . '.database';
		$this->connection = 'database.connections.' . config('database.default');
	}

	public function backupDatabase() {
		exec($this->getDumpCommand());
	}

	public function deleteTempFile() {
		unlink(storage_path('backups/' . $this->backupName));
	}

	public abstract function getDumpCommand(): string;

}