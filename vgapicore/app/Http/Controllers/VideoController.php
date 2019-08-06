<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Helpers\JwtAuth;
    use App\Video;
    use Illuminate\Validation\ValidationException;

    class VideoController extends Controller
    {
        public function index(Request $request)
        {
            $videos = Video::all();

            foreach ($videos as $video) {
                $video->user->id;
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

        public function getDateFormat()
        {
            return 'Y-m-d H:i:s.u';
        }

        public function store(Request $request)
        {
            $hash = $request->header('Authorization', null);
            $jwtAuth = new JwtAuth();

            $checkToken = $jwtAuth->checkToken($hash);

            if ($checkToken) {
                $json = $request->input('json', null);
                $params = json_decode($json);

                $user = $jwtAuth->checkToken($hash, true);

                if (isset($params->title) && isset($params->description)) {
                    $video = new Video();
                    $video->user_id = $user->sub;
                    $video->title = $params->title;
                    $video->description = $params->description;
                    $video->image = isset($params->email) ? $params->image : null;
                    $video->path = isset($params->email) ? $params->path : null;
                    $video->status = 'ACTIVO';

                    $video->save();

                    $data = array(
                        'video' => $video,
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
    }
