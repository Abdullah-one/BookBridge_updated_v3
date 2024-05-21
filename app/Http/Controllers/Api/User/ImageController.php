<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookDonation\addBookPackageDonationRequest;
use App\Models\BookDonation;
use App\RepositoryPattern\ImageRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ImageController extends Controller
{
    protected ImageRepository $imageRepository;

    function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository=$imageRepository;
    }

    /**
     * @NotUsedDirectly used by function addBookPackageDonation in BookDonationController
     * @param addBookPackageDonationRequest $request (images)
     * @param int $bookDonation_id
     * @return void
     */
    //checked
    public function uploadImages(addBookPackageDonationRequest $request,int $bookDonation_id):void
    {

        if($request->hasFile('images')){
            $images=$request->file('images');
            foreach ($images as $key =>$image) {
                $name = time() . $key. '.' . $image->getClientOriginalExtension();
                //$image->storeAS('public/',$name);
                Storage::disk('public')->putFileAs('images/', $image, $name);
                $url = Storage::disk('public')->url('images/'.$name);
                $this->imageRepository->store($url,$bookDonation_id);

            }
        }

    }

    /**
     * @param addBookPackageDonationRequest $request (image, bookDonation_id)
     * @return void
     */
    public function uploadImage(Request $request):JsonResponse
    {

        try {
            $bookDonation_id = $request->bookDonation_id;
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if (!$bookDonation) {
                return response()->json(['status' => 'fail', 'message' => 'التبرع غير موجود']);

            }
            if (Gate::denies('isUser')) {
                return response()->json(['status'=>'fail','message'=>'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('UserCanDeleteOrUpdateBookDonation', $bookDonation)) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . rand(0, 9) . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('images/', $image, $name);
                $url = Storage::disk('public')->url('images/' . $name);
                $this->imageRepository->store($url, $bookDonation_id);
                return response()->json(['status'=>'success','data'=>$url]);
            }
            return response()->json(['status' => 'fail', 'message' => 'لا توجد صورة لإضافتها']);

        }
        catch (\Exception $exception){
            return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
        }

    }

    /**
     *
     * @NotUsedDirectly used by function addBookPackageDonation in BookDonationController
     * and function destroyByBookDonation_id in ImageController
     * @return void
     */
    //checked
    public function deleteImagesNotInDatabase(): void
    {
        $imagesSources=$this->imageRepository->getSourceOfAllImages();
        $files = Storage::disk('images')->files();
        foreach ($files as $file) {
            $exit=false;
            foreach ($imagesSources as $imagesSource) {
                if (strstr($imagesSource,$file)) {
                    $exit=true;
                    break;
                }
            }
            if(!$exit){
                Storage::disk('images')->delete($file);
            }
        }

    }
    /**
     * @param int $bookDonation_id
     * @return JsonResponse
     */
    //checked
    public function destroyByBookDonation_id(int $bookDonation_id):void
    {

            $isDeleted=$this->imageRepository->destroyByBookDonation_id($bookDonation_id);
            $this->deleteImagesNotInDatabase();

    }
    /**
     * @param int $id
     * @return JsonResponse
     */
    //checked
    public function destroy(int $id): JsonResponse
    {
        try {
            $image=$this->imageRepository->get($id);
            if (!$image) {
                return response()->json(['status' => 'fail', 'message' => 'الصورة غير موجودة']);

            }
            $bookDonation_id =$image->bookDonation_id;
            $bookDonation = BookDonation::find($bookDonation_id); //database/var
            if (Gate::denies('isUser')) {
                return response()->json(['status'=>'fail','message'=>'غير مصرح لهذا الفعل']);
            }
            if (Gate::denies('UserCanDeleteOrUpdateBookDonation', $bookDonation)) {
                return response()->json(['status' => 'fail', 'message' => 'غير مصرح لهذا الفعل']);
            }
            $isDeleted=$this->imageRepository->destroy($id);
            $source=strstr($image->source,'images/');
            $pureSource = substr($source, strlen('images/'));
            Storage::disk('images')->delete($pureSource);
            return response()->json(['status'=>'success']);
        }
        catch (Throwable $throwable){
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);
        }
    }



}
