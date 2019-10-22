<?php

namespace App\Http\Controllers;

use App\Dataset;
use App\Filters\DatasetFilters;
use App\Http\Requests\PublishDatasetRequest;
use App\Http\Requests\UpdateDatasetRequest;
use Illuminate\Http\Request;

class DatasetController extends Controller
{
    public function __construct ()
    {
        $this->middleware('can:create,App\Dataset')->only(['create', 'store']);
        $this->middleware('can:update,dataset')->only(['edit', 'update']);
        $this->middleware('can:delete,dataset')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param DatasetFilters $filters
     * @param Request        $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index (DatasetFilters $filters, Request $request)
    {
        $datasets = Dataset::filter($filters)
                           ->publishedExceptOf(auth()->id())
                           ->with('creator', 'media')
                           ->latest()
                           ->paginate()
                           ->appends($request->all());

        return view('datasets.index', compact('datasets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        return view('datasets.publish');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PublishDatasetRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store (PublishDatasetRequest $request)
    {
        $dataset = Dataset::create([
            'name'        => $request->input('name'),
            'overview'    => $request->input('overview'),
            'description' => $request->input('description'),
            'user_id'     => auth()->id(),
        ]);

        alert()->info('You need to upload an image and dataset files to publish the dataset.', 'Almost There!')->confirmButton();
        return redirect($dataset->path() . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param Dataset $dataset
     *
     * @return \Illuminate\Http\Response
     */
    public function show (Dataset $dataset)
    {
        if($dataset->isNotPublished()){
            $this->authorize($dataset);
        }

        $dataset->load('media', 'creator');

        $codes = $dataset->codes()->with('dataset.media', 'creator')->published()->latest()->paginate();

        return view('datasets.show', compact('dataset', 'codes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Dataset $dataset
     *
     * @return \Illuminate\Http\Response
     */
    public function edit (Dataset $dataset)
    {
        $dataset->load('media');

        return view('datasets.edit', compact('dataset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDatasetRequest $request
     * @param Dataset              $dataset
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update (UpdateDatasetRequest $request, Dataset $dataset)
    {
        if ($request->hasFile('image')) {
            $dataset->clearMediaCollection();
            $dataset->addMedia($request->file('image'))->preservingOriginal()->toMediaCollection();
        }

        $dataset->update([
            'name'        => $request->input('name'),
            'overview'    => $request->input('overview'),
            'description' => $request->input('description'),
            'published'   => $dataset->hasMedia() && $dataset->hasMedia('files')
        ]);

        if ( ! $dataset->isPublished()) {
            return redirect($dataset->path() . '/edit')
                ->withErrors(['You need to add a display image and at least one file before publishing the dataset.']);
        }

        alert()->success('Success');
        return redirect($dataset->path());
    }

    /**
     *
     * Delete the specified resource.
     *
     * @param Dataset $dataset
     *
     * @return mixed
     */
    public function destroy(Dataset $dataset)
    {
        $dataset->delete();

        return redirect('/datasets')->withSuccess('Dataset Deleted');
    }
}
