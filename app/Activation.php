<?php

namespace App;

use App\Notifications\SendActivationEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'user_activations';

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = [];

    /**
     * Activation belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public static function createTokenAndSendEmail (User $user)
    {
        $activations = self::where('user_id', $user->id)
                           ->where('created_at', '>=',
                               Carbon::now()->subHours(config('settings.user.activation.valid_hours')));

        if ($activations->count() >= config('settings.user.activation.max_attempts')) {
            return;
        }

        $activation = self::createNewActivationToken($user);

        $user->notify(new SendActivationEmail($activation->token));
    }

    protected static function createNewActivationToken (User $user)
    {
        $activation          = new static;
        $activation->user_id = $user->id;
        $activation->token   = str_random(64);
        $activation->save();

        return $activation;
    }

    public static function deleteExpiredActivations ()
    {
        self::where('created_at', '<', Carbon::now()->subHours(config('settings.user.activation.valid_hours')))->delete();
    }

    public static function getActivationByToken ($token)
    {
        return self::where('token', $token)
                   ->where('created_at', '>=',
                       Carbon::now()->subHours(config('settings.user.activation.valid_hours')))
                   ->first();
    }

    public static function deleteActivationToken ($token)
    {
        self::where('token', $token)->delete();
    }

    public function activate()
    {
        $this->user->update(['activated' => true]);

        $this->delete();
    }
}