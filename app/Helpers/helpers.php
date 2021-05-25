<?php

if (!function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string $path
     * @return string
     */
    function public_path($path = '')
    {
        $default = env('PUBLIC_PATH', 'public');
        return base_path($default) . ($path ? '/' . $path : $path);
    }
 }