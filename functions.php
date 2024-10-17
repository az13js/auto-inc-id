<?php
/**
 * 通过共享内存获取自增ID
 *
 * @return int|false
 */
function get_auto_inc_id_shm()
{
    $enable_debug = getenv('AUTO_INC_ID_DEBUG');

    $key_s = ftok(__FILE__, 's');
    $s = sem_get($key_s);
    if (!$s) {
        if ($enable_debug) {
            fwrite(STDERR, "Failed to get semaphore.".PHP_EOL);
        }
        return false;
    }

    sem_acquire($s);

    $key_m = ftok(__FILE__, 'm');
    $m = shm_attach($key_m);
    $id = 1;
    if (shm_has_var($m, 1)) {
        $id = shm_get_var($m, 1);
    }
    if ($id <= 0) {
        $id = 1;
    }

    shm_put_var($m, 1, $id + 1);
    shm_detach($m);
    sem_release($s);
    return $id;
}

/**
 * 通过文件获取自增ID
 *
 * @return int|false
 */
function get_auto_inc_id_file()
{
    $enable_debug = getenv('AUTO_INC_ID_DEBUG');

    $file = getenv('AUTO_INC_ID_FILE');
    if (empty($file) || !is_file($file)) {
        if ($enable_debug) {
            fwrite(STDERR, "Please ensure that the environment variable AUTO_INC_ID_FILE points to the file that contains the auto-incremented ID.".PHP_EOL);
        }
        return false;
    }

    $fp = fopen($file, 'r+');

    if (!$fp) {
        if ($enable_debug) {
            fwrite(STDERR, "Failed to open file \"$file\".".PHP_EOL);
        }
        return false;
    }

    flock($fp, LOCK_EX);

    $id = intval(fread($fp, 1024));
    if ($id <= 0) {
        $id = 1;
    }

    fseek($fp, 0);
    ftruncate($fp, 0);

    fwrite($fp, strval($id + 1));
    fclose($fp);
    return $id;
}

/**
 * 通过共享内存或文件获取自增ID
 *
 * @return int|false
 */
function get_auto_inc_id()
{
    $enable_debug = getenv('AUTO_INC_ID_DEBUG');
    $check_functions = [
        'ftok',
        'sem_get',
        'sem_acquire',
        'shm_attach',
        'shm_has_var',
        'shm_get_var',
        'shm_put_var',
        'shm_detach',
        'sem_release',
    ];
    foreach ($check_functions as $func) {
        if (!function_exists($func)) {
            if ($enable_debug) {
                fwrite(STDERR, "function $func not exists, use file".PHP_EOL);
            }
            return get_auto_inc_id_file();
        }
    }

    return get_auto_inc_id_shm();
}
