<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
                ->withRouting(
                        web: [
                            __DIR__ . '/../routes/web.php',
                            __DIR__ . '/../routes/auth.php',
                        ],
                        commands: __DIR__ . '/../routes/console.php',
                        health: '/up',
                        api: [
                            __DIR__ . '/../routes/coordinator.php',
                            __DIR__ . '/../routes/technician.php',
                        ],
                )
                ->withMiddleware(function (Middleware $middleware) {
                    $middleware->alias([
                        'abilities' => CheckAbilities::class,
                        'ability' => CheckForAnyAbility::class,
                    ]);
                })
                ->withExceptions(function (Exceptions $exceptions) {
                    $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
                        if ($request->is('api/*')) {
                            return tokenResponse('Invalid Token');
                        }
                    });
                    $exceptions->render(function (NotFoundHttpException $e, Request $request) {
                        if ($request->is('api/*')) {
                            return systemResponse('Request Not Found');
                        }
                    });
                    $exceptions->render(function (AuthenticationException $e, Request $request) {
                        if ($request->is('api/*')) {
                            return tokenResponse('Invalid Token');
                        }
                    });
                })->create();
