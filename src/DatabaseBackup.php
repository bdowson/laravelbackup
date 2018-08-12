<?php
namespace Lattlay\LaravelBackup;

use Illuminate\Support\Facades\DB;

class DatabaseBackup {
	private $connection;
	private $backupName;

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

	private function getDumpCommand(): string {
		switch (config($this->connection . '.driver')) {
			case 'mysql':
				return 'mysqldump' .
				       ' --user=' . config($this->connection . '.username') .
				       ' --password=' . config($this->connection . '.password') .
				       ' --add-drop-database ' .
				       ' --databases ' . config($this->connection . '.database') .
				       ' > ' . storage_path('backups/' . $this->backupName) .
					   '  2>&1 | grep -v "Warning: Using a password"';
			case 'sqlite':
				return '';
			case 'pgsql':
				return '';
			case 'sqlsrv':
				return '';
			default:
				throw new \Exception('Unsupported database type');
		}
	}

}