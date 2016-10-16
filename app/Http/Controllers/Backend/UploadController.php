<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Http\Request;
use App\Services\UploadsManager;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UploadNewFolderRequest;


class UploadController extends Controller
{
    protected $manager;

    public function __construct(UploadsManager $manager,Request $request)
    {
        $this->manager = $manager;
//        $user = Auth::user()->display_name;
//        $rootfolder = $user;
        $this->user = Auth::user()->display_name;
        $this->user_ID = Auth::user()->id;
//        if($this->user!=0){
//
//        }
       if( $this->user_ID !=0)
       {
            if($request->get('folder')=='/'){
                dd('wrong path');
            }
       }
    }

    /**
     * Show page of files / subfolders.
     *
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
//        dd($this->user);
        //dd($user);
        $folder = $request->get('folder');
//        $this->user
//        dd( $folder);
        if ($folder==null){
            $folder =  $this->user;
        }

        $data = $this->manager->folderInfo($folder);
//        dd($data);
        $user = Auth::user()->id;
        $user_level =   Auth::user()->isAdmin();

        return view('backend.upload.index')->with($data)->with('user_level',$user_level);
    }

    /**
     * Create a new folder.
     *
     * @param UploadNewFolderRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = $request->get('new_folder');
//        $folder = $request->get('folder').'/'.$new_folder;
        $folder = $this->user.'/'.$new_folder;
        $result = $this->manager->createDirectory($folder);

        if ($result === true) {
            Session::set('_new-folder', trans('messages.create_success', ['entity' => 'folder']));

            return redirect()->back();
        } else {
            $error = $result ?: trans('messages.create_error', ['entity' => 'directory']);

            return redirect()->back()->withErrors([$error]);
        }
    }

    /**
     * Delete a folder.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFolder(Request $request)
    {
        $del_folder = $request->get('del_folder');
//        $folder = $request->get('folder').'/'.$del_folder;
        $folder = $this->user.'/'.$del_folder;
        $result = $this->manager->deleteDirectory($folder);

        if ($result === true) {
            Session::set('_delete-folder', trans('messages.delete_success', ['entity' => 'Folder']));

            return redirect()->back();
        } else {
            $error = $result ?: trans('messages.delete_error', ['entity' => 'directory']);

            return redirect()->back()->withErrors([$error]);
        }
    }

    /**
     * Upload new file.
     *
     * @param UploadFileRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadFile(UploadFileRequest $request)
    {
        $file = $request->file('file');

        $fileName = $request->get('file_name') ?: $file->getClientOriginalName();
        $fileName = explode('.', $fileName)[0].'.'.strtolower($file->getClientOriginalExtension());

        $result = $this->manager->saveFile(
         str_finish($request->get('folder'), '/').preg_replace('/[\'|\"]/', '', $fileName),
//            str_finish($this->user, '/').preg_replace('/[\'|\"]/', '', $fileName),
            File::get($file)
        );

        if ($result === true) {
            Session::set('_new-file', trans('messages.upload_success', ['entity' => 'file']));

            return redirect()->back();
        } else {
            $error = $result ?: trans('messages.upload_error', ['entity' => 'file']);

            return redirect()->back()->withErrors([$error]);
        }
    }

    /**
     * Delete a file.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteFile(Request $request)
    {
        $del_file = $request->get('del_file');
//        $path = $request->get('folder').'/'.$del_file;
        $path = $this->user.'/'.$del_file;

        $result = $this->manager->deleteFile($path);

        if ($result === true) {
            Session::set('_delete-file', trans('messages.delete_success', ['entity' => 'File']));

            return redirect()->back();
        } else {
            $error = $result ?: trans('messages.delete_error', ['entity' => 'file']);

            return redirect()->back()->withErrors([$error]);
        }
    }
    public function checkadmin()
    {
        dd($this->user);
    }
}
