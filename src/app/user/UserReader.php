<?php declare(strict_types = 1);
namespace theseer\application;

interface UserReader {
    public function findByUsernameAndPassword(string $username, string $passwd): ?User;
}
