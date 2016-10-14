<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Post;
use App\Models\Location;
use App\Jobs\PostFormFields;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;


class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
      $data = Post::all();
      $user = Auth::user()->id;
      $user_level =   Auth::user()->isAdmin();
      if( $user_level==0){
          $data = Post::all();
      }
      else {
          $data = Post::where('user_id',$user)->get();
      }
       return view('backend.post.index', compact('data','user_level'));
    }
    /**
     * Show the new post form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = $this->dispatch(new PostFormFields());
        $locations = \App\Models\Location::pluck('location_name','id');
        //$locations = Location::select('id','location_name')->get();
        //dd($locations->first());

//      return $view->with('users', $users)->with('q', $q);
//      return  view('backend.post.create', compact('locations', 'data'));
        return view('backend.post.create')->with($data)->with('locations',$locations);
    }

    /**
     * Store a newly created Post.
     *
     * @param PostCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        //        $request
        //        dd($request->location_id[0]);
        $post = Post::create($request->postFillData());
        $post->syncTags($request->get('tags', []));

        Session::set('_new-post', trans('messages.create_success', ['entity' => 'post']));

        return redirect()->route('admin.post.index');
    }

    /**
     * Show the post edit form.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $locations = \App\Models\Location::pluck('location_name');
        $data = $this->dispatch(new PostFormFields($id));
//        $locations = Location::select('id','location')->get();
//        $location_selected_id = Post::ALL()->WHERE('id','==',$id);
        return view('backend.post.edit')->with($data)->with('locations',$locations);
    }

    /**
     * Update the Post.
     *
     * @param PostUpdateRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);
//        $request->postFillData()
        $post->fill($request->postFillData());
        $post->save();
        $post->syncTags($request->get('tags', []));

        Session::set('_update-post', trans('messages.update_success', ['entity' => 'Post']));

        return redirect("/admin/post/$id/edit");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        Session::set('_delete-post', trans('messages.delete_success', ['entity' => 'Post']));

        return redirect()->route('admin.post.index');
    }
}
