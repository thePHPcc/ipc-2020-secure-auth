<?php declare(strict_types = 1);
namespace theseer\application;

use DOMText;
use Templado\Engine\SimpleSnippet;
use theseer\framework\http\Result;
use theseer\framework\http\ResultRenderer;
use theseer\framework\http\ResultRouteTemplate;
use theseer\framework\page\PageFileLoader;
use theseer\framework\page\PageResultRenderer;
use theseer\framework\TokenGenerator;

class LoginFailedResultRoute extends ResultRouteTemplate {

    private PageFileLoader $loader;
    private ApplicationState $applicationState;
    private TokenGenerator $generator;

    public function __construct(PageFileLoader $loader, ApplicationState $applicationState, TokenGenerator $generator) {
        $this->loader = $loader;
        $this->applicationState = $applicationState;
        $this->generator = $generator;
    }

    protected function matches(Result $result): bool {
        return $result instanceof LoginFailedResult;
    }

    protected function buildResultRenderer(Result $result): ResultRenderer {
        $this->applicationState->updateCsrfToken(
            $this->generator->generateCSRFToken()
        );

        $page = $this->loader->load('index.xhtml');
        $page->applyCsrfToken(
            $this->applicationState->csrfToken()
        );

        $page->applySnippet(
            new SimpleSnippet('info', new DOMText('Login failed!'))
        );

        return new PageResultRenderer($page);
    }

}
