<?php declare(strict_types = 1);
namespace theseer\application;

class User {

    private string $login;

    public function __construct(string $login) {
        $this->login = $login;
    }

    public function login(): string {
        return $this->login;
    }

}
