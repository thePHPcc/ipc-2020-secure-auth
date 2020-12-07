<?php declare(strict_types = 1);
namespace theseer\application\totp;

interface TOTP {
    public function sharedSecret(): string;
    public function isCorrect(string $input): bool;
    public function provisioningUri(string $label): string;
}
