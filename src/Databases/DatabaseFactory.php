<?php
namespace Lattlay\LaravelBackup\Databases;

class DatabaseFactory {

	public static function getDatabase(string $databaseDriver, string $backupName): Database {
		switch ($databaseDriver) {
			case 'mysql':
				return new MySQL($backupName);
			case 'sqlite':
				return new PostgreSQL($backupName);
			case 'pgsql':
				return new PostgreSQL($backupName);
			case 'sqlsrv':
				return new SQLServer($backupName);
			default:
				throw new \Exception('Unsupported database driver');
		}
	}
}