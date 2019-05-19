<?php

namespace Modules\Comparator\Helpers;

use Modules\Comparator\Interfaces\RepositoryInterface;

class RepositoryService
{
    private $finder;

    public function __construct(RepositoryInterface $finder)
    {
        $this->finder = $finder;
    }

    public function find(string $name)
    {
        return $this->finder->find($name);
    }
}