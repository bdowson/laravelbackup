<?php
namespace Lattlay\LaravelBackup\Commands;

use Illuminate\Console\Command;

class RestoreCommand extends Command {
	protected $signature = 'backup:restore';
	protected $description = 'Restore Laravel project';
}