<?php

    namespace App\Http\Controllers;

    use App\Helpers\JwtAuth;
    use App\Video;
    use Illuminate\Http\Request;
    use App\Comment;

    /**
     * Class CommentController
     *
     * @package App\Http\Controllers
     * Created by Dynamics365 ®.
     * User: Gilberto Guerrero Quinayas
     */
    class CommentController extends Controller
    {
        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function index(Request $request)
        {
            $comments = Comment::all();

            $hash = $request->header('Authorization', null);
            $jwtAuth = new JwtAuth();

            $checkToken = $jwtAuth->checkToken($hash);

            if ($checkToken) {
                $data = array(
                    'data' => $comments,
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Usuario autenticado'
                );
            } else {
                $data = array(
                    'data' => $comments,
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Usuario no autenticado'
                );
            }

            return response()->json($data, 200);
        }

        /**
         * @param Request $request
         * @return \Illuminate\Http\JsonResponse
         */
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
