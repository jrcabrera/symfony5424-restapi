<?php

namespace App\Security;

use App\Service\Stack;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\AccessToken\HeaderAccessTokenExtractor;


class TokenAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $apiToken = $request->headers->get('Authorization');
        if ($apiToken == '') {
            throw new CustomUserMessageAuthenticationException('Authorization is required');
        }

        return new SelfValidatingPassport(new UserBadge($apiToken));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $apiToken = $request->headers->get('Authorization');
        $continue = strlen($apiToken) === 0 ? false : true;
        if ($continue) {
            // extract value - begin
            $objTokenExtractor = new HeaderAccessTokenExtractor();
            $token = $objTokenExtractor->extractAccessToken($request);
            // extract value - end
            if ($token != '') {
                // validation - begin
                $objStack = new Stack();
                for ($i = 0; $i < strlen($token); $i++) {
                    if ($token[$i] == '(' || $token[$i] == '[' || $token[$i] == '{') {
                        $objStack->push($token[$i]);
                    } else {
                        if ($token[$i] == ')') {
                            if ($objStack->topElement() == '(') {
                                $objStack->pop();
                            } else {
                                $objStack->push($token[$i]);
                            }
                        } else {
                            if ($token[$i] == ']') {
                                if ($objStack->topElement() == '[') {
                                    $objStack->pop();
                                } else {
                                    $objStack->push($token[$i]);
                                }
                            } else {
                                if ($token[$i] == '}') {
                                    if ($objStack->topElement() == '{') {
                                        $objStack->pop();
                                    } else {
                                        $objStack->push($token[$i]);
                                    }
                                }
                            }
                        }
                    }
                }
                // validation - end
                if ($objStack->isEmpty()) {
                    return null;
                } else {
                    $data = [
                        'message' => 'Authorization is not valid'
                    ];
                    return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
                }
            } else {
                $data = [
                    'message' => 'Authorization is not valid'
                ];
                return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
            }
        } else {
            $data = [
                'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
            ];
            return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
        }
    }
}
