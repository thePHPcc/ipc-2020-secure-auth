<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\JsonPostRequest;
use theseer\framework\http\Parameters;

class CommandFactory {

    private Factory $factory;
    private ApplicationState $applicationState;

    public function __construct(Factory $factory, ApplicationState $applicationState) {
        $this->factory = $factory;
        $this->applicationState = $applicationState;
    }

    public function buildLoginCommand(Parameters $parameters): LoginCommand {
        return new LoginCommand(
            $parameters,
            $this->applicationState,
            $this->factory->createUserReader()
        );
    }

    public function buildTOTPConfirmCommand(Parameters $parameters) {
        return new TOTPConfirmCommand(
            $this->applicationState,
            $this->factory->createTOTPGenerator(),
            $this->factory->createUserWriter(),
            $parameters
        );
    }

    public function createWebAuthnRegisterCommand(JsonPostRequest $request): WebAuthnRegisterCommand {
        return new WebAuthnRegisterCommand(
            $this->applicationState,
            $this->factory->createWebAuthnService(),
            $this->factory->createUserWriter(),
            $request
        );
    }
}
