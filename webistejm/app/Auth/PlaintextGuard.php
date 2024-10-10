<?php

// namespace App\Auth;

// use Illuminate\Auth\SessionGuard;
// use Illuminate\Contracts\Auth\UserProvider;
// use Illuminate\Contracts\Session\Session;
// use Illuminate\Http\Request;

// class PlaintextGuard extends SessionGuard
// {
//     public function __construct(UserProvider $provider, Session $session, Request $request)
//     {
//         parent::__construct('plaintext', $provider, $session, $request);
//     }

//     public function attempt(array $credentials = [], $remember = false)
//     {
//         $this->fireAttemptEvent($credentials, $remember);

//         $user = $this->provider->retrieveByCredentials($credentials);

//         if ($this->hasValidCredentials($user, $credentials)) {
//             $this->login($user, $remember);
//             return true;
//         }

//         $this->fireFailedEvent($user, $credentials);
//         return false;
//     }

//     protected function hasValidCredentials($user, $credentials)
//     {
//         return $user && $user->getAuthPassword() === $credentials['password'];
//     }
// }
