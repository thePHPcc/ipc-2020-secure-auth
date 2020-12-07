<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\application\webauthn\Registration;

interface UserWriter {
    public function updateSharedSecret(User $user, string $sharedSecret): void;

    public function updateWebAuthRegistration(User $loginUser, Registration $result);
}
