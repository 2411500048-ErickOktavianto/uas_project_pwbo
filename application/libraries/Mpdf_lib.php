<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Mpdf;

class Mpdf_lib
{
    public function load($config = [])
    {
        return new Mpdf(array_merge([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            // PENTING untuk performa di Windows/Laragon
            'tempDir' => APPPATH . 'cache'
        ], $config));
    }
}
