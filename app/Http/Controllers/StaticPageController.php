<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function show(string $slug)
    {
        // Cek apakah view untuk slug yang diminta ada di folder 'pages'
        if (view()->exists("pages.{$slug}")) {
            return view("pages.{$slug}");
        }

        // Jika tidak ada, tampilkan halaman 404 Not Found
        abort(404);
    }
}
