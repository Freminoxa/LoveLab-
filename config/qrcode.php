<?php

return [
    /*
    |--------------------------------------------------------------------------
    | QR Code Writer
    |--------------------------------------------------------------------------
    |
    | This value is the default writer used to generate QR codes.
    | Options: 'png', 'svg', 'eps'
    |
    */
    'writer' => 'png',

    /*
    |--------------------------------------------------------------------------
    | QR Code Size
    |--------------------------------------------------------------------------
    |
    | This value is the default size in pixels of the QR code.
    |
    */
    'size' => 300,

    /*
    |--------------------------------------------------------------------------
    | QR Code Margin
    |--------------------------------------------------------------------------
    |
    | This value is the default margin in pixels around the QR code.
    |
    */
    'margin' => 0,

    /*
    |--------------------------------------------------------------------------
    | QR Code Error Correction Level
    |--------------------------------------------------------------------------
    |
    | This value is the default error correction level.
    | Options: 'L', 'M', 'Q', 'H'
    |
    */
    'error_correction' => 'M',

    /*
    |--------------------------------------------------------------------------
    | QR Code Encoding
    |--------------------------------------------------------------------------
    |
    | This value is the default character encoding.
    |
    */
    'encoding' => 'UTF-8',
];