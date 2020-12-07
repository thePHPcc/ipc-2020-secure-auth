<?php declare(strict_types = 1);
namespace theseer\application;

use PDO;
use PDOException;
use RuntimeException;
use theseer\application\webauthn\Registration;

class PdoUserWriter implements UserWriter {

    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function updateWebAuthRegistration(User $user, Registration $result) {
        $query = $this->pdo->prepare('Update users set webauthn = :webauthn where login = :login');
        $res = $query->execute([
            ':login' => $user->login(),
            ':webauthn' => \serialize($result->webAuthnData())
        ]);

        if (!$res) {
            throw new RuntimeException(
                sprintf('PDO Error %d: %s', $query->errorCode(), $query->errorInfo())
            );
        }

        if ($query->rowCount() !== 1) {
            throw new RuntimeException(
                sprintf('PDO Error: Unexpected amount of rows affected')
            );
        }
    }

    public function updateSharedSecret(User $user, string $sharedSecret): void {
        $query = $this->pdo->prepare('Update users set secret = :secret where login = :login');
        $res = $query->execute([
            ':login' => $user->login(),
            ':secret' => $sharedSecret
        ]);

        if (!$res) {
            throw new RuntimeException(
                sprintf('PDO Error %d: %s', $query->errorCode(), $query->errorInfo())
            );
        }

        if ($query->rowCount() !== 1) {
            throw new RuntimeException(
                sprintf('PDO Error: Unexpected amount of rows affected')
            );
        }

    }

}
