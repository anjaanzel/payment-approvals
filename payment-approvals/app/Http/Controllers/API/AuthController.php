<?php
   
namespace App\Http\Controllers\API;

use App\Services\ResponseService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Validator;
   
class AuthController extends BaseController
{
    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if ($validator->fails()) {
            return $this->responseService->sendError('Validation Error.', $validator->errors());
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('API Token')->plainTextToken;
        $success['name'] =  $user->first_name;
   
        return $this->responseService->sendResponse($success, 'User register successfully.');
    }
   
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('API Token')->plainTextToken;
            $success['name'] =  $user->first_name;
   
            return $this->responseService->sendResponse($success, 'User login successfully.');
        } else {
            return $this->responseService->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
}
