<?php declare(strict_types = 1);
namespace theseer\application;

use PDO;
use RuntimeException;
use SQLite3;
use theseer\framework\Application;
use theseer\framework\Environment;
use theseer\framework\http\NotFoundRoute;
use theseer\framework\page\PageFileLoader;
use theseer\framework\TokenGenerator;

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

    private function createQueryFactory() {
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

    private function createCommandFactory() {
        return new CommandFactory(
            $this,
            $this->getApplicationState()
        );
    }

    public function createUserReader(): UserReader {
        $pdo = new PDO($this->configuration->getUserDatabaseFile());
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return new PdoUserReader($pdo);
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
}
