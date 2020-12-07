<?php declare(strict_types = 1);
namespace theseer\application\webauthn;

use stdClass;

class Registration implements RegistrationResult {

    private stdClass $data;

    public function __construct(stdClass $data) {
        $this->data = $data;
    }

    public function isSuccess(): bool {
        return true;
    }

    public function asJson(): string {
        return \json_encode($this->data, JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_IGNORE);
    }
}
