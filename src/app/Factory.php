<?php declare(strict_types = 1);
namespace theseer\application;

use PDO;
use RuntimeException;
use theseer\application\totp\BaconQrCodeGenerator;
use theseer\application\totp\SpomkyLabsGenerator;
use theseer\application\webauthn\WebAuthnService;
use theseer\framework\Application;
use theseer\framework\Environment;
use theseer\framework\http\NotFoundRoute;
use theseer\framework\page\PageFileLoader;
use theseer\framework\TokenGenerator;
use theseer\application\totp\Generator;
use WebAuthn\WebAuthn;

class Factory {

    private ?ApplicationStateService $applicationStateService = null;
    private ?ApplicationState $applicationState = null;
    private Configuration $configuration;
    private Environment $environment;

    public function __construct(Environment $environment, Configuration $configuration) {
        $this->environment   = $environment;
        $this->configuration = $configuration;
    }

    public function createApplication(): Application {
        return new Website($this->createApplicationStateService(), $this);
    }

    public function createApplicationStateService(): ApplicationStateService {
        if ($this->applicationStateService === null) {
            $this->applicationStateService = new ApplicationStateService(
                $this->createStateStore(),
                $this->createTokenGenerator(),
                $this->environment->isHTTPS()
            );
        }

        return $this->applicationStateService;
    }

    public function setApplicationState(ApplicationState $state): void {
        $this->applicationState = $state;
    }

    private function createStateStore(): ApplicationStateStore {
        return new ApplicationStateStore($this->configuration->stateStoreDirectory());
    }

    public function createNotFoundRoute(): NotFoundRoute {
        return new NotFoundRoute(
            new StaticContentProvider()
        );
    }

    public function createStaticPagesRoute(): StaticPageRoute {

        return new StaticPageRoute(
            $this->createQueryFactory(),
            $this->createPageFileLoader(),
            $this->configuration->staticPages()
        );
    }

    public function createLoginRoute(): LoginRoute {
        return new LoginRoute(
            $this->createCommandFactory()
        );
    }

    private function getApplicationState(): ApplicationState {
        if ($this->applicationState === null) {
            throw new RuntimeException('No Application state set');
        }

        return $this->applicationState;
    }

    private function createTokenGenerator(): TokenGenerator {
        return new TokenGenerator($this->configuration->serverTime());
    }

    private function createQueryFactory(): QueryFactory {
        return new QueryFactory(
            $this,
            $this->getApplicationState()
        );
    }

    public function createPageFileLoader(): PageFileLoader {
        return new PageFileLoader(
            $this->configuration->pagesDirectory()
        );
    }

    private function createCommandFactory(): CommandFactory {
        return new CommandFactory(
            $this,
            $this->getApplicationState()
        );
    }

    public function createUserReader(): UserReader {
        return new PdoUserReader($this->createPdo());
    }

    public function createLoginFailedResultRoute(): LoginFailedResultRoute {
        return new LoginFailedResultRoute(
            $this->createPageFileLoader(),
            $this->applicationState,
            $this->createTokenGenerator()
        );
    }

    public function createInsideRoute(): InsideRoute {
        return new InsideRoute(
            $this->createQueryFactory(),
            $this->getApplicationState()
        );
    }

    public function createTOTPGenerator(): Generator {
        return new SpomkyLabsGenerator();
    }

    public function createQRCodeGenerator(): BaconQrCodeGenerator {
        return new BaconQrCodeGenerator();
    }

    public function createTOTPSetupRoute(): TOTPSetupRoute {
        return new TOTPSetupRoute(
            $this->createQueryFactory(),
            $this->getApplicationState()
        );
    }

    public function createTOTPQRCodeRoute(): TOTPQRCodeRoute {
        return new TOTPQRCodeRoute(
            $this->createQueryFactory(),
            $this->getApplicationState()
        );
    }

    public function createUserWriter(): PdoUserWriter {
        return new PdoUserWriter(
            $this->createPdo()
        );
    }

    private function createPdo(): PDO {
        $pdo = new PDO($this->configuration->getUserDatabaseFile());
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public function createTOTPConfirmRoute(): TOTPConfirmRoute {
        return new TOTPConfirmRoute(
            $this->createCommandFactory(),
            $this->getApplicationState()
        );
    }

    public function createWebAuthnService(): WebAuthnService {
        $webAuthn = new WebAuthn(
            'Secure Authentication Workshop',
            $this->configuration->getWebAuthnDomain(),
            ['none']
        );

        return new WebAuthnService($webAuthn);
    }

    public function createWebAuthnRegisterOptionsRoute() {
        return new RegisterOptionsRoute(
            $this->createQueryFactory(),
            $this->getApplicationState()
        );
    }

    public function createWebAuthnRegisterRoute() {
        return new WebAuthnRegisterRoute(
            $this->createCommandFactory(),
            $this->getApplicationState()
        );
    }

    public function createWebAuthnLoginOptionsRoute() {
        return new LoginOptionsRoute(
            $this->createQueryFactory()
        );
    }
}
