<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
*/
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Cek Extension OpenSSL (Pencegahan Error Fatal)
|--------------------------------------------------------------------------
| Laravel sangat bergantung pada OpenSSL untuk enkripsi (cookie, session, dll).
| Jika extension tidak aktif, kita tampilkan pesan error yang jelas daripada
| fatal error yang membingungkan.
*/
if (!extension_loaded('openssl')) {
    // Tampilkan pesan error yang mudah dibaca di browser
    http_response_code(500);
    echo '<h1 style="color: red; font-family: sans-serif; text-align: center; margin-top: 50px;">
            Error: PHP OpenSSL Extension Tidak Aktif
          </h1>';
    echo '<p style="font-family: sans-serif; max-width: 800px; margin: 20px auto; line-height: 1.6;">
            Aplikasi Laravel membutuhkan extension <strong>openssl</strong> untuk berjalan dengan benar.<br><br>
            <strong>Cara memperbaiki (XAMPP Windows):</strong><br>
            1. Buka file <code>C:\xampp\php\php.ini</code><br>
            2. Cari baris <code>;extension=openssl</code> atau <code>;extension=php_openssl.dll</code><br>
            3. Hapus tanda titik koma (;) di depannya sehingga menjadi:<br>
               &nbsp;&nbsp;&nbsp;<code>extension=openssl</code><br>
            4. Simpan file<br>
            5. Restart Apache dari XAMPP Control Panel<br><br>
            Setelah itu refresh halaman ini.
          </p>';
    echo '<hr><small style="text-align:center;display:block;">Laravel ' . 
         (defined('LARAVEL_VERSION') ? LARAVEL_VERSION : 'Unknown Version') . 
         ' | PHP ' . PHP_VERSION . '</small>';
    // Hentikan eksekusi script
    exit;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
*/
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
*/
try {
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $kernel = $app->make(Kernel::class);

    $response = $kernel->handle(
        $request = Request::capture()
    );

    $response->send();

    $kernel->terminate($request, $response);
} catch (Exception $e) {
    // Tangkap error lain yang mungkin muncul (misal enkripsi key salah, dll)
    http_response_code(500);
    echo '<pre style="background:#f0f0f0;padding:20px;border:1px solid #ccc;font-family:monospace;">';
    echo "Fatal Error:\n\n";
    echo $e->getMessage() . "\n\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo '</pre>';
    // Di production, sebaiknya log saja, jangan tampilkan detail
}