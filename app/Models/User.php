<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'credits',
        'referred_by',
        'referral_code',
        'account_id',
        'account_type',
        'subscription_expires_at',
        'subscription_plan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'subscription_expires_at' => 'datetime',
        ];
    }

    /**
     * Get the user's favorite document templates.
     */
    public function favoriteDocuments()
    {
        return $this->belongsToMany(DocumentTemplate::class)->withTimestamps();
    }

    /**
     * Get the user who referred this user.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Get the users referred by this user.
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->referral_code = \Illuminate\Support\Str::random(10);
            $user->account_id = 'UID-' . strtoupper(\Illuminate\Support\Str::random(8));
            $user->credits = 50; // Give 50 free trial credits on signup
        });
    }

    /**
     * Check if user has an active subscription.
     */
    public function hasActiveSubscription()
    {
        if (\App\Models\Setting::where('key', 'paid_service_status')->value('value') === 'off') {
            return true;
        }
        return $this->subscription_expires_at && $this->subscription_expires_at->isFuture();
    }

    /**
     * Deduct credit and pay 20% commission to referrer if applicable.
     */
    public function deductCreditAndPayCommission($amount, $sourceType = 'Service Usage')
    {
        if ($this->hasActiveSubscription()) {
            return true;
        }

        $this->credits -= $amount;
        $this->save();

        if ($this->referred_by && $amount > 0) {
            $referrer = self::find($this->referred_by);
            if ($referrer) {
                $commission = $amount * 0.20; // 20%
                $referrer->credits += $commission;
                $referrer->save();

                \App\Models\ReferralEarning::create([
                    'referrer_id' => $referrer->id,
                    'referred_user_id' => $this->id,
                    'amount' => $commission,
                    'source_type' => $sourceType,
                ]);
            }
        }
    }
}
