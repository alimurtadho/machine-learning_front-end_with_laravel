<?php

namespace App\Http\Controllers;

use App\Dataset;
use Illuminate\Http\Request;

class PublishDatasetController extends Controller
{
    /**
     * Toggle published status of dataset.
     *
     * @param Dataset $dataset
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Dataset $dataset)
    {
        $this->authorize('publish', $dataset);

        $dataset->isPublished() ? $dataset->unPublish() : $dataset->publish();

        return back()->withSuccess('Dataset '. ($dataset->isPublished() ? 'Published' : 'Unpublished'));
    }
}
