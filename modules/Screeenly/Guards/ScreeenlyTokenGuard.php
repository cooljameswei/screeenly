<?php

namespace Screeenly\Guards;

use Screeenly\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;

class ScreeenlyTokenGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new authentication guard.
     *
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
    }

    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->request->get('key');

        if (! empty($token)) {
            $user = User::whereHas('apiKeys', function ($q) use ($token) {
                return $q->where('key', $token);
            })->get();
        }

        return $this->user = $user;
    }

    /**
     * @todo Implement this method
     */
    public function validate(array $credentials = [])
    {
        dd($credentials);
    }
}
