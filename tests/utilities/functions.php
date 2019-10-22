<?php

function create($class, $attributes = [], $times = 1)
{
    return callFactory('create', $class, $attributes, $times);
}

function make($class, $attributes = [], $times = 1)
{
    return callFactory('make', $class, $attributes, $times);
}

function raw($class, $attributes = [], $times = 1)
{
    return callFactory('raw', $class, $attributes, $times);
}

function callFactory($method, $class, $attributes, $times)
{
    $collection = factory($class, $times)->{$method}($attributes);

    return $times == 1 ? $collection[0] : $collection;
}