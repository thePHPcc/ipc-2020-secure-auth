<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\SessionId;

class ApplicationStateStore {

    private string $workDirectory;

    public function __construct(string $workDirectory) {
        $this->workDirectory = $workDirectory;
    }

    public function write(ApplicationState $state): void {
        $filename = $this->getFilename($state->sessionId());
        \file_put_contents($filename, \serialize($state));
    }

    public function has(SessionId $sessionId): bool {
        $filename = $this->getFilename($sessionId);
        \clearstatcache(true, $filename);

        return \file_exists($filename);
    }

    public function read(SessionId $sessionId): ApplicationState {
        if (!$this->has($sessionId)) {
            throw new ApplicationStateException(
                \sprintf('No file for session with id %s', $sessionId->asString())
            );
        }
        $filename = $this->getFilename($sessionId);

        return \unserialize(
            \file_get_contents($filename),
            [ApplicationState::class]
        );
    }

    private function getFilename(SessionId $sessionId): string {
        return $this->workDirectory . '/' . $sessionId->asString() . '.session';
    }
}
