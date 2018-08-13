<?php
namespace Lattlay\LaravelBackup\Databases;

class PostgreSQL extends Database  {

	public function getDumpCommand(): string {
		return 'pg_dump --dbname=postgresql://' . config($this->connection . '.username') . ':' .
		       config($this->connection . '.password') . '@' . config($this->connection . '.host') . ':' .
		       config($this->connection . '.port') . '/' . config($this->connection . '.database') .
			   ' > ' . storage_path('backups/' . $this->backupName);
	}
}