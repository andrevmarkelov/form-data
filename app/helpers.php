<?php

/**
 * Prints any data like a print_r function
 * @param mixed ... Any data to be printed
 */
function fn_print_r()
{
    $args = func_get_args();

    echo('<ol style="font-family: Courier; font-size: 12px; border: 1px solid #dedede; background-color: #efefef; float: left; padding-right: 20px;">');

    foreach ($args as $v) {
        echo('<li><pre>' . htmlspecialchars(print_r($v, true)) . "\n" . '</pre></li>');
    }

    echo('</ol><div style="clear:left;"></div>');
}

/**
 * @param string $view
 * @return string
 */
function fn_view(string $view, array $vars = [])
{
    return require ROOT_DIR . '/resources/views/' . str_replace('.', '/', $view) . '.php';
}
