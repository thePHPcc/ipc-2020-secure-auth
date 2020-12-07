<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\application\webauthn\WebAuthnService;
use theseer\framework\http\Content;
use theseer\framework\http\ContentResult;
use theseer\framework\http\Query;
use theseer\framework\http\Result;
use theseer\framework\Json;

class RegisterOptionsQuery implements Query {

    public function execute(): Result {

        return new ContentResult(new Content('text/plain', '...'));
    }

}
