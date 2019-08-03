<?php

    namespace App\Http\Controllers;

    use App\Helpers\JwtAuth;
    use Illuminate\Http\Request;
    use App\Comment;

    class CommentController extends Controller
    {
        public function index(Request $request)
        {
            $hash = $request->header('Authorization', null);
            $jwtAuth = new JwtAuth();

            $checkToken = $jwtAuth->checkToken($hash);

            if ($checkToken) {
                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario autenticado'
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

        public function store(Request $request)
        {
            $hash = $request->header('Authorization', null);
            $jwtAuth = new JwtAuth();

            $checkToken = $jwtAuth->checkToken($hash);

            if ($checkToken) {
                $json = $request->input('json', null);
                $params = json_decode($json);

                $user = $jwtAuth->checkToken($hash, true);

                if (isset($params->body)) {
                    $comment = new Comment();
                    $comment->user_id = $user->sub;
                    $comment->video_id = $params->video_id;
                    $comment->body = $params->body;
                    $comment->status = 'ACTIVO';

                    $comment->save();

                    $data = array(
                        'video' => $comment,
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
