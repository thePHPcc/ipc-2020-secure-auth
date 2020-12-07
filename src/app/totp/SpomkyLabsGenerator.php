<?php declare(strict_types = 1);
namespace theseer\application\totp;

class SpomkyLabsGenerator implements Generator {

    public function generate(?string $secret = null): TOTP {
        return new SpomkyLabsTOTP(
            \OTPHP\TOTP::create($secret)
        );
    }
}
