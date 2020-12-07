<?php declare(strict_types = 1);
namespace theseer\application;

use Templado\Engine\SimpleSnippet;
use theseer\framework\http\Query;
use theseer\framework\http\Result;
use theseer\framework\page\Page;
use theseer\framework\page\PageResult;

class InsideQuery implements Query {

    private User $loginUser;
    private Page $page;

    public function __construct(User $loginUser, Page $page) {
        $this->loginUser = $loginUser;
        $this->page = $page;
    }

    public function execute(): Result {
        $this->page->applySnippet(
            new SimpleSnippet('userinfo', new \DOMText($this->loginUser->login()))
        );

        return new PageResult($this->page);
    }

}
