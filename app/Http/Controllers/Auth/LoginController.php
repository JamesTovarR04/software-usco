<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class LoginController extends Controller
{

    /**
     * Redirect the user to the provider authentication page.
     * 
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from provider and log in the user.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {

        if($request->get('error'))
            return redirect('/login');

        try{
            $userSocialite = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            return $this->logout($request);
        }

        $user_profile = User::where('provider_id', $userSocialite->getId() )->first();

        // Si el usuario no esta en la base de datos
        if (!$user_profile)
        {
            $attributes = [
                'provider_id' => $userSocialite->getId(),
                'name' => ucwords(strtolower($userSocialite->getName())),
                'email' => $userSocialite->getEmail(),
                'codigo' => strstr(substr($userSocialite->getEmail(),1), '@', true),
                'photo_profile' => $userSocialite->getAvatar(),
            ];

            $user_profile = User::create($attributes);
            Auth::login($user_profile);
            return $this->addProgram($request);
        }

        Auth::login($user_profile);

        // Si el usuario no tiene un programa registrado
        if (!$user_profile->program_id)
            return $this->addProgram($request);

        return redirect('/student');

        // Token API
        // $token = $user_profile->createToken('Token-user')->plainTextToken;
        // return response()->json($user_profile, 200, ['Access-Token' => $token]);

    }

    /**
     * redirect to the page to register the program
     * 
     * @return Response
     */
    public function addProgram(Request $request)
    {
        $user = $request->user();

        return view('Auth/programa', [
            'name' => explode(" ",$user->name)[0],
            'cohorte' => date('Y').'1'
        ]);
    }

    /**
     * Obtain the user information from provider and log in the user.
     *
     * @return Response
     */
    public function logout(Request $request)
    {
        // Web
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // API
        // $request->user()->tokens()->delete();

        return redirect('/login');
    }

}