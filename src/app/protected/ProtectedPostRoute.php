<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\Executable;
use theseer\framework\http\PostRoute;
use theseer\framework\http\Request;

abstract class ProtectedPostRoute extends PostRoute {

    private ApplicationState $applicationState;

    public function __construct(ApplicationState $applicationState) {
        $this->applicationState = $applicationState;
    }

    protected function buildExecutable(Request $request): Executable {
        if (!$this->applicationState->isLoggedIn()) {
            return new LoginRequired();
        }

        return parent::buildExecutable($request);
    }

}
