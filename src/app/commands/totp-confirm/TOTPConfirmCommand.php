<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\application\totp\Generator;
use theseer\framework\http\Command;
use theseer\framework\http\Parameters;
use theseer\framework\http\Result;

class TOTPConfirmCommand implements Command {

    private Parameters $parameters;
    private ApplicationState $applicationState;
    private Generator $generator;
    private UserWriter $writer;

    public function __construct(ApplicationState $state, Generator $generator, UserWriter $writer, Parameters $paramters) {
        $this->applicationState = $state;
        $this->generator = $generator;
        $this->writer = $writer;
        $this->parameters = $paramters;
    }

    public function execute(): Result {
        $this->ensureRequiredFieldsPresent();
        $this->ensureValidCsrfToken();

        $totp = $this->generator->generate($this->applicationState->TOTPSecret());
        if (!$totp->isCorrect($this->parameters->get('totp'))) {
            return new TOTPConfirmationFailedResult();
        }

        $this->writer->updateSharedSecret(
            $this->applicationState->loginUser(),
            $totp->sharedSecret()
        );

        return new TOTPConfirmedResult();
    }

    private function ensureRequiredFieldsPresent() {
        if (!$this->parameters->has('TOK')) {
            throw new BadRequestException('No CSRF Token supplied');
        }
        if (!$this->parameters->has('totp')) {
            throw new BadRequestException('No Username supplied');
        }
    }

    private function ensureValidCsrfToken(): void {
        if (!$this->applicationState->csrfToken()->isCorrect($this->parameters->get('TOK'))) {
            throw new BadRequestException('Invalid CSRF Token supplied');
        }
    }

}
