<?php

namespace Tests\Feature\Prediction;

use Tests\TestCase;

class DiabetesPredictionTest extends TestCase
{
    protected $url = '/predict/diabetes';
    protected $defaultData = [
        'age'                          => 46,
        'pregnant'                     => 1,
        'plasma_glucose_concentration' => 110,
        'diastolic_bp'                 => 70,
        'tsft'                         => 24,
        'serum_insulin'                => 35,
        'bmi'                          => 20,
        'dpf'                          => 2.5,
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
    public function predicting_heart_disease_requires_valid_pregnant ()
    {
        $this->predict(['pregnant' => null])
             ->assertSessionHasErrors('pregnant');

        $this->predict(['pregnant' => 45])
             ->assertSessionHasErrors('pregnant');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_plasma_glucose_concentration ()
    {
        $this->predict(['plasma_glucose_concentration' => null])
             ->assertSessionHasErrors('plasma_glucose_concentration');

        $this->predict(['plasma_glucose_concentration' => -1])
             ->assertSessionHasErrors('plasma_glucose_concentration');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_diastolic_bp ()
    {
        $this->predict(['diastolic_bp' => null])
             ->assertSessionHasErrors('diastolic_bp');

        $this->predict(['diastolic_bp' => -1])
             ->assertSessionHasErrors('diastolic_bp');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_tsft ()
    {
        $this->predict(['tsft' => null])
             ->assertSessionHasErrors('tsft');

        $this->predict(['tsft' => -1])
             ->assertSessionHasErrors('tsft');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_serum_insulin ()
    {
        $this->predict(['serum_insulin' => null])
             ->assertSessionHasErrors('serum_insulin');

        $this->predict(['serum_insulin' => -1])
             ->assertSessionHasErrors('serum_insulin');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_bmi ()
    {
        $this->predict(['bmi' => null])
             ->assertSessionHasErrors('bmi');

        $this->predict(['bmi' => -1])
             ->assertSessionHasErrors('bmi');
    }

    /** @test */
    public function predicting_heart_disease_requires_valid_dpf ()
    {
        $this->predict(['dpf' => null])
             ->assertSessionHasErrors('dpf');

        $this->predict(['dpf' => -1])
             ->assertSessionHasErrors('dpf');
    }

    protected function predict ($overrides = [])
    {
        return $this->post($this->url, $overrides + $this->defaultData);
    }
}
