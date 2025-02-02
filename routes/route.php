<?php

use App\Controllers\AttendeeController;
use App\Controllers\AuthController;
use App\Controllers\EventController;
use App\Controllers\HomeController;
use App\Controllers\RegisterController;
use App\Middlewares\CheckAuth;
use App\Middlewares\PreventIfAuthenticated;
use App\Middlewares\VerifyCsrfToken;

$router->add('GET', '/', [HomeController::class, 'home'], [PreventIfAuthenticated::class]);

$router->add('GET', '/login', [AuthController::class, 'loginForm'], [PreventIfAuthenticated::class]);
$router->add('POST', '/login', [AuthController::class, 'login'], [PreventIfAuthenticated::class, VerifyCsrfToken::class]);
$router->add('POST', '/logout', [AuthController::class, 'logout'], [CheckAuth::class]);

$router->add('GET', '/register', [RegisterController::class, 'registerForm'], [PreventIfAuthenticated::class]);
$router->add('POST', '/register', [RegisterController::class, 'register'], [PreventIfAuthenticated::class, VerifyCsrfToken::class]);


$router->add('GET', '/events', [EventController::class, 'index'], [CheckAuth::class]);
$router->add('GET', '/events/create', [EventController::class, 'create'], [CheckAuth::class]);
$router->add('POST', '/events', [EventController::class, 'save'], [CheckAuth::class]);
$router->add('GET', '/events/{id}', [EventController::class, 'show']);
$router->add('PUT', '/events/{id}', [EventController::class, 'update'], [CheckAuth::class]);
$router->add('GET', '/events/{id}/edit', [EventController::class, 'edit'], [CheckAuth::class]);
$router->add('DELETE', '/events/{id}', [EventController::class, 'delete'], [CheckAuth::class]);

$router->add('GET', '/events/{eventId}/attendees', [AttendeeController::class, 'index'], [CheckAuth::class]);
$router->add('GET', '/events/{eventId}/attendees/register', [AttendeeController::class, 'create']);
$router->add('POST', '/events/{eventId}/attendees', [AttendeeController::class, 'save']);
$router->add('DELETE', '/events/{eventId}/attendees/{id}', [AttendeeController::class, 'delete'], [CheckAuth::class]);
$router->add('GET', '/events/{eventId}/attendees/download', [AttendeeController::class, 'download'], [CheckAuth::class]);

// API routes
$router->add('GET', '/api/events', [EventController::class, 'eventPaginationAPI'], [CheckAuth::class]);
$router->add('GET', '/api/get-events', [EventController::class, 'activeEventPaginationAPI']);
$router->add('GET', '/api/events/{eventId}/attendees', [AttendeeController::class, 'attendeePaginationAPI'], [CheckAuth::class]);