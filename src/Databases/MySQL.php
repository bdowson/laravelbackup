<?php
namespace Lattlay\LaravelBackup\Databases;

class MySQL extends Database {

	public function getDumpCommand(): string {
		return 'mysqldump' .
		       ' --user=' . config($this->connection . '.username') .
		       ' --password=' . config($this->connection . '.password') .
		       ' --add-drop-database ' .
		       ' --databases ' . config($this->connection . '.database') .
		       ' > ' . storage_path('backups/' . $this->backupName) .
			   '  2>&1 | grep -v "Warning: Using a password"';
	}
}