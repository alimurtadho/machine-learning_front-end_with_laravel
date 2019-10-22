<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeartDiseasePredictionRequest;
use App\Services\HeartDiseasePredictionService;

class HeartDiseasePredictionController extends Controller
{
    public function form ()
    {
        return view('predictions.heart');
    }

    public function predict (HeartDiseasePredictionRequest $request, HeartDiseasePredictionService $service)
    {
        $data = [
            'age'                     => $request->input('age', 0),
            'sex'                     => $request->input('sex', 0),
            'cp'                      => $request->input('cp', 0),
            'resting_bp'              => $request->input('resting_bp', 0),
            'serum_cholesterol'       => $request->input('serum_cholesterol', 0),
            'fasting_blood_sugar'     => $request->input('fasting_blood_sugar', 0),
            'resting_ecg'             => $request->input('resting_ecg', 0),
            'max_heart_rate'          => $request->input('max_heart_rate', 0),
            'exercise_induced_angina' => $request->input('exercise_induced_angina', 0),
            'st_depression'           => $request->input('st_depression', 0),
            'st_slope'                => $request->input('st_slope', 0),
            'number_of_vessels'       => $request->input('number_of_vessels', 0),
            'thallium_scan_results'   => $request->input('thallium_scan_results', 0)
        ];

        $prediction = $service->predict($data);

        return view('predictions.heart')->withResults($prediction);
    }
}
