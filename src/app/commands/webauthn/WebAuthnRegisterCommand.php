<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\application\webauthn\Registration;
use theseer\application\webauthn\RegistrationFailed;
use theseer\application\webauthn\WebAuthnService;
use theseer\framework\http\Command;
use theseer\framework\http\Content;
use theseer\framework\http\ContentResult;
use theseer\framework\http\JsonPostRequest;
use theseer\framework\http\Result;

class WebAuthnRegisterCommand implements Command {

    public function execute(): Result {
        return new ContentResult(
            new Content('application/json', \json_encode([
                'success' => true,
                'msg' => 'Successfully registered.'
            ], JSON_THROW_ON_ERROR))
        );
    }

}
