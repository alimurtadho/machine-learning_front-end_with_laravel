<?php

namespace App\Http\Controllers;

use App\Category;
use App\Filters\ThreadFilters;
use App\Http\Requests\CreateThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Thread;

class ThreadController extends Controller
{
    /**
     * ThreadController constructor.
     */
    public function __construct ()
    {
        $this->middleware('can:create,App\Thread')->only(['create', 'store']);
        $this->middleware('can:update,thread')->only(['edit', 'update']);
        $this->middleware('can:delete,thread')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Category      $category
     * @param ThreadFilters $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Category $category, ThreadFilters $filters)
    {
        $threads = $this->getThreads($category, $filters);
        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateThreadRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store (CreateThreadRequest $request)
    {
        $thread = auth()->user()->threads()->create([
            'name'        => $request->input('name'),
            'body'        => $request->input('body'),
            'category_id' => $request->input('category_id'),
        ]);
        alert()->success('Success');
        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  string      $categorySlug
     * @param  \App\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function show ($categorySlug, Thread $thread)
    {
        $thread->load('creator', 'category');

        return view('threads.show', [
            'thread'  => $thread,
            'replies' => $thread->replies()->with('creator')->paginate(20),
            'best_reply' => $thread->replies()->where('best_answer', true)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $categorySlug
     * @param Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function edit (string $categorySlug, Thread $thread)
    {
        return view('threads.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string              $categorySlug
     * @param Thread              $thread
     * @param UpdateThreadRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (string $categorySlug, Thread $thread, UpdateThreadRequest $request)
    {
        $thread->update([
            'name'        => $request->input('name'),
            'body'        => $request->input('body'),
            'category_id' => $request->input('category_id'),
        ]);
        alert()->success('Success');
        return redirect($thread->path());
    }

    /**
     * Delete the specified resource.
     *
     * @param Thread $thread
     *
     * @return mixed
     */
    public function destroy(string $categorySlug, Thread $thread)
    {
        $thread->delete();

        return redirect('/discuss')->withSuccess('Discussion Deleted');
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Category      $category
     * @param ThreadFilters $filters
     *
     * @return mixed
     */
    protected function getThreads (Category $category, ThreadFilters $filters)
    {
        $threads = Thread::with('category', 'creator')->filter($filters)->latest();
        if ($category->exists) {
            $threads->where('category_id', $category->id);
        }

        return $threads->paginate()->appends(request()->all());
    }
}
