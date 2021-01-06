<?php

namespace App\Http\Controllers\Tenants;

use App\Models\Tenants\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AppController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function index()
    {
        $posts = Post::latest()->get();
        return view('multitenancy::app.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        Post::create($request->all());

        return redirect()->route('app.index');
    }
}
