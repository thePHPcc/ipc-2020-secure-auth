<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\Environment;
use theseer\framework\Runner;

require __DIR__ . '/autoload.php';

Runner::build()->run(
    (new Factory(
        Environment::fromGlobalState(),
        Configuration::build()
    ))->createApplication()
)->flush();
