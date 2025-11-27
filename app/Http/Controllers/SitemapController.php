<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'published')
                      ->where('date', '>=', now())
                      ->orderBy('date', 'asc')
                      ->get();

        $content = view('sitemap', compact('events'))->render();

        return response($content, 200)
                  ->header('Content-Type', 'text/xml');
    }
}
