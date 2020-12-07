<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\BadRequestResult;
use theseer\framework\http\Command;
use theseer\framework\http\Executable;
use theseer\framework\http\GetRequest;
use theseer\framework\http\JsonPostRequest;
use theseer\framework\http\MethodNotAllowedExecutable;
use theseer\framework\http\PostRequest;
use theseer\framework\http\Query;
use theseer\framework\http\Request;
use theseer\framework\Url;

class WebAuthnRegisterRoute extends ProtectedPostRoute {

    private CommandFactory $factory;

    public function __construct(CommandFactory $factory, ApplicationState $applicationState) {
        $this->factory = $factory;
        parent::__construct($applicationState);
    }

    protected function buildExecutable(Request $request): Executable {
        if (!$request->isJson()) {
            return new MethodNotAllowedExecutable();
        }

        return parent::buildExecutable($request);
    }

    protected function matches(Request $request): bool {
        return $request->url()->equals(new Url('/webauthn/register'));
    }

    protected function buildCommand(PostRequest $request): Command {
        /** @var JsonPostRequest $request */
        return $this->factory->createWebAuthnRegisterCommand($request);
    }

}
