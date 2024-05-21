<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Http\Controllers\Controller;
use App\RepositoryPattern\AccountRepository;
use App\RepositoryPattern\AdminRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AccountController extends Controller
{
    protected AccountRepository $accountRepository;
    protected AdminRepository $adminRepository;
    function __construct(AccountRepository $accountRepository,AdminRepository $adminRepository)
    {
        $this->accountRepository=$accountRepository;
        $this->adminRepository=$adminRepository;
    }
    public function registerAdmin(Request $request): JsonResponse
    {
        Gate::authorize('IsSuperAdmin');
        $userName=$request->userName;
        $email=$request->email;
        $password=Hash::make($request->password);
        $phoneNumber=$request->phoneNumber;
        $cities_id=$request->cities_id;
        try {
            DB::beginTransaction();
            $account = $this->accountRepository->store($userName,$email, $phoneNumber, 'admin', $password);
            $admin=$this->adminRepository->store($account->id);
            if($cities_id) {
                foreach ($cities_id as $city_id) {
                    $admin->cities()->attach($city_id);
                }
            }
            DB::commit();
            return response()->json();
        }
        catch(Throwable $throwable){
            DB::rollBack();
            return response()->json(null,500);
        }
    }

    public function getAdmins(): JsonResponse
    {
        //Gate::authorize('IsSuperAdmin');
        return response()->json($this->accountRepository->getAdmins());

    }

    public function customGetAdmins(Request $request)
    {
        //Gate::authorize('IsSuperAdmin');
        $district=$request->district;
        $city_id =$request->city_id;
        return response()->json($this->accountRepository->customGetAdmins($district,$city_id));

    }

    public function getAdminByPhoneNumber(Request $request)
    {
        //Gate::authorize('IsSuperAdmin');
        $phoneNumber=$request->phoneNumber;
        return response()->json($this->accountRepository->getAdminByPhoneNumber($phoneNumber));
    }

    public function getAdminByUserName(Request $request)
    {
        //Gate::authorize('IsSuperAdmin');
        $userName=$request->userName;
        return response()->json($this->accountRepository->getAdminByUserName($userName));
    }
    public function getAdmin($id)
    {
        //Gate::authorize('IsSuperAdmin');
        return response()->json($this->accountRepository->getAdmin($id));
    }

    public function deleteAdmin($account_id): void
    {
        //Gate::authorize('IsSuperAdmin');
        $this->accountRepository->destroy($account_id);
    }

    public function updateAdmin(Request $request,$id)
    {
        $userName=$request->userName;
        $phoneNumber=$request->phoneNumber;
        $email=$request->email;
        $password=Hash::make($request->password);
        $this->accountRepository->update($id,$userName,$phoneNumber,$email,$password);
    }
}
