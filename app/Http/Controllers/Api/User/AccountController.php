<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\phoneVerificationToken;
use App\RepositoryPattern\AccountRepository;
use App\RepositoryPattern\UserRepository;
use HTTP_Request2;
use HTTP_Request2_Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;
use Random\RandomException;
use Throwable;


class AccountController extends Controller
{
    protected AccountRepository $accountRepository;
    protected UserRepository $userRepository;
    function __construct(AccountRepository $accountRepository,UserRepository $userRepository)
    {
        $this->accountRepository=$accountRepository;
        $this->userRepository=$userRepository;
    }
    public function registerUserAccount(RegisterUserRequest $request): JsonResponse
    {
        $email=$request->email;
        $password=$request->password;
        $deviceName=$request->deviceName;
        $username = strstr($email, '@', true); // Extract characters before '@'
        if (strlen($username) > 20) {
            $username = substr($username, 0, 20); // Take the first 20 characters
        }
        try {
            DB::beginTransaction();
            $account = $this->accountRepository->store($username,$email, 'user', $password, false);
            $this->userRepository->store($account->id);
            $token=$account->createToken($deviceName)->plainTextToken;
            DB::commit();
            return response()->json(['status'=>'success','token'=>$token , 
                 'userName'=>$account->userName]);
        }
        catch (Throwable $throwable){
            DB::rollBack();
            return  response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);
        }


    }


    

    public function getGeneralInformation(): JsonResponse
    {
        $account=\auth()->user();
        return response()->json($this->accountRepository->getGeneralInformation($account->id));

    }

    public function showUserAccountInformation()
    {



    }

}
