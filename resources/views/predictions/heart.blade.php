@extends('layouts.app')

@section('title')
    Heart Disease Prediction
@endsection

@section('content')

    @component('layouts.card', [
        'cardTitle' => 'Heart Disease Prediction',
        'colSize' => 12
    ])
    <form role="form" method="POST" action="/predict/heart">
        {{ csrf_field() }}

        @if(isset($results))
            <div class="alert alert-{{ $results['Ensemble'] != 1 ? 'success' : 'warning' }}" role="alert">
                @if($results['Ensemble'] == 1)
                    You might have risk of developing heart disease.
                @else
                    You do not have risk of heart disease.
                @endif
                <button class="btn btn-primary float-right" data-toggle="collapse" data-target="#prediction-results-detail-view" aria-expanded="false" aria-controls="prediction-results-detail-view">
                    Show Details
                </button>
                <span class="clearfix"></span>
            </div>
            <div class="collapse" id="prediction-results-detail-view">
                <div class="card card-block justify-content-center">
                    <p>We calculated risks using various algorithms.</p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Algorithm</th>
                                    <th>Risk of Heart Disease</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr{!! $results['LogisticRegression'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>Logistic Regression</td>
                                    <td>{{ $results['LogisticRegression'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr{!! $results['LinearSVC'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>Linear Support Vector Classifier</td>
                                    <td>{{ $results['LinearSVC'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr{!! $results['NaiveBayes'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>Naive Bayes</td>
                                    <td>{{ $results['NaiveBayes'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr{!! $results['KNeighbors'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>K-Nearest Neighbors</td>
                                    <td>{{ $results['KNeighbors'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                <tr{!! $results['NeuralNetwork'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <td>Neural Network (Multi-Layer Perceptron)</td>
                                    <td>{{ $results['NeuralNetwork'] ? 'Yes' : 'No' }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr{!! $results['Ensemble'] ? ' class="table-danger"' : ' class="table-success"' !!}>
                                    <th>Ensemble Classifier (Combination of all above)</th>
                                    <th>{{ $results['Ensemble'] ? 'Yes' : 'No' }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="form-group mt-2 row{{ $errors->has('age') ? ' has-danger' : '' }}">
            <label for="age" class="col-4 col-form-label text-right">Age</label>

            <div class="col-6">
                <input id="age" type="number" min="1" max="100" class="form-control" name="age" value="{{ old('age') }}" required autofocus placeholder="45">

                @if ($errors->has('age'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('age') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('sex') ? ' has-danger' : '' }}">
            <label for="sex" class="col-4 col-form-label text-right">Sex</label>

            <div class="col-6">
                <select required class="form-control" name="sex" id="sex">
                    <option value="">Select</option>
                    <option value="1"{{ old('sex') === 1 ? ' selected' : '' }}>Male</option>
                    <option value="0"{{ old('sex') === 0 ? ' selected' : '' }}>Female</option>
                </select>

                @if ($errors->has('sex'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('sex') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('cp') ? ' has-danger' : '' }}">
            <label for="cp" class="col-4 col-form-label text-right">
                Chest Pain
                <a target="_blank" href="https://goo.gl/bX82rw"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <select required class="form-control" name="cp" id="cp">
                    <option value="">Select</option>
                    <option value="1"{{ old('cp') === 1 ? ' selected' : '' }}>Typical Angina</option>
                    <option value="2"{{ old('cp') === 2 ? ' selected' : '' }}>Atypical Angina</option>
                    <option value="3"{{ old('cp') === 3 ? ' selected' : '' }}>Non-Angina</option>
                    <option value="4"{{ old('cp') === 4 ? ' selected' : '' }}>Asymptomatic</option>
                </select>

                @if ($errors->has('cp'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('cp') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('resting_bp') ? ' has-danger' : '' }}">
            <label for="resting_bp" class="col-4 col-form-label text-right">
                Resting Systolic Blood Pressure (in mmHg)
                <a target="_blank" href="https://goo.gl/LwzOH6"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input placeholder="" id="resting_bp" type="number" min="1" class="form-control" name="resting_bp" value="{{ old('resting_bp') }}" required>
                <p class="form-text text-muted">
                    <em>Normally less than 120 mmHg</em>
                </p>

                @if ($errors->has('resting_bp'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('resting_bp') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('serum_cholesterol') ? ' has-danger' : '' }}">
            <label for="serum_cholesterol" class="col-4 col-form-label text-right">
                Serum Cholesterol (in mg/dL)
                <a target="_blank" href="https://goo.gl/krOgsD"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input id="serum_cholesterol" type="number" class="form-control" name="serum_cholesterol" value="{{ old('serum_cholesterol') }}" required>
                <p class="form-text text-muted">
                    <em>Ideally below 200 mg/dL</em>
                </p>

                @if ($errors->has('serum_cholesterol'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('serum_cholesterol') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('fasting_blood_sugar') ? ' has-danger' : '' }}">
            <label for="fasting_blood_sugar" class="col-4 col-form-label text-right">
                Fasting Blood Sugar (in mg/dL)
                <a target="_blank" href="https://goo.gl/pufr55"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input id="fasting_blood_sugar" type="number" class="form-control" name="fasting_blood_sugar" value="{{ old('fasting_blood_sugar') }}" required>
                <p class="form-text text-muted">
                    <em>Normally below 100 mg/dL</em>
                </p>

                @if ($errors->has('fasting_blood_sugar'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('fasting_blood_sugar') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('resting_ecg') ? ' has-danger' : '' }}">
            <label for="resting_ecg" class="col-4 col-form-label text-right">
                Resting ECG Results
                <a target="_blank" href="https://goo.gl/ZSy4Pm"><i class="fa fa-question-circle-o"> </i></a>
                <a target="_blank" href="https://goo.gl/ZqI6rY"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <select required class="form-control" name="resting_ecg" id="resting_ecg">
                    <option value="">Select</option>
                    <option value="0"{{ old('resting_ecg') === 0 ? ' selected' : '' }}>Normal</option>
                    <option value="1"{{ old('resting_ecg') === 1 ? ' selected' : '' }}>Having ST-T wave abnormality</option>
                    <option value="2"{{ old('resting_ecg') === 2 ? ' selected' : '' }}>Showing probable or definite Left Ventricular Hypertrophy by Estes' Criteria</option>
                </select>

                @if ($errors->has('resting_ecg'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('resting_ecg') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('max_heart_rate') ? ' has-danger' : '' }}">
            <label for="max_heart_rate" class="col-4 col-form-label text-right">
                Maximum heart rate achieved
                <a target="_blank" href="https://goo.gl/lrR3fQ"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input id="max_heart_rate" type="number" class="form-control" name="max_heart_rate" value="{{ old('max_heart_rate') }}" required>

                @if ($errors->has('max_heart_rate'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('max_heart_rate') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('exercise_induced_angina') ? ' has-danger' : '' }}">
            <label for="exercise_induced_angina" class="col-4 col-form-label text-right">
                Exercise Induced Angina
                <a target="_blank" href="https://goo.gl/huWR8R"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <select required class="form-control" name="exercise_induced_angina" id="exercise_induced_angina">
                    <option value="">Select</option>
                    <option value="1"{{ old('exercise_induced_angina') === 1 ? ' selected' : '' }}>Yes</option>
                    <option value="0"{{ old('exercise_induced_angina') === 0 ? ' selected' : '' }}>No</option>
                </select>

                @if ($errors->has('exercise_induced_angina'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('exercise_induced_angina') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('st_depression') ? ' has-danger' : '' }}">
            <label for="st_depression" class="col-4 col-form-label text-right">ST Depression induced by exercise relative to rest</label>

            <div class="col-6">
                <input id="st_depression" type="number" step="0.1" class="form-control" name="st_depression" value="{{ old('st_depression') }}" required>

                @if ($errors->has('st_depression'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('st_depression') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('st_slope') ? ' has-danger' : '' }}">
            <label for="st_slope" class="col-4 col-form-label text-right">
                Slope of the peak exercise ST segment
                <a target="_blank" href="https://goo.gl/dmejz6"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <select required class="form-control" name="st_slope" id="st_slope">
                    <option value="">Select</option>
                    <option value="1"{{ old('st_slope') === 1 ? ' selected' : '' }}>Up Sloping</option>
                    <option value="2"{{ old('st_slope') === 2 ? ' selected' : '' }}>Flat</option>
                    <option value="3"{{ old('st_slope') === 3 ? ' selected' : '' }}>Down Sloping</option>
                </select>

                @if ($errors->has('st_slope'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('st_slope') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('number_of_vessels') ? ' has-danger' : '' }}">
            <label for="number_of_vessels" class="col-4 col-form-label text-right">
                Number of Major vessels colored by Fluoroscopy
                <a target="_blank" href="https://goo.gl/3TuetS"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input id="number_of_vessels" type="number" min="0" max="3" class="form-control" name="number_of_vessels" value="{{ old('number_of_vessels') }}" required>

                @if ($errors->has('number_of_vessels'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('number_of_vessels') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row{{ $errors->has('thallium_scan_results') ? ' has-danger' : '' }}">
            <label for="thallium_scan_results" class="col-4 col-form-label text-right">
                Results from Thallium Heart Scan
                <a target="_blank" href="https://goo.gl/7kQQNV"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <select required class="form-control" name="thallium_scan_results" id="thallium_scan_results">
                    <option value="">Select</option>
                    <option value="3"{{ old('thallium_scan_results') === 3 ? ' selected' : '' }}>Normal</option>
                    <option value="6"{{ old('thallium_scan_results') === 6 ? ' selected' : '' }}>Fixed Defect</option>
                    <option value="7"{{ old('thallium_scan_results') === 7 ? ' selected' : '' }}>Reversible Defect</option>
                </select>

                @if ($errors->has('thallium_scan_results'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('thallium_scan_results') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary">
                    Evaluate
                </button>
            </div>
        </div>
    </form>
    @endcomponent
@endsection