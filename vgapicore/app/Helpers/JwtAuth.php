<?php
    /**
     * Created by Dynamics365 ®.
     * User: Gilberto Guerrero Quinayas
     */

    namespace App\Helpers;


    use Firebase\JWT\JWT;
    use Illuminate\Support\Facades\DB;
    use App\User;

    class JwtAuth
    {
        public function signup($email, $password, $getToken = null)
        {
            $user = User::where(
                array(
                    'email' => $email,
                    'password' => $password
                )
            )->first();

            $signup = false;

            if (is_object($user)) {
                $token = array(
                    'sub' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'iat' => time(),
                    'exp' => time() + (7 * 24 * 60 * 60)
                );

                $jwt = JWT::encode($token, env('APP_KEY'), 'HS256');

                $decode = JWT::decode($jwt, env('APP_KEY'), array('HS256'));

                if (is_null($getToken)) {
                    return $jwt;
                } else {
                    return $decode;
                }
            } else {
                $data = 400;

                return response()->json($data, 200);
            }
        }

        public function checkToken($jwt, $getIdentity = false)
        {
            $auth = false;

            try {
                $decode = JWT::decode($jwt, env('APP_KEY'), array('HS256'));
            } catch (\UnexpectedValueException $e) {
                $auth = false;
            } catch (\DomainException $e) {
                $auth = false;
            }

            if (isset($decode) && is_object($decode) && isset($decode->sub)) {
                $auth = true;
            } else {
                $auth = false;
            }

            if ($getIdentity) {
                return $decode;
            }

            return $auth;
        }
    }
