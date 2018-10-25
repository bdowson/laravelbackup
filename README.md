# Laravel Backup

A simple backup and restore package for Laravel 5.

## Installation

Install with composer:

`$ composer require lattlay/laravelbackup`

Add the following to `config/app.php`:

`Lattlay\LaravelBackup\LaravelBackupServiceProvider::class`

Publish vendor files to the `config` folder:

`$ php artisan vendor:publish`

## Configuration

This plugin has the following options available for configuration:

**ignore_folders** - *(array)* An array of folder names that are ignored. The `.git` folder is ignored by default

**backup_files** - *(boolean)* Toggles whether files should be backed up

**backup_database** = *(boolean)* Toggles whether the database should be backed up

## Usage

### To Backup

`$ php artisan backup:start`

This creates a .zip file in `storage/backups`

### To Restore

`$ php artisan backup:restore`

Restores from the backup .zip in `storage/backups`