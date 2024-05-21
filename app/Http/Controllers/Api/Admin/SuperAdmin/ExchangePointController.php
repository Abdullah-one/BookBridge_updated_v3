<?php

namespace App\Http\Controllers\Api\Admin\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExchangePointRequest;
use App\Models\Account;
use App\RepositoryPattern\AccountRepository;
use App\RepositoryPattern\ExchangePointRepository;
use App\RepositoryPattern\ResidentialQuarterRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ExchangePointController extends Controller
{
    protected ExchangePointRepository $exchangePointRepository;
    protected AccountRepository $accountRepository;

    function __construct(AccountRepository $accountRepository,ExchangePointRepository $exchangePointRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->exchangePointRepository = $exchangePointRepository;
    }

    public function getByResidentialQuarter(Request $request): JsonResponse
    {
        $residentialQuarter_id=$request->residentialQuarter_id;
        $district=$request->district;
        $city_id=$request->city_id;
        return response()->json($this->exchangePointRepository->getByResidentialQuarter($residentialQuarter_id,$district,$city_id));
    }

    public function customGet(Request $request): JsonResponse
    {

        $residentialQuarter_id=$request->residentialQuarter_id;
        $district=$request->district;
        $city_id=$request->city_id;
        return response()->json($this->exchangePointRepository->customGet($residentialQuarter_id,$district,$city_id));
    }

    public function register(ExchangePointRequest $request): void
    {
        try {
            $userName = $request->userName;
            $phoneNumber = $request->phoneNumber;
            $email = $request->email;
            $maxPackages = $request->maxPackages;
            $locationDescription= $request->locationDescription;
            $location=$request->location;
            $residentialQuarter_id = $request->residentialQuarter_id;
            $password = Hash::make($request->password);
            DB::beginTransaction();
            $account=$this->accountRepository->store($userName,$email, $phoneNumber, 'point',  $password);
            $this->exchangePointRepository->store($account->id,$residentialQuarter_id,$maxPackages,$locationDescription,$location);
            DB::commit();
        }
        catch (\Throwable $throwable){
            DB::rollBack();
            abort(500);
        }
    }

    public function get($id)
    {
        return response()->json($this->exchangePointRepository->get($id));
    }

    public function update($id,ExchangePointRequest $request): void
    {
        $userName = $request->userName;
        $phoneNumber = $request->phoneNumber;
        $email = $request->email;
        $maxPackages = $request->maxPackages;
        $locationDescription= $request->locationDescription;
        $location=$request->location;
        $residentialQuarter_id = $request->residentialQuarter_id;
        $password = Hash::make($request->password);
        try {
            DB::beginTransaction();
            $result=$this->accountRepository->update($id, $userName, $phoneNumber,$email,$password);
            if (!$result) {
                abort(404);
                DB::rollBack();
            }
            $exchangePoint_id=Account::find($id)->exchangePoint->id;
            $this->exchangePointRepository->update($exchangePoint_id, $residentialQuarter_id, $maxPackages,$locationDescription,$location);
            DB::commit();

        }
        catch (\Throwable $throwable){
            DB::rollBack();
            abort(500);
        }
    }

    public function getRemovableResidentialQuarters(): JsonResponse
    {
        return \response()->json($this->exchangePointRepository->getRemovableResidentialQuarters());
    }

    public function destroyRemovableResidentialQuarter($id): void
    {

        $result = $this->residentialQuarterRepository->destroy($id);
        if (!$result) {
            abort(404);
        }
    }

    public function softDelete($id): JsonResponse
    {
        return \response()->json($this->exchangePointRepository->softDelete($id));
    }

}
