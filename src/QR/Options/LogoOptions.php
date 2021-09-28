<?php

declare(strict_types=1);

namespace App\QR\Options;

use chillerlan\QRCode\QROptions;

class LogoOptions extends QROptions
{
    // size in QR modules, multiply with QROptions::$scale for pixel size
    protected int $logoSpaceWidth;
    protected int $logoSpaceHeight;
}
