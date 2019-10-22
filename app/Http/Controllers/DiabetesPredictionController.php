<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiabetesPredictionRequest;
use App\Services\DiabetesPredictionService;

class DiabetesPredictionController extends Controller
{
    public function form ()
    {
        return view('predictions.diabetes');
    }

    public function predict (DiabetesPredictionRequest $request, DiabetesPredictionService $service)
    {
        $data = [
            'age' => $request->input('age', 0),
            'pregnant' => $request->input('pregnant', 0),
            'plasma_glucose_concentration' => $request->input('plasma_glucose_concentration', 0),
            'diastolic_bp' => $request->input('diastolic_bp', 0),
            'tsft' => $request->input('tsft', 0),
            'serum_insulin' => $request->input('serum_insulin', 0),
            'bmi' => $request->input('bmi', 0),
            'dpf' => $request->input('dpf', 0)
        ];

        $prediction = $service->predict($data);

        return view('predictions.diabetes')->withResults($prediction);
    }
}
