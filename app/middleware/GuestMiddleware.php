<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class GuestMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        if (isset($_SESSION['user'])) {
            $response = new Response();
            return $response
                ->withHeader('Location', '/dashboard')
                ->withStatus(302);
        }

        return $handler->handle($request);
    }
}
