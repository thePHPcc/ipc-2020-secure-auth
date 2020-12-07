<?php declare(strict_types = 1);
namespace theseer\application;

use DateTimeImmutable;
use theseer\framework\CSRFToken;
use theseer\framework\SessionId;
use theseer\framework\Url;

class ApplicationState {

    private SessionId $sessionId;
    private CSRFToken $csrfToken;
    private ?Url $previousUrl = null;
    private ?DateTimeImmutable $previousRequestTime = null;
    private ?User $loginUser = null;
    private ?string $sharedSecret = null;
    private ?string $webauthChallenge = null;

    public function __construct(SessionId $sessionId, CSRFToken $token) {
        $this->sessionId = $sessionId;
        $this->csrfToken = $token;
    }

    public function sessionId(): SessionId {
        return $this->sessionId;
    }

    public function csrfToken(): CSRFToken {
        return $this->csrfToken;
    }

    public function hasPreviousUrl(): bool {
        return $this->previousUrl !== null;
    }

    public function previousUrl(): Url {
        if ($this->previousUrl === null) {
            throw new ApplicationStateException('No previous URL set');
        }

        return $this->previousUrl;
    }

    public function previousRequestTime(): DateTimeImmutable {
        if ($this->previousRequestTime === null) {
            throw new ApplicationStateException('No previous RequestTime set');
        }

        return $this->previousRequestTime;
    }

    public function setPreviousUrl(Url $previous): void {
        $this->previousUrl = $previous;
    }

    public function setPreviousRequestTime(DateTimeImmutable $timestamp): void {
        $this->previousRequestTime = $timestamp;
    }

    public function updateCsrfToken(CSRFToken $token): void {
        $this->csrfToken = $token;
    }

    public function setLoginUser(User $user) {
        $this->loginUser = $user;
    }

    public function isLoggedIn(): bool {
        return $this->loginUser !== null;
    }

    public function loginUser(): User {
        if (!$this->isLoggedIn()) {
            throw new ApplicationStateException('No previous RequestTime set');
        }

        return $this->loginUser;
    }

    public function setTOTPSecret(string $sharedSecret): void {
        $this->sharedSecret = $sharedSecret;
    }

    public function hasTOTPSecret(): bool {
        return $this->sharedSecret !== null;
    }

    public function TOTPSecret(): string {
        if (!$this->hasTOTPSecret()) {
            throw new ApplicationStateException('No TOTP Secret available');
        }

        return $this->sharedSecret;
    }

    public function setWebauthChallenge(string $challenge) {
        $this->webauthChallenge = $challenge;
    }

    public function hasWebAuthnChallenge(): bool {
        return $this->webauthChallenge !== null;
    }

    public function webAuthnChallenge(): string {
        if (!$this->hasWebAuthnChallenge()) {
            throw new ApplicationStateException('No WebAuthn challenge set');
        }

        return $this->webauthChallenge;
    }

}
