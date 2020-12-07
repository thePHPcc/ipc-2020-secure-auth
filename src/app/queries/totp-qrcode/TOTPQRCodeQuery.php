<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\application\totp\QRCodeGenerator;
use theseer\application\totp\TOTP;
use theseer\framework\http\Content;
use theseer\framework\http\ContentResult;
use theseer\framework\http\Query;
use theseer\framework\http\Result;

class TOTPQRCodeQuery implements Query {

    private TOTP $totp;
    private QRCodeGenerator $generator;

    public function __construct(TOTP $totp, QRCodeGenerator $generator) {
        $this->totp = $totp;
        $this->generator = $generator;
    }

    public function execute(): Result {
        return new ContentResult(
            new Content(
            'image/png',
                $this->generator->generate($this->totp->provisioningUri('Workshop'))
            )
        );
    }

}
