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

function getInitial($name): string
{
    $words = explode(' ', $name);
    $initial = '';
    foreach ($words as $word) {
        $initial .= strtoupper($word[0]);
    }
    return $initial;
}