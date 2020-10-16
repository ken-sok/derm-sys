<?php

require_once __DIR__ . '/autoload.php';

$mpdf = new \Mpdf\Mpdf([
    'default_font_size'=>18, 
    'default_font' => 'khmeros'
]);
$mpdf->WriteHTML('<h1>ព្រឹកមួយគ្រាប់ello world!</h1>');
$mpdf->Output();