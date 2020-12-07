<?php declare(strict_types = 1);
namespace theseer\application\webauthn;

interface RegistrationResult {

    public function isSuccess(): bool;
}
