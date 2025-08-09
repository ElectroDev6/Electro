<?php
class Asset
{
    public static function url($path)
    {
        return BASE_URL . '/public/' . ltrim($path, '/');
    }
}
