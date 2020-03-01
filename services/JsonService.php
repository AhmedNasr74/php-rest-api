<?php
class JsonService
{
    public function __construct(){}
    public function encode($data = [])
    {
        return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
    public function decode($data = '')
    {
        return json_decode($data);
    }
}
