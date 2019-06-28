<?php
namespace rainerch\eventhook\base;

interface HookInterface
{
    public function handler(Response $response, $data = []): bool;
}