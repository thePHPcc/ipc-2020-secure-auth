<?php declare(strict_types = 1);
namespace theseer\application\totp;

interface QRCodeGenerator {

    public function generate(string $content): string;

}
