<?php declare(strict_types = 1);
namespace theseer\application;

use theseer\framework\http\GetRequest;
use theseer\framework\http\GetRoute;
use theseer\framework\http\Query;
use theseer\framework\http\Request;
use theseer\framework\page\PageFileLoader;

class StaticPageRoute extends GetRoute {

    private StaticMap $staticPages;
    private QueryFactory $factory;

    /**
     * @var PageFileLoader
     */
    private PageFileLoader $loader;

    public function __construct(QueryFactory $factory, PageFileLoader $loader, StaticMap $staticPages) {
        $this->staticPages = $staticPages;
        $this->loader = $loader;
        $this->factory = $factory;
    }

    protected function matches(Request $request): bool {
        return $this->staticPages->has(
            $request->url()
        );
    }

    protected function buildQuery(GetRequest $request): Query {

        return $this->factory->createPageQuery(
            $request,
            $this->loader->load(
                $this->staticPages->get($request->url())
            )
        );
    }

}
