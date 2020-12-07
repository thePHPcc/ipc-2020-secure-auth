<?php declare(strict_types = 1);
namespace theseer\application;

use DateTimeImmutable;
use theseer\framework\http\Request;
use theseer\framework\http\Response;
use theseer\framework\SessionId;
use theseer\framework\TokenGenerator;
use theseer\framework\Url;

class ApplicationStateService {

    private ApplicationStateStore $store;
    private ApplicationState $state;
    private Url $currentUrl;
    private DateTimeImmutable $requestTime;
    private TokenGenerator $generator;
    private bool $secure;

    public function __construct(ApplicationStateStore $store, TokenGenerator $generator, bool $secure) {
        $this->store     = $store;
        $this->generator = $generator;
        $this->secure    = $secure;
    }

    public function load(Request $request): ApplicationState {
        $this->requestTime = $request->time();
        $this->currentUrl  = $request->url();

        if (!$request->hasCookie('SID')) {
            return $this->initializeState();
        }

        $sid = new SessionId($request->cookie('SID'));

        if (!$this->store->has($sid)) {
            return $this->initializeState();
        }

        return $this->loadExisting($sid);
    }

    public function save(Response $response): Response {
        $this->state->setPreviousUrl($this->currentUrl);
        $this->state->setPreviousRequestTime($this->requestTime);

        $this->store->write($this->state);

        return new StateAwareResponse(
            $this->state->sessionId(),
            $this->secure,
            $response
        );
    }

    private function initializeState(): ApplicationState {
        $this->state = new ApplicationState(
            $this->generator->generateSessionId(),
            $this->generator->generateCSRFToken(),
        );

        return $this->state;
    }

    private function loadExisting(SessionId $sid): ApplicationState {
        $this->state = $this->store->read($sid);

        return $this->state;
    }
}
