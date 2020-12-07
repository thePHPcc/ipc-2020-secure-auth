<?php declare(strict_types = 1);
namespace theseer\application;

class StubUserReader implements UserReader {

    public function findByUsernameAndPassword(string $username, string $passwd): ?User {
        if ($username === 'root' && $passwd === 'secret') {
            return new User('root');
        }

        return null;
    }

}
