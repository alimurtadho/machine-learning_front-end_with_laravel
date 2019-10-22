<?php

namespace Tests\Feature\Prediction;

use Tests\TestCase;

class HeartDiseasePredictionTest extends TestCase
{
    protected $url = '/predict/heart';
    protected $defaultData = [
        'age'                     => 46,
        'sex'                     => 1,
        'cp'                      => 2,
        'resting_bp'              => 130,
        'serum_cholesterol'       => 200,
        'fasting_blood_sugar'     => 90,
        'resting_ecg'             => 0,
        'max_heart_rate'          => 120,
        'exercise_induced_angina' => 0,
        'st_depression'           => 3,
        'st_slope'                => 2,
        'number_of_vessels'       => 1,
        'thallium_scan_results'   => 3,
    ];

    /** @test */
    public function anyone_may_be_able_to_predict_heart_disease ()
    {
        $this->get($this->url)->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->disableExceptionHandling()->post($this->url);
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_age ()
    {
        $this->predict(['age' => null])
             ->assertSessionHasErrors('age');

        $this->predict(['age' => 0])
             ->assertSessionHasErrors('age');

        $this->predict(['age' => 101])
             ->assertSessionHasErrors('age');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_sex ()
    {
        $this->predict(['sex' => null])
             ->assertSessionHasErrors('sex');

        $this->predict(['sex' => 2])
             ->assertSessionHasErrors('sex');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_chest_pain ()
    {
        $this->predict(['cp' => null])
             ->assertSessionHasErrors('cp');

        $this->predict(['cp' => 5])
             ->assertSessionHasErrors('cp');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_resting_bp ()
    {
        $this->predict(['resting_bp' => null])
             ->assertSessionHasErrors('resting_bp');

        $this->predict(['resting_bp' => 301])
             ->assertSessionHasErrors('resting_bp');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_serum_cholesterol ()
    {
        $this->predict(['serum_cholesterol' => null])
             ->assertSessionHasErrors('serum_cholesterol');

        $this->predict(['serum_cholesterol' => 701])
             ->assertSessionHasErrors('serum_cholesterol');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_fasting_blood_sugar ()
    {
        $this->predict(['fasting_blood_sugar' => null])
             ->assertSessionHasErrors('fasting_blood_sugar');

        $this->predict(['fasting_blood_sugar' => 501])
             ->assertSessionHasErrors('fasting_blood_sugar');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_resting_ecg ()
    {
        $this->predict(['resting_ecg' => null])
             ->assertSessionHasErrors('resting_ecg');

        $this->predict(['resting_ecg' => 3])
             ->assertSessionHasErrors('resting_ecg');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_max_heart_rate ()
    {
        $this->predict(['max_heart_rate' => null])
             ->assertSessionHasErrors('max_heart_rate');

        $this->predict(['max_heart_rate' => 301])
             ->assertSessionHasErrors('max_heart_rate');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_exercise_induced_angina ()
    {
        $this->predict(['exercise_induced_angina' => null])
             ->assertSessionHasErrors('exercise_induced_angina');

        $this->predict(['exercise_induced_angina' => 2])
             ->assertSessionHasErrors('exercise_induced_angina');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_st_depression ()
    {
        $this->predict(['st_depression' => null])
             ->assertSessionHasErrors('st_depression');

        $this->predict(['st_depression' => -1])
             ->assertSessionHasErrors('st_depression');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_st_slope ()
    {
        $this->predict(['st_slope' => null])
             ->assertSessionHasErrors('st_slope');

        $this->predict(['st_slope' => 4])
             ->assertSessionHasErrors('st_slope');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_number_of_vessels ()
    {
        $this->predict(['number_of_vessels' => null])
             ->assertSessionHasErrors('number_of_vessels');

        $this->predict(['number_of_vessels' => 4])
             ->assertSessionHasErrors('number_of_vessels');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_thallium_scan_results ()
    {
        $this->predict(['thallium_scan_results' => null])
             ->assertSessionHasErrors('thallium_scan_results');

        $this->predict(['thallium_scan_results' => 8])
             ->assertSessionHasErrors('thallium_scan_results');
    }

    protected function predict ($overrides = [])
    {
        return $this->post($this->url, $overrides + $this->defaultData);
    }
}
