<?php

function view($view, $data = []) {
    require './resources/views/' . $view . '.php';
}

function dd(...$var): void
{
    echo '<pre>';
    foreach ($var as $value) {
        var_dump($value);
    }
    echo '</pre>';
    die();
}

function dump(...$var): void
{
    echo '<pre>';
    foreach ($var as $value) {
        var_dump($value);
    }
    echo '</pre>';
}