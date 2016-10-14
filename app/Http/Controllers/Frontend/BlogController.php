<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use App\Models\Post;
use App\Jobs\BlogIndexData;
use App\Jobs\BlogSearchData;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Debugbar;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail(1);
        $tag = $request->get('tag');
        $alltags=  Tag::all();
        $alllocations = Location::all();
        $data = $this->dispatch(new BlogIndexData($tag));
        $layout = $tag ? Tag::layout($tag)->first() : 'frontend.blog.index';
        return view($layout, $data)->with(compact('user','alltags','alllocations'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPost($slug, Request $request)
    {
//           dd($slug);

        $user = User::findOrFail(1);
        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $tag = $request->get('tag');
        $title = $post->title;
        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }
        return view($post->layout, compact('post', 'tag', 'slug', 'title', 'user'));
    }

    public function search(Request $request)
    {

        //        dd($request);
        //      dd($request->select_location);
        //        dd($request->select_category);
        $choose_location=$request->select_location;
        $choose_category =$request->select_category;

        // set cookies for location

        $response = new Response('HelloWorld');
        $response->withCookie(cookie('selectedbyuser', $request->select_location));
        //        dd($response);
        //        return $response;

        // set cookies for category
        $response = new Response('HelloWorld1');
        $response->withCookie(cookie('selectedbyuserforcate', $request->select_category));

        $user = User::findOrFail(1);
        $tag = $request->get('tag');
//        dd($tag);
        $alltags=  Tag::all();
        $alllocations = Location::all();
        $data = $this->dispatch(new BlogSearchData($choose_category,$choose_location));
        $layout = $tag ? Tag::layout($tag)->first() : 'frontend.blog.index';

        return view($layout, $data)->with(compact('user','alltags','alllocations'));



//        $user = User::findOrFail(1);
//        $tag = $request->get('tag');
//        $alltags=  Tag::all();
//        $alllocations = Location::all();
//        $data = $this->dispatch(new BlogIndexData($tag));
//        $layout = $tag ? Tag::layout($tag)->first() : 'frontend.blog.index';
//        return view($layout, $data)->with(compact('user','alltags','alllocations'));
         // dd($request);
        //Debugbar::info('hjhjh');
        //{{ Debugbar::info($request->select_location);}}
        //{{ Debugbar::info($request->select_category); }}
    }
}
