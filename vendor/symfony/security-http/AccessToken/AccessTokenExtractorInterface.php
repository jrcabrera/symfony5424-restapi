<?php

namespace Symfony\Component\Security\Http\AccessToken;

use Symfony\Component\HttpFoundation\Request;

interface AccessTokenExtractorInterface
{
    public function extractAccessToken(Request $request): ?string;
}
