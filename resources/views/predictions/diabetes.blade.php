@extends('layouts.app')

@section('title')
    Diabetes Prediction
@endsection

@section('content')

    @component('layouts.card', [
        'cardTitle' => 'Diabetes Prediction',
        'colSize' => 12
    ])
    <form role="form" method="POST" action="/predict/diabetes">
        {{ csrf_field() }}

        @if(isset($results))
            <div class="alert alert-{{ $results['Ensemble'] != 1 ? 'success' : 'warning' }}" role="alert">
                @if($results['Ensemble'] == 1)
                    You might have risk of developing diabetes.
                @else
                    You do not have risk of diabetes.
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
                                    <th>Risk of Diabetes</th>
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
                <input placeholder="45" id="age" type="number" class="form-control" name="age" value="{{ old('age') }}" required>

                @if ($errors->has('age'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('age') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group mt-2 row{{ $errors->has('pregnant') ? ' has-danger' : '' }}">
            <label for="pregnant" class="col-4 col-form-label text-right">No of times Pregnant</label>

            <div class="col-6">
                <input placeholder="2" id="pregnant" type="number" class="form-control" name="pregnant" value="{{ old('pregnant') }}" required>

                @if ($errors->has('pregnant'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('pregnant') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group mt-2 row{{ $errors->has('plasma_glucose_concentration') ? ' has-danger' : '' }}">
            <label for="plasma_glucose_concentration" class="col-4 col-form-label text-right">
                2-hr Glucose Tolerance Test (in mg/dL)
                <a target="_blank" href="https://goo.gl/pftSRy"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input placeholder="120" id="plasma_glucose_concentration" type="number" class="form-control" name="plasma_glucose_concentration" value="{{ old('plasma_glucose_concentration') }}" required>
                <p class="form-text text-muted">
                    <em>Normally below 140 mg/dL</em>
                </p>

                @if ($errors->has('plasma_glucose_concentration'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('plasma_glucose_concentration') }}</strong>
                    </p>
                @endif
            </div>
        </div>
        <div class="form-group mt-2 row{{ $errors->has('diastolic_bp') ? ' has-danger' : '' }}">
            <label for="diastolic_bp" class="col-4 col-form-label text-right">
                Diastolic Blood Pressure (in mmHg)
                <a target="_blank" href="https://goo.gl/LBtbi4"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input id="diastolic_bp" type="number" class="form-control" name="diastolic_bp" value="{{ old('diastolic_bp') }}" required>
                <p class="form-text text-muted">
                    <em>Normally below 80 mmHg</em>
                </p>

                @if ($errors->has('diastolic_bp'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('diastolic_bp') }}</strong>
                    </p>
                @endif
            </div>
        </div>
        <div class="form-group mt-2 row{{ $errors->has('tsft') ? ' has-danger' : '' }}">
            <label for="tsft" class="col-4 col-form-label text-right">
                Triceps Skin Fold Thickness
                <a target="_blank" href="https://goo.gl/HtfIUf"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input id="tsft" type="number" class="form-control" name="tsft" value="{{ old('tsft') }}" required>
                <p class="form-text text-muted">
                    <em>Normally 23 mm</em>
                </p>

                @if ($errors->has('tsft'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('tsft') }}</strong>
                    </p>
                @endif
            </div>
        </div>
        <div class="form-group mt-2 row{{ $errors->has('serum_insulin') ? ' has-danger' : '' }}">
            <label for="serum_insulin" class="col-4 col-form-label text-right">
                2-hr Serum Insulin (μU/ml)
                <a target="_blank" href="https://goo.gl/nkWyLd"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input id="serum_insulin" type="number" class="form-control" name="serum_insulin" value="{{ old('serum_insulin') }}" required>
                <p class="form-text text-muted">
                    <em>Normally 16-166μU/ml</em>
                </p>

                @if ($errors->has('serum_insulin'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('serum_insulin') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group mt-2 row{{ $errors->has('bmi') ? ' has-danger' : '' }}">
            <label for="bmi" class="col-4 col-form-label text-right">
                Body Mass Index
                <a target="_blank" href="https://goo.gl/xBaFUa"><i class="fa fa-question-circle-o"> </i></a>
            </label>

            <div class="col-6">
                <input id="bmi" type="number" step="0.0001" class="form-control" name="bmi" value="{{ old('bmi') }}" required>
                <p class="form-text text-muted">
                    <em>18.5 to 24.9 is considered to be healthy</em>
                </p>

                @if ($errors->has('bmi'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('bmi') }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <div class="form-group mt-2 row{{ $errors->has('dpf') ? ' has-danger' : '' }}">
            <label for="dpf" class="col-4 col-form-label text-right">
                Diabetes Pedigree Function
                <a href="javascript:;" data-toggle="modal" data-target="#diabetesPedigreeFunctionModal">
                    <i class="fa fa-question-circle-o"> </i>
                </a>
            </label>

            <div class="col-6">
                <input id="dpf" type="number" step="0.0001" class="form-control" name="dpf" value="{{ old('dpf') }}" required>

                @if ($errors->has('dpf'))
                    <p class="form-text text-muted text-danger">
                        <strong>{{ $errors->first('dpf') }}</strong>
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
    <div class="modal fade" id="diabetesPedigreeFunctionModal" tabindex="-1" role="dialog" aria-labelledby="diabetesPedigreeFunctionModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="diabetesPedigreeFunctionModalTitle">Diabetes Pedigree Function</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <p>The DPF Function uses information from parents, grandparents, full and half siblings, full and half aunts and uncles and first cousins.</p>
                                <p>It provides a measure of the expected genetic influence of affected and unaffected relatives on the patient's eventual diabetes risk. It is calculated using:</p>
                                <p>$$DPF = @{{\sum_{i}{K_i} (88-ADM_i) + 20} \over {\sum_{j}{K_j} (ALC_j - 14) + 50}}$$</p>
                                <p>
                                    <em>Where</em>
                                    <span class="d-block">${K_x\quad}$ is the percent of genes shared by the ${relative_x}$ and</span>
                                    <span class="d-block">${\qquad}$${\qquad}$equals 0.500 when the ${relative_x}$ is a parent or full sibling</span>
                                    <span class="d-block">${\qquad}$${\qquad}$equals 0.250 when the ${relative_x}$ is a half sibling, grandparent, aunt or uncle, and</span>
                                    <span class="d-block">${\qquad}$${\qquad}$equals 0.125 when the ${relative_x}$ is a half aunt, half uncle or first cousin</span>
                                    <span class="d-block">${ADM_i\quad}$ is the age in years of ${relative_i}$ when diabetes was diagnosed</span>
                                    <span class="d-block">${ALC_j\quad}$ is the age in years of ${relative_j}$ at the last diabetic examination (prior to patient's examination)</span>
                                </p>
                                <a href="https://goo.gl/GuUSgh" target="_blank" class="btn btn-link">Source</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endcomponent
@endsection

@include('layouts._mathjax')