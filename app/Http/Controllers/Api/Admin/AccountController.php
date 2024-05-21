<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\RepositoryPattern\AccountRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    protected AccountRepository $accountRepository;
    function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository=$accountRepository;
    }
    public function login(Request $request): JsonResponse
    {
        $emailOrPhone = $request->emailOrPhone;
        $account=$this->accountRepository->isExist($emailOrPhone,['admin','superAdmin']);
        $device_name=$request->device_name;
        if (!$account || !Hash::check($request->password, $account->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token=$account->createToken($device_name)->plainTextToken;
        return response()->json(['token'=>$token , 'user'=> ['userName'=>$account->userName,
            'role'=>$account->role] ]);
    }

}
