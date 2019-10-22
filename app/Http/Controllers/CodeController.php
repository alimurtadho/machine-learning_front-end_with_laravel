<?php

namespace App\Http\Controllers;

use App\Code;
use App\Dataset;
use App\Filters\CodeFilters;
use App\Http\Requests\PublishCodeRequest;
use App\Http\Requests\UpdateCodeRequest;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function __construct ()
    {
        $this->middleware('can:create,App\Code')->only(['create', 'store']);
        $this->middleware('can:update,code')->only(['edit', 'update']);
        $this->middleware('can:delete,code')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param CodeFilters $filters
     * @param Request     $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index (CodeFilters $filters, Request $request)
    {
        $codes = Code::filter($filters)
                     ->publishedExceptOf(auth()->id())
                     ->with('creator', 'dataset.media')
                     ->latest()
                     ->paginate()
                     ->appends($request->all());

        return view('codes.index', compact('codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Dataset $dataset
     *
     * @return \Illuminate\Http\Response
     */
    public function create (Dataset $dataset)
    {
        $this->authorize('add-code', $dataset);

        return view('codes.publish', compact('dataset'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PublishCodeRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store (PublishCodeRequest $request)
    {
        $code = Code::create([
            'user_id'     => auth()->id(),
            'dataset_id'  => $request->input('dataset_id'),
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'code'        => $request->input('code'),
            'published'   => $request->input('publish', false),
        ]);

        alert()->success('Success');
        return redirect($code->path());
    }

    /**
     * Display the specified resource.
     *
     * @param Code $code
     *
     * @return \Illuminate\Http\Response
     */
    public function show (Code $code)
    {
        if($code->isNotPublished()){
            $this->authorize($code);
        }

        $code->load('dataset.media');

        return view('codes.show', compact('code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Code $code
     *
     * @return \Illuminate\Http\Response
     */
    public function edit (Code $code)
    {
        return view('codes.edit', compact('code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Code              $code
     * @param UpdateCodeRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update (Code $code, UpdateCodeRequest $request)
    {
        $code->update([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'code'        => $request->input('code'),
            'published'   => $request->input('publish', false),
        ]);

        alert()->success('Success');
        return redirect($code->path());
    }

    /**
     *
     * Delete the specified resource.
     *
     * @param Code $code
     *
     * @return mixed
     */
    public function destroy(Code $code)
    {
        $code->delete();

        return redirect('/codes')->withSuccess('Success');
    }
}
