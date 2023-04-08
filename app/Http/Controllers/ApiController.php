<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpOption\None;
use Psy\Util\Json;

class ApiController extends Controller
{
    public function ping() : string
    {
        return 'pong';
    }

    public function action_upload_file(Request $request) : string
    {
        $data = [];

        if($request->file('file')) {

            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();

            $extension = $file->getClientOriginalExtension();

            $location = 'files';

            try {

                $file->move($location,$filename);
            }
            catch (Exception $e) {

                Log::info($e->getMessage());
            }

            $filepath = url('files/'.$filename);

            $data['success'] = 1;
            $data['message'] = 'Uploaded Successfully!';
            $data['filepath'] = $filepath;
            $data['extension'] = $extension;
        }

        return json_encode($data);
    }

    public function create_token(Request $request)
    {
        $userid = request('userid');

        $user = User::where('id', 1)->first();

        if (!$user) {

            return response()->json(['success' => false,
                'error' => 'no user found by this id.!']);
        }

        //create jwt, despite of searching a lot couldn't find the method, unfortunately

        $token = 'blobblobblob'; // for example, cause i coultn't create token

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 // for expiration
        ]);
    }

    public function get_user(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($credentials, $rules);

        if ($validator->fails()) {
            $error = $validator->messages()->toJson();
            return response()->json(['success' => false, 'error' => $error]);
        }

        if ($token = $this->guard()->attempt($credentials)) {

            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
}
