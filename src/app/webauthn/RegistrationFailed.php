<?php declare(strict_types = 1);
namespace theseer\application\webauthn;

class RegistrationFailed implements RegistrationResult {

    private string $error;
    private int $code;

    public function __construct(string $error, int $code) {
        $this->error = $error;
        $this->code = $code;
    }

    public function isSuccess(): bool {
        return false;
    }

    public function error(): string {
        return $this->error;
    }

    public function code(): int {
        return $this->code;
    }


}
