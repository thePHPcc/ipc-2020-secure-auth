<?php declare(strict_types = 1);
namespace theseer\application;

use OTPHP\TOTP;
use theseer\application\webauthn\AuthenticationRequest;
use theseer\application\webauthn\Registration;
use theseer\application\webauthn\WebAuthnService;
use theseer\framework\http\Command;
use theseer\framework\http\Parameters;
use theseer\framework\http\Result;

class LoginCommand implements Command {

    private Parameters $parameters;
    private ApplicationState $applicationState;
    private UserReader $userReader;
    private WebAuthnService $webAuthnService;

    public function __construct(Parameters $parameters, ApplicationState $applicationState, UserReader $userReader, WebAuthnService $webAuthnService) {
        $this->parameters = $parameters;
        $this->applicationState = $applicationState;
        $this->userReader = $userReader;
        $this->webAuthnService = $webAuthnService;
    }

    public function execute(): Result {

        try {
            $this->ensureRequiredFieldsPresent();
            $this->ensureValidCsrfToken();
        } catch (BadRequestException $e) {
            return new LoginFailedResult();
        }

        $user = $this->userReader->findByUsername($this->parameters->get('username'));

        if (!$user) {
            return new LoginFailedResult();
        }

        if (!\password_verify($this->parameters->get('password'), $user->passwdHash())) {
            return new LoginFailedResult();
        }

        if (!$this->verifyTOTP($user->totpSecret()) &&
            !$this->verifyWebAuthn($user->webAuthnData())) {
            return new LoginFailedResult();
        }

        $this->applicationState->setLoginUser($user);

        return new LoginSuccessResult();
    }

    private function ensureRequiredFieldsPresent() {
        if (!$this->parameters->has('TOK')) {
            throw new BadRequestException('No CSRF Token supplied');
        }
        if (!$this->parameters->has('username')) {
            throw new BadRequestException('No Username supplied');
        }
        if (!$this->parameters->has('password')) {
            throw new BadRequestException('No Username supplied');
        }
        if (!$this->parameters->has('totp')) {
            throw new BadRequestException('No 2FA code supplied');
        }
        if (!$this->parameters->has('webauthn')) {
            throw new BadRequestException('No webauthn field supplied');
        }
    }

    private function ensureValidCsrfToken(): void {
        if (!$this->applicationState->csrfToken()->isCorrect($this->parameters->get('TOK'))) {
            throw new BadRequestException('Invalid CSRF Token supplied');
        }
    }

    private function verifyTOTP(string $secret) {
        if ($secret === '') {
            return true;
        }

        $totp = $this->parameters->get('totp');
        if ($totp === '') {
            return false;
        }

        return TOTP::create($secret)->verify($totp);
    }

    private function verifyWebAuthn(string $webAuthnData): bool {
        if ($webAuthnData === '') {
            return true;
        }

        $input = $this->parameters->get('webauthn');
        if ($input === '') {
            return false;
        }

        $authRequest = new AuthenticationRequest(
            \unserialize($webAuthnData, ['allowed_classes' => [\stdClass::class]]),
            \json_decode(\base64_decode($input), false),
            $this->applicationState->webAuthnChallenge()
        );

        return $this->webAuthnService->verify($authRequest);
     }

}
