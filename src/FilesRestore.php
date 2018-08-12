<?php
namespace Lattlay\LaravelBackup;

use Illuminate\Support\Facades\File;
use ZipArchive;

class FilesRestore {
	private $filepath;

	public function __construct(string $filename) {
		$this->filepath = storage_path('backups/' . $filename);
		if(!File::exists($this->filepath)) {
			throw new \Exception('File does not exist');
		}
	}

	public function restore() {
		File::copy($this->filepath, base_path(basename($this->filepath)));
		$zip = new ZipArchive;
		if(!File::exists(base_path(basename($this->filepath)))) {
			throw new \Exception('File does not exist');
		}
        $res = $zip->open(base_path(basename($this->filepath)));
        if ($res) {
            $zip->extractTo(base_path());
            $zip->close();
            echo 'yay' . PHP_EOL;
        }
	}
}