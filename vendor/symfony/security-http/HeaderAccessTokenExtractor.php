<?php

namespace Symfony\Component\Security\Http;

use Symfony\Component\HttpFoundation\Request;

final class HeaderAccessTokenExtractor implements AccessTokenExtractorInterface
{
    private $regex;
    private $headerParameter = 'Authorization';
    private $tokenType = 'Bearer';

    public function __construct()
    {
        $this->regex = sprintf(
            '/^%s([a-zA-Z0-9\-_\+~\/\.]+)$/',
            '' === $this->tokenType ? '' : preg_quote($this->tokenType) . '\s+'
        );
    }

    public function extractAccessToken(Request $request): ?string
    {
        if (!$request->headers->has($this->headerParameter) || !\is_string($header = $request->headers->get($this->headerParameter))) {
            return null;
        }

        if (preg_match($this->regex, $header, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
