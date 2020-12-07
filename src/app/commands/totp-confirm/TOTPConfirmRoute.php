<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\Command;
use theseer\framework\http\PostRequest;
use theseer\framework\http\Request;
use theseer\framework\Url;

class TOTPConfirmRoute extends ProtectedPostRoute {

    private CommandFactory $factory;

    public function __construct(CommandFactory $factory, ApplicationState $state) {
        $this->factory = $factory;

        parent::__construct($state);
    }

    protected function matches(Request $request): bool {
        return $request->url()->equals(new Url('/totp-confirm'));
    }

    protected function buildCommand(PostRequest $request): Command {
        return $this->factory->buildTOTPConfirmCommand($request->parameters());
    }

}
