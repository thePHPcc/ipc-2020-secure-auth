<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\Url;

class StaticMap {

    private array $entries;

    public function __construct(array $entries) {
        $this->entries = $entries;
    }

    public function has(Url $url): bool {
        return isset($this->entries[$url->asString()]);
    }

    public function get(Url $url): string {
        if (!$this->has($url)) {
            throw new StaticMapException('Not found.');
        }

        return $this->entries[$url->asString()];
    }
}
