<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\Location;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocationUpdateRequest;
use App\Http\Requests\LocationCreateRequest;

use Illuminate\Http\Request;

use App\Http\Requests;

class LocationController extends Controller
{
    protected $fields = [
        'location_name' => '',
        'created_at' => '',
        'updated_at' => '',
    ];

     public function index()
        {
        $data = Location::all();
        $user = Auth::user()->id;
        $user_level =   Auth::user()->isAdmin();
        return view('backend.location.index', compact('data','user_level'));
        }

    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }

//        $locations= Location::all();
//        $locations= $locations->location_name;
//        dd($locations);

    return view('backend.location.create', compact('data'));
    }
    public function store(LocationCreateRequest $request)
    {
       // dd($request);
        $location = new Location();
        $location->fill($request->toArray())->save();
        $location->save();

        Session::set('_new-tag', trans('messages.create_success', ['entity' => 'tag']));

        return redirect('/admin/location');
    }
    public function edit($post_id)
    {
        $location = Location::findOrFail($post_id);
//       dd($location);
       $data = ['id' => $post_id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $location->$field);
        }

       return view('backend.location.edit', compact('data'));
    }

    public function update(LocationUpdateRequest $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->fill($request->toArray())->save();
        $location->save();

        Session::set('_update-tag', trans('messages.update_success', ['entity' => 'Tag']));

        return redirect("/admin/location/$id/edit");
    }
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        Session::set('_delete-tag', trans('messages.delete_success', ['entity' => 'Tag']));

        return redirect('/admin/location');
    }

}

