<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\Executable;
use theseer\framework\http\Result;

class LoginRequired implements Executable {

    public function execute(): Result {
        return new LoginRequiredResult();
    }

}
