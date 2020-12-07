<?php declare(strict_types = 1);
namespace theseer\application;

class User {

    private string $login;

    private string $passwdHash;

    public function __construct(string $login, string $passwdHash) {
        $this->login = $login;
        $this->passwdHash = $passwdHash;
    }

    public function login(): string {
        return $this->login;
    }

    public function passwdHash(): string {
        return $this->passwdHash;
    }

}
