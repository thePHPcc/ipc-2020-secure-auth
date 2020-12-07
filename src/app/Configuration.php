<?php declare(strict_types = 1);
namespace theseer\application;

use DateTimeImmutable;

class Configuration {

    private DateTimeImmutable $serverTime;

    public static function build(): self {
        $requestTime = DateTimeImmutable::createFromFormat('U.u', (string)$_SERVER['REQUEST_TIME_FLOAT'])
            ?: new DateTimeImmutable('now');

        return new self($requestTime);
    }

    public function staticPages(): StaticMap {
        return new StaticMap([
            '/' => 'index.xhtml',
            '/totp-confirmed' => 'totp-confirmed.xhtml'
        ]);
    }

    public function pagesDirectory(): string {
        return __DIR__ . '/../../pages';
    }

    public function getUserDatabaseFile(): string {
        $dbFile = dirname(__DIR__, 2) . '/data/users.sqlite';

        return 'sqlite:' . $dbFile;
    }

    public function getWebAuthnDomain(): string {
        return 'secure.local.netpirates.net';
    }

    private function __construct(DateTimeImmutable $serverTime) {
        $this->serverTime = $serverTime;
    }

    public function serverTime(): DateTimeImmutable {
        return $this->serverTime;
    }

    public function stateStoreDirectory(): string {
        return '/tmp';
    }
}
