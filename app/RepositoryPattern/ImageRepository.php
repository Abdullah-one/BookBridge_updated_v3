<?php

namespace App\RepositoryPattern;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ImageRepository{

    /**
     * used by uploadImage, uploadImages functions in ImageController
     *
     * @param string $path
     * @param int $id
     * @return void
     */
    //check
    public function store(string $path,int $id): void
    {
        Image::create([
            'bookDonation_id' => $id,
            'source' => $path
        ]);
    }
    /**
     * @param int $bookDonation_id
     * @return int
     */
    //check
    public function destroyByBookDonation_id(int $bookDonation_id): int
    {
        return DB::table('images')->where('bookDonation_id',$bookDonation_id)->delete();

    }
    /**
     * @param int $id
     * @return int
     */
    //check
    public function destroy(int $id): int
    {
        return DB::table('images')->where('id',$id)->delete();

    }
    /**
     * used by function deleteImagesNotInDatabase in ImageController
     * @return Collection
     */

    //checked
    public function getSourceOfAllImages():Collection
    {
        return Image::pluck('source');

    }

    //checked


    public function get($id)
    {
        return DB::table('images')->find($id);
    }




}
