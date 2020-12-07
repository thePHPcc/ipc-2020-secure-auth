<?php declare(strict_types = 1);
namespace theseer\application;

use OTPHP\TOTP;
use theseer\framework\http\Command;
use theseer\framework\http\Parameters;
use theseer\framework\http\Result;

class LoginCommand implements Command {

    private Parameters $parameters;

    private ApplicationState $applicationState;

    private UserReader $userReader;

    public function __construct(Parameters $parameters, ApplicationState $applicationState, UserReader $userReader) {
        $this->parameters = $parameters;
        $this->applicationState = $applicationState;
        $this->userReader = $userReader;
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

        if (!$this->verifyTOTP($user->totpSecret())) {
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

        if (!$this->parameters->has('totp')) {
            return false;
        }

        return TOTP::create($secret)->verify($this->parameters->get('totp'));
    }
}
