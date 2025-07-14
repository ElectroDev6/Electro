<?php

function asset(string $path): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}
