<?php

namespace App\RepositoryPattern;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class TransactionRepository
{
    public function store(int $bookDonation_id,string $status,int $user_id=0)
    {
        return Transaction::create([
            'bookDonation_id' => $bookDonation_id,
            'user_id' => $user_id,
            'status' => $status
        ]);
    }

    public function updateStatus($id,$status)
    {
        $transaction=Transaction::find($id);
        $transaction->update([
            'status' => $status
        ]);

    }

    public  function getRejectedDonationsTransactions(int $exchangePoint_id): Collection
    {
        return DB::table('transactions')->where('status','تم رفض التبرع')
            ->join('book_donations',function ($join) use ($exchangePoint_id) {
                $join->on('transactions.bookDonation_id','=','book_donations.id')
                    ->where('book_donations.exchangePoint_id',$exchangePoint_id);
            })
            ->join('users','transactions.user_id','=','users.id')
            ->join('accounts','users.account_id','=','accounts.id')
            ->select([
                'book_donations.id',
                'transactions.id',
                'accounts.userName',
                'book_donations.level',
                'book_donations.semester',
                'transactions.created_at'
            ])
            ->orderBy('transactions.created_at')
            ->get();
    }
    public function getDeliveredDonationsTransactions(int $exchangePoint_id): Collection
    {
        return DB::table('transactions')->where('status','تم التسليم')
            ->join('book_donations',function ($join) use ($exchangePoint_id) {
                $join->on('transactions.bookDonation_id','=','book_donations.id')
                    ->where('book_donations.exchangePoint_id',$exchangePoint_id);
            })
            ->join('users','transactions.user_id','=','users.id')
            ->join('accounts','users.account_id','=','accounts.id')
            ->select([
                'book_donations.id',
                'accounts.userName',
                'book_donations.level',
                'book_donations.semester',
                'transactions.canCancel',
                'transactions.created_at'
            ])
            ->get();
    }

    public function getReceptionDonationsTransactions(int $exchangePoint_id): Collection
    {
        return DB::table('transactions')->where('status','تم استلام التبرع')
            ->join('book_donations',function ($join) use ($exchangePoint_id) {
                $join->on('transactions.bookDonation_id','=','book_donations.id')
                    ->where('book_donations.exchangePoint_id',$exchangePoint_id);
            })
            ->join('users','transactions.user_id','=','users.id')
            ->join('accounts','users.account_id','=','accounts.id')
            ->select([
                'book_donations.id',
                'accounts.userName',
                'book_donations.level',
                'book_donations.semester',
                'transactions.canCancel',
                'transactions.created_at'
            ])
            ->get();
    }

    public function getRejectedPackageFromBeneficiaryTransactions(int $exchangePoint_id): Collection
    {
        return DB::table('transactions')->where('status','تم رفض الاستلام')
            ->join('book_donations',function ($join) use ($exchangePoint_id) {
                $join->on('transactions.bookDonation_id','=','book_donations.id')
                    ->where('book_donations.exchangePoint_id',$exchangePoint_id);
            })
            ->join('users','transactions.user_id','=','users.id')
            ->join('accounts','users.account_id','=','accounts.id')
            ->select([
                'book_donations.id',
                'accounts.userName',
                'book_donations.level',
                'book_donations.semester',
                'transactions.canCancel',
                'transactions.created_at'
            ])
            ->get();
    }

}
