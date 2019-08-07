<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use App\User;
    use App\Helpers\JwtAuth;

    /**
     * Class UserController
     *
     * @package App\Http\Controllers
     * Created by Dynamics365 ®.
     * User: Gilberto Guerrero Quinayas
     */
    class UserController extends Controller
    {
        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function register(Request $request)
        {
            $json = $request->input('json', null);
            $params = json_decode($json);

            $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
            $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
            $surname = (!is_null($json) && isset($params->surname)) ? $params->surname : null;
            $role = 'USER';
            $password = (!is_null($json) && isset($params->password)) ? $params->password : null;

            if (!is_null($email) && !is_null($name) && !is_null($password)) {
                $user = new User();
                $user->email = $email;
                $user->name = $name;
                $user->surname = $surname;
                $user->role = $role;
                $user->password = $password;

                $pwd = hash('sha256', $password);
                $user->password = $pwd;

                $isset_user = User::where('email', '=', $email)->first();

                if (!$isset_user) {
                    $user->save();

                    $data = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Usuario registrado correctamente'
                    );
                } else {
                    $data = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'Usuario duplicado, no puede registrarse'
                    );
                }
            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario no creado'
                );
            }

            return response()->json($data, 200);
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function login(Request $request)
        {
            $jwtAuth = new JwtAuth();

            $json = $request->input('json', null);
            $params = json_decode($json);

            $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
            $password = (!is_null($json) && isset($params->password)) ? $params->password : null;
            $getToken = (!is_null($json) && isset($params->getToken)) ? $params->getToken : null;

            $pwd = hash('sha256', $password);

            if (!is_null($email) && !is_null($password) && ($getToken == null || $getToken == false)) {
                $signup = $jwtAuth->signup($email, $pwd);

                return response()->json($signup, 200);
            } else if ($getToken != null) {
                $signup = $jwtAuth->signup($email, $pwd, $getToken);

                return response()->json($signup, 200);
            } else {
                $signup = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Envia tus datos por POST'
                );
            }

            return response()->json($signup, 200);
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function edit(Request $request)
        {
            $json = $request->input('json', null);
            $params = json_decode($json);

            $email = (!is_null($json) && isset($params->email)) ? $params->email : null;
            $name = (!is_null($json) && isset($params->name)) ? $params->name : null;
            $surname = (!is_null($json) && isset($params->surname)) ? $params->surname : null;
            $password = (!is_null($json) && isset($params->password)) ? $params->password : null;

            if (!is_null($email) && !is_null($name) && !is_null($password)) {
                $user = User::where('email', '=', $email)->first();
                $user->name = $name;
                $user->surname = $surname;
                $user->password = $password;

                $pwd = hash('sha256', $password);
                $user->password = $pwd;

                $user->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario actualizado correctamente'
                );
            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario no actualizado'
                );
            }

            return response()->json($data, 200);
        }
    }
