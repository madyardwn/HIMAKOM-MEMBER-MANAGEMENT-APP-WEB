<?php

if (!function_exists('logFile')) {
    function logFile($path, $file, $type = 'UPDATED')
    {
        if (!file_exists(storage_path('app/logfile/' . $path))) {
            mkdir(storage_path('app/logfile/' . $path), 0755, true);
        }
        $filename = $type . '_AT_' .  date('Y-m-d-H-i-s') . '_FROM_' . $file;
        rename(storage_path('app/public/' . $path . '/' . $file), storage_path('app/logfile/' . $path . '/' . $filename));
    }
}

if (!function_exists('deleteFile')) {
    function deleteFile($path)
    {
        if (file_exists(storage_path('app/public/' . $path))) {
            unlink(storage_path('app/public/' . $path));
        }
    }
}
