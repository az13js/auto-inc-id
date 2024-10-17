# Auto-Increment ID Generation and Retrieval Tool

1. [Click here to view the English version of the README](README.en.md)
2. [点击这里查看中文版本的README](README.md)

This is a PHP package for generating auto-incremented IDs on a single machine.

## Installation

You can install this package via Composer:

```sh
composer require "az13js/auto-inc-id"
```

## Usage

Include the package in your project:

```php
require __DIR__ . '/vendor/autoload.php';
```

Then you can use the following functions to get auto-incremented IDs:

```php
// Get auto-incremented ID (prefer shared memory, or from file if not available)
echo 'get_auto_inc_id(): ' . get_auto_inc_id() . PHP_EOL;

// Get auto-incremented ID directly from shared memory
echo 'get_auto_inc_id_shm(): ' . get_auto_inc_id_shm() . PHP_EOL;

// Get auto-incremented ID directly from file specified by the AUTO_INC_ID_FILE environment variable
echo 'get_auto_inc_id_file(): ' . get_auto_inc_id_file() . PHP_EOL;
```

## Notes

* The environment variable `AUTO_INC_ID_FILE` is used to specify the file for getting the auto-incremented ID. If not set, attempting to get the ID from the file will fail.
* The functions to get auto-incremented IDs will return `false` on failure, without throwing exceptions.
* Set the environment variable `AUTO_INC_ID_DEBUG` to any boolean value to enable debug mode and output debug information via standard error.
* This package uses shared memory or file to generate unique IDs. Shared memory is preferred for better performance but requires certain PHP functions to be available. If these functions are not available, the package will fall back to using files.
* Make sure to set the `AUTO_INC_ID_FILE` environment variable correctly if you choose to use the file option. The specified file should be writable by the PHP process.