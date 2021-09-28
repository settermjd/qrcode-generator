<?php

declare(strict_types=1);

namespace App\QR\Image;

use chillerlan\QRCode\Output\{QRCodeOutputException, QRImage};

use function imagecopyresampled, imagecreatefrompng, imagesx, imagesy, is_file, is_readable;

/**
 * @property \chillerlan\QRCodeExamples\LogoOptions $options
 */
class QRImageWithLogo extends QRImage
{
    /**
     * @param string|null $file
     * @param string|null $logo
     *
     * @return string
     * @throws \chillerlan\QRCode\Output\QRCodeOutputException
     */
    public function dump(string $file = null, string $logo = null): string
    {
        // set returnResource to true to skip further processing for now
        $this->options->returnResource = true;

        // of course you could accept other formats too (such as resource or Imagick)
        // i'm not checking for the file type either for simplicity reasons (assuming PNG)
        if ($logo !== null) {
            if(!is_file($logo) || !is_readable($logo)){
                throw new QRCodeOutputException('invalid logo');
            }
        }

        $this->matrix->setLogoSpace(
            $this->options->logoSpaceWidth,
            $this->options->logoSpaceHeight
        );

        // there's no need to save the result of dump() into $this->image here
        parent::dump($file);

        if ($logo !== null) {
            $im = imagecreatefrompng($logo);

            // get logo image size
            $w = imagesx($im);
            $h = imagesy($im);

            // set new logo size, leave a border of 1 module (no proportional resize/centering)
            $lw = ($this->options->logoSpaceWidth - 2) * $this->options->scale;
            $lh = ($this->options->logoSpaceHeight - 2) * $this->options->scale;

            // get the qrcode size
            $ql = $this->matrix->size() * $this->options->scale;

            // scale the logo and copy it over. done!
            imagecopyresampled($this->image, $im, ($ql - $lw) / 2, ($ql - $lh) / 2, 0, 0, $lw, $lh, $w, $h);
        }

        $imageData = $this->dumpImage();

        if ($file !== null) {
            $this->saveToFile($imageData, $file);
        }

        if ($this->options->imageBase64) {
            $imageData = 'data:image/'.$this->options->outputType.';base64,'.base64_encode($imageData);
        }

        return $imageData;
    }

}
