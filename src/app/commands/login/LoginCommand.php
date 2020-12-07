<?php declare(strict_types = 1);
namespace theseer\application;

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


        $user = $this->userReader->findByUsernameAndPassword(
            $this->parameters->has('username') ? $this->parameters->get('username') : '',
            $this->parameters->has('password') ? $this->parameters->get('password') : '',
        );

        if (!$user) {
            return new LoginFailedResult();
        }

        $this->applicationState->setLoginUser($user);

        return new LoginSuccessResult();
    }

    private function ensureValidCsrfToken(): void
    {
        if (!$this->applicationState->csrfToken()->isCorrect($this->parameters->get('TOK'))) {
            throw new BadRequestException('Invalid CSRF Token supplied');
        }
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

}
