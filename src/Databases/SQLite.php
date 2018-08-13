<?php
namespace Lattlay\LaravelBackup\Databases;

class SQLite extends Database  {

	public function getDumpCommand(): string {
		return 'cp ' . config($this->connection . 'database') . storage_path('backups/' . $this->backupName);
	}

}