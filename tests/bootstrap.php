<?php
if (!function_exists('sjAutoload')) {
    function sjAutoload($class)
    {
        if (strpos($class, 'Sj_') === 0) {
            $file = str_replace('_', '/', $class) . '.php';
            if ($file) {
                require 'src/' . $file;
            }
        }
    }
    spl_autoload_register('sjAutoload');
}
