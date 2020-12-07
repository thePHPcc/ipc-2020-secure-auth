<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\GetRequest;
use theseer\framework\page\Page;
use theseer\framework\page\PageQuery;

class QueryFactory {

    private ApplicationState $applicationState;
    private Factory $factory;

    public function __construct(Factory $factory, ApplicationState $applicationState) {
        $this->applicationState = $applicationState;
        $this->factory = $factory;
    }

    public function createPageQuery(GetRequest $request, Page $page) {
        return new PageQuery($request, $page, $this->applicationState->csrfToken());
    }

    public function createInsideQuery() {
        return new InsideQuery(
            $this->applicationState->loginUser(),
            $this->factory->createpageFileLoader()->load('inside.xhtml')
        );
    }

    public function createTOTPSetupQuery() {
        return new TOTPSetupQuery(
            $this->applicationState,
            $this->factory->createTOTPGenerator()->generate(),
            $this->factory->createpageFileLoader()->load('totp-setup.xhtml')
        );
    }

    public function createTOTPQRCodeQuery() {
        return new TOTPQRCodeQuery(
            $this->factory->createTOTPGenerator()->generate($this->applicationState->TOTPSecret()),
            $this->factory->createQRCodeGenerator()
        );
    }

    public function createWebAuthnRegisterOptionsQuery() {
        return new RegisterOptionsQuery(
            $this->applicationState,
            $this->factory->createWebAuthnService()
        );
    }
}
