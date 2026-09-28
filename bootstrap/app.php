<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'guru-piket/surat-izin-siswa/*/send-chatbot',
            'surat-izin-siswa/*/send-chatbot',
            'guru-piket/siswa-telat/*/send-chatbot',
            'siswa-telat/*/send-chatbot',
            'guru-piket/permintaan-izin/*/send-chatbot',
            'permintaan-izin/*/send-chatbot',
            'guru-piket/dispensasi-siswa/*/send-chatbot',
            'dispensasi-siswa/*/send-chatbot',
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
