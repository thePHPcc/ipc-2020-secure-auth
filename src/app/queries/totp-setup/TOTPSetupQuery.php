<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\application\totp\TOTP;
use theseer\framework\http\Query;
use theseer\framework\http\Result;
use theseer\framework\page\Page;
use theseer\framework\page\PageResult;

class TOTPSetupQuery implements Query {

    private ApplicationState $state;
    private TOTP $totp;
    private Page $page;

    public function __construct(ApplicationState $state, TOTP $totp, Page $page) {
        $this->state = $state;
        $this->totp = $totp;
        $this->page = $page;
    }

    public function execute(): Result {
        $this->state->setTOTPSecret($this->totp->sharedSecret());
        $this->page->applyCsrfToken(
            $this->state->csrfToken()
        );
        return new PageResult($this->page);
    }

}
