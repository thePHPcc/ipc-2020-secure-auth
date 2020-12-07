<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\application\webauthn\WebAuthnService;
use theseer\framework\http\Content;
use theseer\framework\http\ContentResult;
use theseer\framework\http\Query;
use theseer\framework\http\Result;

class RegisterOptionsQuery implements Query {

    private ApplicationState $applicationState;
    private WebAuthnService $webAuthn;

    public function __construct(ApplicationState $applicationState, WebAuthnService $webAuthn) {
        $this->applicationState = $applicationState;
        $this->webAuthn = $webAuthn;
    }

    public function execute(): Result {
        $options = $this->webAuthn->registrationOptions(
            $this->applicationState->loginUser()
        );

        $this->applicationState->setWebauthChallenge(
            $options->challenge()
        );

        return new ContentResult($options->toJsonContent());
    }

}
