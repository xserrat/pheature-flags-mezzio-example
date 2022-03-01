<?php
declare(strict_types=1);

namespace App\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RouteBasedAuthenticationMiddleware implements MiddlewareInterface
{
    private const USERS = [
       'developer' => [
           'location' => 'barcelona',
           'roles' => ['ROLE_DEVELOPER'],
       ]
    ];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $user = $request->getQueryParams()['user'] ?? null;

        if (!$this->isAuthenticatedUser($user)) {
            return $handler->handle($request);
        }

        $userLogged = $this->logUser($user);

        $requestWithUser = $request->withAttribute('user', $userLogged);

        return $handler->handle($requestWithUser);
    }

    private function isAuthenticatedUser(?string $user): bool
    {
        if (null === $user) {
            return false;
        }

        if (!array_key_exists($user, self::USERS)) {
            return false;
        }

        return true;
    }

    private function logUser(string $user): LoggedUser
    {
        $userInformation = self::USERS[$user];

        return new LoggedUser(
            $user,
            $userInformation['location'],
            $userInformation['roles'] ?? []
        );
    }
}
