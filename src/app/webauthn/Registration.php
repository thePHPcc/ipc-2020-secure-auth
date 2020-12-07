<?php declare(strict_types = 1);
namespace theseer\application\webauthn;

use stdClass;

class Registration implements RegistrationResult {

    private stdClass $data;

    public function __construct(stdClass $data) {
        $this->data = $data;
    }

    public static function fromSerializedData(string $webAuthnData) {
        return new self(
            \unserialize($webAuthnData)
        );
    }

    public function isSuccess(): bool {
        return true;
    }

    public function webAuthnData(): stdClass {
        return $this->data;
    }
}
