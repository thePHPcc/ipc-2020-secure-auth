<?php declare(strict_types = 1);
namespace theseer\application\webauthn;

use stdClass;
use theseer\framework\http\Content;

class Options {

    private stdClass $options;
    private string $challenge;

    public function __construct(stdClass $options, string $challenge) {
        $this->options = $options;
        $this->challenge = $challenge;
    }

    public function challenge(): string {
        return $this->challenge;
    }

    public function toJsonContent(): Content {
        return new Content('application/json', $this->toJson());
    }

    private function toJson(): string {
        return \json_encode($this->options);
    }

}
