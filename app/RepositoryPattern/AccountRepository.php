<?php

namespace App\RepositoryPattern;

use App\Models\Account;
use App\Models\Admin;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountRepository
{

    public function exist(string $phoneNumber)
    {
        return Account::where([
            'phoneNumber'=> $phoneNumber,
            'phoneVerified' => true
        ])
            ->first();
    }

    public function store(string $userName,string $email, string $role, string $password, bool $exist=false)
    {
        return Account::create([
            'userName' => $userName,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'exist' => $exist
        ]);

    }

    public function removePhoneNumber(Account $account): void
    {
        $account->update([
            'phoneNumber' => null,
            'phoneVerified' => false,
            'exist' => false
        ]);

    }

    public function RegisterExchangePoint()
    {

    }
    public function destroy($account_id): void
    {
        $account=Account::find($account_id);
        $account->forceDelete();
    }

    public function deletetoken($account, $token): void
    {
        $account->tokens()->where('token',$token)->delete();
    }

    public function getAdmins(): Collection
    {
        return DB::table('accounts')
            ->where('role','admin')
            ->select([
                'id',
                'userName',
                'phoneNumber',
                'email',
                'password',
                DB::raw('Date(created_at) as date')

            ])
            ->orderBy('created_at')
            ->get();

    }

    /*
    public function customGetAdmins($district,$city_id)
    {
        $admin= Admin::whereHas('cities', function (\Illuminate\Database\Eloquent\Builder $query) use ($city_id, $district) {
                $query->when($district, function (\Illuminate\Database\Eloquent\Builder $query) use ($city_id, $district) {
                    $query->where('cities.district', $district)
                        ->when($city_id, function (\Illuminate\Database\Eloquent\Builder $query) use ($city_id, $district) {
                            $query->where('cities.id', $city_id);
                        });
                });
            })
            ->with('account')


                ->select([
                    'account.id',
                    'account.userName',
                    'account.phoneNumber',
                    'account.email',
                    'account.password',
                    DB::raw('Date(account.created_at) as date')

                ])
                ->orderBy('account.created_at')
                ->get();
    }
    */

    public function customGetAdmins($district,$city_id): Collection
    {

        return DB::table('admins')->join('accounts','account_id','=','accounts.id')
            ->join('admin_city','admins.id','=','admin_id')
            ->join('cities',function (JoinClause $join) use ($city_id, $district) {
                $join->on('city_id','=','cities.id')
                    ->when($district, function (Builder $query) use ($city_id, $district) {
                        $query->where('cities.district', $district)
                            ->when($city_id, function (Builder $query) use ($city_id, $district) {
                                $query->where('cities.id', $city_id);
                            });
                    });
            })
            ->select([
                'accounts.id',
                'accounts.userName',
                'accounts.phoneNumber',
                'accounts.email',
                DB::raw('Date(accounts.created_at) as date')

            ])
            ->distinct()
            ->orderBy('accounts.created_at')
            ->get();


    }


    public function getAdminByPhoneNumber($phoneNumber)
    {
        return Account::where([
                'phoneNumber'=>$phoneNumber,
                'role'=>'admin'
            ])
            ->select([
                'id',
                'userName',
                'phoneNumber',
                'email',
                'password',
                DB::raw('Date(created_at) as date')
            ])
            ->orderBy('created_at')
            ->get();
    }

    public function getAdmin(int $id)
    {
        return Account::where([
            'id'=>$id,
            'role'=>'admin'
        ])
            ->select([
                'id',
                'userName',
                'phoneNumber',
                'email',
                'password',
                DB::raw('Date(created_at) as date')
            ])
            ->orderBy('created_at')
            ->get();
    }

    public function getAdminByUserName(string $userName)
    {
        return Account::where('userName','like',$userName.'%')
            ->where('role','admin')
            ->select([
                'id',
                'userName',
                'phoneNumber',
                'email',
                'password',
                DB::raw('Date(created_at) as date')
            ])
            ->orderBy('created_at')
            ->get();
    }

    public function update($id,string $userName,string $phoneNumber,string $email,string $password)
    {
        $account=Account::find($id);
        if ($account) {
            $account->update([
                'userName' => $userName,
                'phoneNumber' => $phoneNumber,
                'email' => $email,
                'password' => $password
            ]);
            return true;
        }
        return false;
    }

    public function isExist(String $emailOrPhone,$roles)
    {
        return Account::where(function (\Illuminate\Database\Eloquent\Builder $builder) use ($emailOrPhone) {
            $builder->where('email', $emailOrPhone)
                ->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) use ($emailOrPhone) {
                    $query->where('phoneNumber', $emailOrPhone)
                        //TODO:put as true
                        ->where('phoneVerified',true);

                });
        })
        ->whereIn('role',$roles)
        ->first();
    }

    public function getGeneralInformation(int $account_id)
    {
        return DB::table('accounts')->where('id',$account_id)
            ->select([
                'userName',
                'phoneVerified',
                'role',
                'email',
            ])
            ->first();
    }


}
