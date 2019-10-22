<?php

namespace App\Http\Controllers;

use App\Dataset;
use Illuminate\Http\Request;

class DatasetFileController extends Controller
{
    public function __construct ()
    {
        $this->middleware('can:upload-file,dataset')->only(['upload', 'delete']);
    }

    public function upload (Dataset $dataset, Request $request)
    {
        if ($dataset->hasMedia('files') && count($dataset->getMedia('files')) >= config('settings.dataset.max_allowed_files')) {
            return response([
                'error' => sprintf('Maximum of %d files are allowed.', config('settings.dataset.max_allowed_files'))
            ], 403);
        }

        $media = $dataset->addMedia($request->file('file'))
                         ->preservingOriginal()
                         ->toMediaCollection('files');

        return view('datasets._file_list_item', ['dataset' => $dataset, 'file' => $media]);
    }

    public function delete (Dataset $dataset, int $id, Request $request)
    {
        $dataset->deleteMedia($id);

        if($request->ajax()){
            return 'ok';
        }

        alert()->success('File Deleted');
        return back();
    }
}
