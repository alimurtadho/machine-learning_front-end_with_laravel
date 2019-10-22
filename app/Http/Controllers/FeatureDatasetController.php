<?php

namespace App\Http\Controllers;

use App\Dataset;
use Illuminate\Http\Request;

class FeatureDatasetController extends Controller
{
    /**
     * Toggle featured status of dataset.
     *
     * @param Dataset $dataset
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggle(Dataset $dataset)
    {
        $this->authorize('feature', $dataset);

        $dataset->isFeatured() ? $dataset->unFeature() : $dataset->feature();

        return back()->withSuccess('Dataset '. ($dataset->isFeatured() ? 'Featured' : 'Removed from Featured'));
    }

}
