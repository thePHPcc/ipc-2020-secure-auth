<?php declare(strict_types = 1);
namespace theseer\application\totp;

interface Generator {
    public function generate(?string $secret = null): TOTP;
}
