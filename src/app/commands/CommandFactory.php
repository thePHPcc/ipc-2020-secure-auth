<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\Parameters;

class CommandFactory {

    private Factory $factory;
    private ApplicationState $applicationState;

    public function __construct(Factory $factory, ApplicationState $applicationState) {
        $this->factory = $factory;
        $this->applicationState = $applicationState;
    }

    public function buildLoginCommand(Parameters $parameters) {
        return new LoginCommand(
            $parameters,
            $this->applicationState,
            $this->factory->createUserReader()
        );
    }
}
