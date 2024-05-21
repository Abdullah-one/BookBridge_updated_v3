<?php

namespace App\RepositoryPattern;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminRepository
{
    public function store(int $account_id){
        return Admin::create([
            'account_id'=>$account_id,
        ]);
    }



}
