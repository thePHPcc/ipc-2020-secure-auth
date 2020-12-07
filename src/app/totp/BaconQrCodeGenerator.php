<?php declare(strict_types = 1);
namespace theseer\application\totp;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class BaconQrCodeGenerator implements QRCodeGenerator {

    public function generate(string $content): string {
        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new ImagickImageBackEnd()
        );

        return (new Writer($renderer))->writeString($content);
    }

}
