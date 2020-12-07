<?php declare(strict_types = 1);
namespace theseer\application;

class User {

    private string $login;

    private string $passwdHash;

    private string $totpSecret;

    public function __construct(string $login, string $passwdHash, string $totpSecret) {
        $this->login = $login;
        $this->passwdHash = $passwdHash;
        $this->totpSecret = $totpSecret;
    }

    public function login(): string {
        return $this->login;
    }

    public function passwdHash(): string {
        return $this->passwdHash;
    }

    public function totpSecret(): string {
        return $this->totpSecret;
    }
}
