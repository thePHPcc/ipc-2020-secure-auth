<?php declare(strict_types = 1);
namespace theseer\application\totp;

class SpomkyLabsTOTP implements TOTP {

    private \OTPHP\TOTPInterface $totp;

    public function __construct(\OTPHP\TOTPInterface $totp) {
        $this->totp = $totp;
    }

    public function sharedSecret(): string {
        return $this->totp->getSecret();
    }

    public function isCorrect(string $input): bool {
        return $this->totp->verify($input);
    }

    public function provisioningUri(string $label): string {
        $this->totp->setLabel($label);
        return $this->totp->getProvisioningUri();
    }

}
