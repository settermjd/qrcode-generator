<?php

declare(strict_types=1);

use App\QR\Image\QRImageWithLogo;
use App\QR\Options\LogoOptions;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

require_once('./../vendor/autoload.php');

$options = new QROptions(
    [
        'eccLevel' => QRCode::ECC_L,
        'outputType' => QRCode::OUTPUT_MARKUP_SVG,
        'version' => 5,
    ]
);

$qrcode = (new QRCode($options))->render('https://twilio.com');

/*$options = new LogoOptions(
    [
        'eccLevel' => QRCode::ECC_H,
        'imageBase64' => true,
        'logoSpaceHeight' => 17,
        'logoSpaceWidth' => 17,
        'maskPattern' => QRCode::MASK_PATTERN_AUTO,
        'scale' => 20,
        'version' => 7,
    ]
);

$qrOutputInterface = new QRImageWithLogo(
    $options,
    (new QRCode($options))->getMatrix('https://twitter.com/@settermjd')
);

$qrcode = $qrOutputInterface->dump(
    null,
    __DIR__.'/../public/img/logo-twilio-mark-red.png'
);*/
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Create a QR Code in PHP</title>
    <link rel="stylesheet" href="/css/styles.min.css">
</head>
<body>
<h1>Create a QR Code in PHP</h1>
<div class="container">
    <img src='<?= $qrcode ?>' alt='QR Code' width='800' height='800'>
<!--    <small class="mt-4 text-center text-gray-700">The Twilio logomark (or colloquially 'The Bug') is a registered trademark of Twilio inc.</small>-->
    <small class="mt-4 text-center text-gray-700">Created by Matthew Setter for the Twilio blog.</small>
</div>
</body>
</html>
