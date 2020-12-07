<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\application\webauthn\WebAuthnService;
use theseer\framework\http\Content;
use theseer\framework\http\ContentResult;
use theseer\framework\http\Parameters;
use theseer\framework\http\Query;
use theseer\framework\http\Result;

class   LoginOptionsQuery implements Query {

    private ApplicationState $applicationState;
    private WebAuthnService $webAuthn;
    private UserReader $reader;
    private Parameters $parameters;

    public function execute(): Result {
        if (!$this->parameters->has('user') || $this->parameters->get('user') === '') {
            return new ContentResult(
                new Content('application/json', '{error:"No user specified"}')
            );
        }

        $user = $this->reader->findByUsername(
            $this->parameters->get('user')
        );

        if ($user === null) {
            return new ContentResult(
                new Content('application/json', '{error:"User not found"}')
            );
        }

        $options = $this->webAuthn->loginOptions($user);
        $this->applicationState->setWebauthChallenge($options->challenge());

        return new ContentResult($options->toJsonContent());
    }

}
