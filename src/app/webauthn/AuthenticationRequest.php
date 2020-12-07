<?php declare(strict_types = 1);
namespace theseer\application\webauthn;

use RuntimeException;
use stdClass;

class AuthenticationRequest {

    private stdClass $userData;
    private stdClass $inputData;
    private string $challenge;

    public function __construct(stdClass $userData, stdClass $inputData, string $challenge) {
        $this->userData = $userData;
        $this->inputData = $inputData;
        $this->challenge = $challenge;
    }

    public function clientData(): string {
        return \base64_decode($this->inputData->clientDataJSON);
    }

    public function authenticatorData(): string {
        return \base64_decode($this->inputData->authenticatorData);
    }

    public function signature(): string {
        return \base64_decode($this->inputData->signature);
    }


    public function challenge(): string {
        return $this->challenge;
    }

    public function publicKey(): string {
        if ($this->userData->credentialId != \base64_decode($this->inputData->id)) {
            throw new RuntimeException('Unexpected key id');
        }

        return $this->userData->credentialPublicKey;
    }

}
