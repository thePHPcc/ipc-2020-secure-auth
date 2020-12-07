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

    public function findByUsername(string $username): ?User {
        $query = $this->pdo->prepare(
                'select login, passwd, secret from users where login=:login'
        );

        try {

            $res = $query->execute([
                ':login' => $username
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

        return new User(
            $data[0]['login'],
            $data[0]['passwd'],
            $data[0]['secret']
        );
    }
}
