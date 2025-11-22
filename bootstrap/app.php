<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    // ✅ REGISTER YOUR COMMANDS HERE
    ->withCommands([
        App\Console\Commands\DeleteOldUserLogs::class,
    ])

    // ✅ ADD THE SCHEDULER HERE
    ->withSchedule(function (Schedule $schedule) {
        // Run every 5 minutes
        $schedule->command('logs:clean')->everyFiveMinutes();
    })

    ->withMiddleware(function (Middleware $middleware) {
        // Middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'log.activity' => \App\Http\Middleware\LogUserActivity::class,
        ]);

        // Apply LogUserActivity to all web requests
        $middleware->web(append: [
            \App\Http\Middleware\LogUserActivity::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
