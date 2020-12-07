<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\Response;
use theseer\framework\SessionId;

class StateAwareResponse implements Response {

    private SessionId $sessionId;
    private Response $outerResponse;
    private bool $withSecureFlag;

    public function __construct(SessionId $sessionId, bool $withSecureFlag, Response $response) {
        $this->outerResponse  = $response;
        $this->sessionId      = $sessionId;
        $this->withSecureFlag = $withSecureFlag;
    }

    public function body(): string {
        return $this->outerResponse->body();
    }

    public function flush(): void {
        \setcookie(
            'SID',
            $this->sessionId->asString(),
            ['path' => '/', 'secure' => $this->withSecureFlag, 'httponly' => true, 'samesite' => 'Strict']
        );

        $this->outerResponse->flush();
    }
}
