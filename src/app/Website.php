<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\Application;
use theseer\framework\http\ContentResultRoute;
use theseer\framework\http\NotFoundResultRoute;
use theseer\framework\http\Request;
use theseer\framework\http\RequestRouter;
use theseer\framework\http\Response;
use theseer\framework\http\ResultRouter;
use theseer\framework\page\PageResultRoute;

class Website implements Application {

    private Factory $factory;
    private ApplicationStateService $stateService;

    public function __construct(ApplicationStateService $stateService, Factory $factory) {
        $this->factory      = $factory;
        $this->stateService = $stateService;
    }

    public function setUp(Request $request): void {
        $this->factory->setApplicationState(
            $this->stateService->load($request)
        );
    }

    public function tearDown(Response $response): Response {
        return $this->stateService->save($response);
    }

    public function registerRequestRoutes(RequestRouter $router): void {
        $router->addRoute($this->factory->createStaticPagesRoute());
        $router->addRoute($this->factory->createLoginRoute());
        $router->addRoute($this->factory->createInsideRoute());

        $router->addRoute($this->factory->createTOTPSetupRoute());
        $router->addRoute($this->factory->createTOTPQRCodeRoute());
        $router->addRoute($this->factory->createTOTPConfirmRoute());

        $router->addRoute($this->factory->createWebAuthnRegisterOptionsRoute());
        $router->addRoute($this->factory->createWebAuthnRegisterRoute());

        $router->addRoute($this->factory->createNotFoundRoute());
    }

    public function registerResultRoutes(ResultRouter $router): void {
        $router->addRoute(new PageResultRoute());
        $router->addRoute(new ContentResultRoute());

        $router->addRoute(new LoginSuccessResultRoute());
        $router->addRoute($this->factory->createLoginFailedResultRoute());

        $router->addRoute(new LoginRequiredResultRoute());
        $router->addRoute(new NotFoundResultRoute());

        $router->addRoute(new TOTPConfirmedResultRoute());
    }
}
