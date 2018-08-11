<?php
namespace Lattlay\LaravelCloner;

use Illuminate\Console\Command;

class Cloner extends Command {
	protected $signature = 'clone:start';
	protected $description = 'Clone current Laravel project';
}