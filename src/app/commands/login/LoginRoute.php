<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\Command;
use theseer\framework\http\PostRequest;
use theseer\framework\http\PostRoute;
use theseer\framework\http\Request;
use theseer\framework\Url;

class LoginRoute extends PostRoute {

    private CommandFactory $factory;

    public function __construct(CommandFactory $factory) {
        $this->factory = $factory;
    }

    protected function matches(Request $request): bool {
        return $request->url()->equals(new Url('/login'));
    }

    protected function buildCommand(PostRequest $request): Command {
        return $this->factory->buildLoginCommand($request->parameters());
    }

}
