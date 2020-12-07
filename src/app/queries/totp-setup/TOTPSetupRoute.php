<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\GetRequest;
use theseer\framework\http\Query;
use theseer\framework\http\Request;
use theseer\framework\Url;

class TOTPSetupRoute extends ProtectedGetRoute {

    private QueryFactory $factory;

    public function __construct(QueryFactory $factory, ApplicationState $applicationState) {
        $this->factory = $factory;

        parent::__construct($applicationState);
    }

    protected function matches(Request $request): bool {
        return $request->url()->equals(new Url('/totp-setup'));
    }

    protected function buildQuery(GetRequest $request): Query {
        return $this->factory->createTOTPSetupQuery();
    }

}
