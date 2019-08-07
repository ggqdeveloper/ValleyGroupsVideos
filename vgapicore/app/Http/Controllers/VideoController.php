<?php

    namespace App\Http\Controllers;

    use App\User;
    use Illuminate\Http\Request;
    use App\Helpers\JwtAuth;
    use App\Video;

    /**
     * Class VideoController
     *
     * @package App\Http\Controllers
     * Created by Dynamics365 ®.
     * User: Gilberto Guerrero Quinayas
     */
    class VideoController extends Controller
    {
        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function index(Request $request)
        {
            $videos = Video::all();

            foreach ($videos as $video) {
                $video->user;
            }

            $hash = $request->header('Authorization', null);
            $jwtAuth = new JwtAuth();

            $checkToken = $jwtAuth->checkToken($hash);

            if ($checkToken) {
                $data = array(
                    'data' => $videos,
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario autenticado'
                );
            } else {
                $data = array(
                    'data' => $videos,
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario no autenticado'
                );
            }

            return response()->json($data, 200);
        }

        /**
         * @return string
         */
        public function getDateFormat()
        {
            return 'Y-m-d H:i:s.u';
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function store(Request $request)
        {
            $hash = $request->input('authorization', null);
            $jwtAuth = new JwtAuth();

            $checkToken = $jwtAuth->checkToken($hash, false);

            if ($checkToken) {

                $json = $request->input('json', null);
                $params = json_decode($json);

                $user = $jwtAuth->checkToken($hash, true);

                $isset_user = User::where('id', '=', $user->sub)->first();

                if (isset($params->title) && isset($params->description)) {
                    $video = new Video();
                    $video->user_id = $isset_user->id;
                    $video->title = $params->title;
                    $video->description = $params->description;
                    $video->image = isset($params->image) ? $params->image : null;
                    $video->path = isset($params->path) ? $params->path : null;
                    $video->status = 'ACTIVO';

                    $video->save();

                    $data = array(
                        'data' => $video,
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Video creado'
                    );
                } else {
                    $data = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'El video no pudo ser creado'
                    );
                }

            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario no autenticado'
                );
            }

            return response()->json($data, 200);
        }

        public function destroy($id, Request $request)
        {
            $hash = $request->header('authorization', null);
            $jwtAuth = new JwtAuth();
            $checkToken = $jwtAuth->checkToken($hash, false);

            if ($checkToken) {

                $video = Video::find($id);

                $video->delete();

                $data = array(
                    'data' => $video,
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Video eliminado'
                );

            } else {
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario no autenticado'
                );
            }

            return response()->json($data, 200);
        }
    }
