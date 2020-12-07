<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\GetRequest;
use theseer\framework\http\GetRoute;
use theseer\framework\http\Query;
use theseer\framework\http\Request;
use theseer\framework\Url;

class LoginOptionsRoute extends GetRoute {

    private QueryFactory $factory;

    public function __construct(QueryFactory $factory) {
        $this->factory = $factory;
    }

    protected function matches(Request $request): bool {
        return $request->url()->equals(new Url('/webauthn/options'));
    }

    protected function buildQuery(GetRequest $request): Query {
        return $this->factory->createWebAuthnLoginOptionsQuery($request);
    }

}
