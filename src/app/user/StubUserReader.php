<?php declare(strict_types = 1);
namespace theseer\application;

class StubUserReader implements UserReader {

    public function findByUsername(string $username): ?User {
        if ($username === 'root') {
            return new User('root');
        }

        return null;
    }

}
