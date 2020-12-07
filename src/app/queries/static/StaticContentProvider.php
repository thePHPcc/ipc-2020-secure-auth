<?php declare(strict_types=1);
namespace theseer\application;

use theseer\framework\http\Content;
use theseer\framework\http\ContentProvider;

class StaticContentProvider implements ContentProvider
{
    public function getNotFoundContent(array $acceptedLanguages): Content
    {
        return new Content('text/plain', 'Requested path not found');
    }

}
