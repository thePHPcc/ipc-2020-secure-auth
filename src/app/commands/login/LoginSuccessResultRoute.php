<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\RedirectResultRenderer;
use theseer\framework\http\Result;
use theseer\framework\http\ResultRenderer;
use theseer\framework\http\ResultRouteTemplate;
use theseer\framework\Url;

class LoginSuccessResultRoute extends ResultRouteTemplate {

    protected function matches(Result $result): bool {
        return $result instanceof LoginSuccessResult;
    }

    protected function buildResultRenderer(Result $result): ResultRenderer {
        return new RedirectResultRenderer(new Url('/inside'));
    }

}
