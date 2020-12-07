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

    private ApplicationState $applicationState;
    private WebAuthnService $webAuthn;
    private UserWriter $writer;
    private JsonPostRequest $request;

    public function __construct(ApplicationState $applicationState, WebAuthnService $webAuthn, UserWriter $writer, JsonPostRequest $request) {
        $this->applicationState = $applicationState;
        $this->webAuthn = $webAuthn;
        $this->writer = $writer;
        $this->request = $request;
    }

    public function execute(): Result {
        $json = $this->request->body();
        $clientDataJSON = \base64_decode($json->get('clientDataJSON'));
        $attestationObject = \base64_decode($json->get('attestationObject'));

        $challenge = $this->applicationState->webAuthnChallenge();

        $result = $this->webAuthn->register($clientDataJSON, $attestationObject, $challenge);

        if (!$result->isSuccess()) {
            \assert($result instanceof RegistrationFailed);
            return new ContentResult(
                new Content('text/plain', $result->error())
            );
        }

        assert($result instanceof Registration);
        $this->writer->updateWebAuthRegistration(
            $this->applicationState->loginUser(),
            $result
        );

        return new ContentResult(
            new Content('application/json', \json_encode([
                'success' => true,
                'msg' => 'Successfully registered.'
            ], JSON_THROW_ON_ERROR))
        );
    }

}
