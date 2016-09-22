<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Settings;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the application home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
         $user = Auth::user()->id;
         $user_level =   Auth::user()->isAdmin();

        $data = [
            'posts' => Post::all(),
            'recentPosts' => Post::orderBy('created_at', 'desc')->take(4)->get(),
            'tags' => Tag::all(),
            'disqus' => Settings::disqus(),
            'analytics' => Settings::gaId(),
            'status' => App::isDownForMaintenance() ? 0 : 1,
        ];

        return view('backend.home.index', compact('data','user_level'));
    }
}
