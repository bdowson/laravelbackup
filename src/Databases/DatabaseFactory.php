<?php
namespace Lattlay\LaravelBackup\Databases;

class DatabaseFactory {

	public static function getDatabase(string $databaseDriver, string $backupName): Database {
		$backupName .= '_' . $databaseDriver;
		switch ($databaseDriver) {
			case 'mysql':
				return new MySQL($backupName);
			case 'sqlite':
			    throw new \Exception('Unsupported database driver');
				//return new PostgreSQL($backupName);
			case 'pgsql':
			    throw new \Exception('Unsupported database driver');
				//return new SQLite($backupName);
            // @todo: Add support for sqlsrv
			/*case 'sqlsrv':
				return new SQLServer($backupName);*/
			default:
				throw new \Exception('Unsupported database driver');
		}
	}
}