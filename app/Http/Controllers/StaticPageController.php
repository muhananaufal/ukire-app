<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function show(string $slug)
    {
        if (view()->exists("pages.{$slug}")) {
            return view("pages.{$slug}");
        }
        abort(404);
    }
}
