<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Field yang tidak di-flash ke session saat validasi gagal.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // ── Tangkap error 419 (CSRF token expired) ──────────────────
        // Terjadi kalau user buka halaman terlalu lama lalu baru submit.
        // Daripada muncul halaman error jelek, redirect balik + pesan.
        $this->renderable(function (TokenMismatchException $e, $request) {
            return redirect()->back()
                ->withInput($request->except([
                    'password',
                    'password_baru',
                    'password_baru_confirmation',
                    'password_lama',
                    '_token',
                ]))
                ->with('error', 'Sesi Anda sudah berakhir karena terlalu lama tidak aktif. Halaman sudah diperbarui, silakan coba lagi.');
        });
    }
}
