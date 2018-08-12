<?php
namespace Lattlay\LaravelBackup;

use Illuminate\Support\Facades\File;
use ZipArchive;

class ZIPHandler {
	private $zipArchive;
	private $backupName;

	public function __construct(string $backupName) {
		$this->backupName = $backupName . '.zip';
		$this->zipArchive = new ZipArchive();
		$this->createNewBackupFile();
	}

	public function addFile(string $filepath): void {
		$relativeFilepath = str_replace(base_path(), '', $filepath);
		$pathParts = explode('/', $relativeFilepath);
		array_shift($pathParts);
		$relativePath = implode('/', $pathParts);
		if(is_dir($filepath)) {
			$this->zipArchive->addEmptyDir($relativePath);
		} else {
			$this->zipArchive->addFile($filepath, $relativePath);
		}
	}

	public function closeZip(): void {
		$this->zipArchive->close();
	}

	private function createNewBackupFile(): void {
		$this->createBackupPath();
		if($this->zipArchive->open(storage_path('backups/' . $this->backupName), ZipArchive::CREATE) !== true) {
			dd('FAIL');
		}
	}

	private function createBackupPath(): void {
		if(!File::exists(storage_path('backups'))) {
			File::makeDirectory(storage_path('backups'));
		}
	}

}