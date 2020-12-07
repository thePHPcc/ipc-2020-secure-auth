<?php declare(strict_types = 1);
namespace theseer\application\webauthn;

use theseer\application\User;
use WebAuthn\Binary\ByteBuffer;
use WebAuthn\WebAuthn;
use WebAuthn\WebAuthnException;

class WebAuthnService {

    private WebAuthn $webAuthn;

    public function __construct(WebAuthn $webAuthn) {
        $this->webAuthn = $webAuthn;
    }

    public function registrationOptions(User $user): Options {

        $args = $this->webAuthn->getCreateArgs(
            $user->login(),
            $user->login(),
            $user->login()
        );

        return new Options(
            $args,
            $this->webAuthn->getChallenge()->getBinaryString()
        );
    }

    public function loginOptions(User $loginUser): Options {
        $input = \unserialize($loginUser->webAuthnData(), ['allowed_classes' => [\stdClass::class]]);
        $args = $this->webAuthn->getGetArgs([$input->credentialId]);

        return new Options(
            $args,
            $this->webAuthn->getChallenge()->getBinaryString()
        );
    }


    public function register(string $clientDataJSON, string $attestationObject, string $challenge): RegistrationResult {
        try {
            $data = $this->webAuthn->processCreate(
                $clientDataJSON,
                $attestationObject,
                new ByteBuffer($challenge)
            );

            return new Registration($data);
        } catch (WebAuthnException $e) {

            return new RegistrationFailed($e->getMessage(), $e->getCode());
        }
    }

    public function verify(AuthenticationRequest $request): bool {
        try {
            return $this->webAuthn->processGet(
                $request->clientData(),
                $request->authenticatorData(),
                $request->signature(),
                $request->publicKey(),
                $request->challenge()
            );
        } catch (WebAuthnException $e) {
            return false;
        }
    }

}
