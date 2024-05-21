<?php

namespace App\RepositoryPattern;

use App\Models\User;

class UserRepository
{
    public function store(int $account_id): void
    {
        User::create([
            'account_id' => $account_id,
        ]);
    }

    public function incrementNo_bookingOfFirstSemester(User $user): void
    {
            $user->increment('no_bookingOfFirstSemester');
    }

    public function incrementNo_bookingOfSecondSemester(User $user): void
    {
        $user->increment('no_bookingOfSecondSemester');
    }

    public function decrementNo_bookingOfFirstSemester(User $user): void
    {
        $user->decrement('no_bookingOfFirstSemester');
    }

    public function decrementNo_bookingOfSecondSemester(User $user): void
    {
        $user->decrement('no_bookingOfSecondSemester');
    }

    public function updateNo_booking($user, $no_bookingOfFirstSemester, $no_bookingOfSecondSemester): void
    {
        $user->update([
            'no_bookingOfFirstSemester' => $no_bookingOfFirstSemester,
            'no_bookingOfSecondSemester' => $no_bookingOfSecondSemester
        ]);
    }


}
