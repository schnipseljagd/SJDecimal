<?php
function __autoload($class)
{
    require dirname(__FILE__) . '/../src/' . str_replace('_', '/', $class . '.php');
}
