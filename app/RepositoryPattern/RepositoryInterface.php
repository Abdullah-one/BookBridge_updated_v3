<?php
namespace App\RepositoryPattern;

use Illuminate\Http\Request;

interface RepositoryInterface
{
    public function addBookPackageDonation($request);
    public function searchAvailableBookPackages($request);

}
