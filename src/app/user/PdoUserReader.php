<?php declare(strict_types = 1);
namespace theseer\application;

use PDO;
use PDOException;
use RuntimeException;

class PdoUserReader implements UserReader {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function findByUsernameAndPassword(string $username, string $passwd): ?User {
        $query = $this->pdo->prepare(
                'select login from users where login=:login and passwd=:passwd'
        );

        try {

            $res = $query->execute([
                ':login' => $username,
                ':passwd' => $passwd
            ]);

            if (!$res) {
                throw new RuntimeException(
                    sprintf('PDO Error %d: %s', $query->errorCode(), $query->errorInfo())
                );
            }

            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new RuntimeException(
                sprintf('PDO Error %d: %s', $e->getCode(), $e->getMessage()),
                $e->getCode(),
                $e
            );
        }

        if (count($data) !== 1) {
            return null;
        }

        return new User($data[0]['login']);
    }
}
