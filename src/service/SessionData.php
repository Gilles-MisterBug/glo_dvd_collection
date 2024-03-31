<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class SessionData
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function getData(string $name): mixed
    {
        return $this
            ->requestStack
            ->getSession()
            ->get($name, null);
    }

    public function setData(string $name, mixed $data): void
    {
        $this
            ->requestStack
            ->getSession()
            ->set($name, $data);
    }
}