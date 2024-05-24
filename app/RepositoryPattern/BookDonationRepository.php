<?php
namespace App\RepositoryPattern;

use App\Models\BookDonation;
use App\Models\ExchangePoint;
use App\Models\Transaction;
use App\orignalClassOfProvider\phoneNumberFaker;
use http\Client\Curl\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Mockery\Exception;
use function Laravel\Prompts\select;

class BookDonationRepository {

    public function store($request): BookDonation
    {
        return BookDonation::create([
            // TODO: Edit the value of donor_id
            'donor_id' => auth()->user()->user->id,
            'exchangePoint_id' => $request->exchangePoint_id,
            'level' => $request->level,
            'semester' => $request->semester,
            'description' => $request->description,
            'donorName'=> $request->donorName
        ]);
    }

    public function get(int $id)
    {
        return BookDonation::with(['images' => function ($query) use ($id) {
            $query->select('id', 'bookDonation_id', 'source');
        }])
            ->where('book_donations.id', $id)
            ->join('exchange_points', 'book_donations.exchangePoint_id', '=', 'exchange_points.id')
            ->join('residential_quarters', 'exchange_points.residentialQuarter_id', '=', 'residential_quarters.id')
            ->join('accounts', 'exchange_points.account_id', '=', 'accounts.id')
            ->select([
                'book_donations.id',
                'accounts.userName as Point name',
                'book_donations.level',
                'book_donations.semester',
                'book_donations.description',
                'exchange_points.location',
                'residential_quarters.name as residential quarter',
                DB::raw('Date(book_donations.created_at) as date'),
            ])
            ->first();

    }

    /*
    public function getN0_UnrecievedDonations(int $donor_id): int
    {
        return DB::table('book_donations')->where([
            'donor_id'=>$donor_id,
            'status'=>'غير محجوز وليس في النقطة'
        ])
            ->count();

    }
    */
    /*
    public function CanBooked(int $exchangePoint_id):bool
    {
        $exchangePoint=ExchangePoint::find($exchangePoint_id);
        $no_packages=$exchangePoint->no_packages;
        $maxPackages=$exchangePoint->maxPackages;
        if()

    }
    */

    public function getNo_donationsWaitedToBeBooked($donor_id, $exchangePoint_id): int
    {
        return DB::table('book_donations')->where([
            'donor_id' => $donor_id,
            'exchangePoint_id' => $exchangePoint_id,
            'status' => 'غير محجوز وليس في النقطة'
        ])->count();
    }



    public function searchAvailableBookPackages($request): JsonResponse
    {
        $level=$request->level;
        $exchangePoint_id=$request->exchangePoint_id;
        $semester=$request->semester;
        $inPoint=$request->inPoint;
        $residentialQuarter_id=$request->residentialQuarter_id;
        //$user=auth()->user();
        $availableBookPackages = BookDonation::with(['images' => function ($query)  {
            $query->select('id', 'bookDonation_id', 'source');
        }])
            ->where(function ( $query) use ($inPoint) {
                if($inPoint){
                    $query->where('book_donations.status','=','غير محجوز في النقطة');
                }
                else{
                    $query->where('book_donations.status','=','غير محجوز في النقطة')
                        ->orWhere('book_donations.status','=','غير محجوز وليس في النقطة');
                }
            })
            //->where('book_donations.donor_id','!=',$user->id)
            ->when($level , function ( $query, string $level){
                $query->where('book_donations.level',$level);
            })
            ->when($semester , function ( $query, string $semester){
                $query->where('book_donations.semester',$semester);
            })
            ->when($exchangePoint_id, function ( $query, string $exchangePoint_id){
                $query->where('book_donations.exchangePoint_id',$exchangePoint_id);
            })
            ->join('exchange_points',function (JoinClause $join) use ($residentialQuarter_id) {
                $join->on('book_donations.exchangePoint_id', '=', 'exchange_points.id')
                    ->where('maxPackages','>',DB::raw('no_packages'))
                    ->when($residentialQuarter_id,function ( $query,string $residentialQuarter_id){
                        $query->where('exchange_points.residentialQuarter_id',$residentialQuarter_id);
                    });
            })
            ->join('residential_quarters',function (JoinClause $join)  {
                $join->on('exchange_points.residentialQuarter_id','=','residential_quarters.id');
            })
            ->join('accounts as pointAccount', 'exchange_points.account_id', '=', 'pointAccount.id')
            ->select([
                'book_donations.id',
                'pointAccount.userName as pointName',
                'book_donations.donorName',
                'book_donations.level',
                'book_donations.semester',
                'exchange_points.location',
                'residential_quarters.name as residential_quarter',
                DB::raw('Date(book_donations.created_at) as date')

            ])
            ->addSelect(DB::raw('IF(status = "غير محجوز في النقطة", true, false) as isInPoint'))
            ->orderByDesc('book_donations.created_at')
            ->paginate();
        return response()->json(['status'=>'success','data'=>$availableBookPackages]);
    }

    public function getLastDonations()
    {
        return BookDonation::with(['images' => function ($query)  {
            $query->select('id', 'bookDonation_id', 'source');
            }])
            ->where('book_donations.status','=','غير محجوز في النقطة')
            ->orWhere('book_donations.status','=','غير محجوز وليس في النقطة')
            ->join('exchange_points',function (JoinClause $join){
                $join->on('book_donations.exchangePoint_id', '=', 'exchange_points.id')
                    ->where('maxPackages','>',DB::raw('no_packages'));
            })
            ->join('residential_quarters',function (JoinClause $join)  {
                $join->on('exchange_points.residentialQuarter_id','=','residential_quarters.id');
            })
            ->join('accounts as pointAccount', 'exchange_points.account_id', '=', 'pointAccount.id')
            ->select([
                'book_donations.id',
                'pointAccount.userName as pointName',
                'book_donations.donorName',
                'book_donations.level',
                'book_donations.semester',
                'exchange_points.location',
                'residential_quarters.name as residential_quarter',
                DB::raw('Date(book_donations.created_at) as date')

            ])
            ->addSelect(DB::raw('IF(status = "غير محجوز في النقطة", true, false) as isInPoint'))
            ->orderByDesc('book_donations.created_at')
            ->paginate();

    }

    public function getUndeliveredDonations(int $donor_id): LengthAwarePaginator
    {
        return DB::table('book_donations')->where([
            'donor_id'=>$donor_id,
            'status'=>'غير محجوز وليس في النقطة'
            ])
            ->join('exchange_points','exchangePoint_id','=','exchange_points.id')
            ->join('accounts','account_id','=','accounts.id')
            ->join('residential_quarters','residentialQuarter_id','=','residential_quarters.id')
            ->select([
                'book_donations.id',
                'book_donations.level',
                'book_donations.semester',
                'accounts.userName as point',
                'book_donations.created_at',
                (DB::raw('residential_quarters.name AS residentialQuarter')),
            ])
            ->orderByDesc('book_donations.created_at')
            ->paginate();
    }

    public function getWaitedDonations(int $donor_id): LengthAwarePaginator
    {

        return DB::table('book_donations')->where([
            'donor_id'=>$donor_id,
            'book_donations.status'=>'محجوز في انتظار الاستلام'
            ])
            ->join('exchange_points','exchangePoint_id','=','exchange_points.id')
            ->join('accounts','account_id','=','accounts.id')
            ->join('reservations', function ($join) {
                $join->on('book_donations.id', '=', 'reservations.bookDonation_id')
                    ->where('reservations.status', 'بانتظار استلامها من المتبرع');
            })
            ->join('residential_quarters','residentialQuarter_id','=','residential_quarters.id')
            ->select([
                (DB::raw('reservations.user_id AS beneficiary_id')),
                'book_donations.id',
                'book_donations.level',
                'book_donations.semester',
                'accounts.userName AS point',
                'book_donations.created_at',
                'startLeadTimeDateForDonor',
                (DB::raw('residential_quarters.name AS residentialQuarter')),
            ])
            ->orderByDesc('book_donations.created_at')
            ->paginate();

    }
    public function getReservationOfBeneficiary($id)
    {
        return DB::table('reservations')->where('bookDonation_id',$id)->whereIn('status',[
            'بانتظار استلامها من المتبرع',
            'بانتظار مجيئك واستلامها',
            'تم التسليم'
        ])
            ->first();
    }


    public function getDeliveredDonationsForUser(int $donor_id)
    {
        return DB::table('book_donations')->where('donor_id',$donor_id,)
            ->whereIn('status',['غير محجوز في النقطة','تم التسليم',' تم الحذف من المدير',
                'محجوز في انتظار التسليم','تم الحذف من النقطة'])
            ->join('exchange_points','exchangePoint_id','=','exchange_points.id')
            ->join('accounts','account_id','=','accounts.id')
            ->join('residential_quarters','residentialQuarter_id','=','residential_quarters.id')
            ->select([
                'book_donations.id',
                'book_donations.level',
                'book_donations.semester',
                'accounts.userName as point',
                'book_donations.receiptDate',
                'book_donations.created_at',
                (DB::raw('residential_quarters.name AS residentialQuarter')),
            ])
            ->orderByDesc('book_donations.created_at')
            ->paginate();
    }

    public function getRejectedDonationsForUser(int $donor_id): LengthAwarePaginator
    {
        return DB::table('book_donations')->where('donor_id',$donor_id,)
            ->where('status','تم رفض التبرع')
            ->join('exchange_points','exchangePoint_id','=','exchange_points.id')
            ->join('accounts','account_id','=','accounts.id')
            ->join('residential_quarters','residentialQuarter_id','=','residential_quarters.id')
            ->select([
                'book_donations.id',
                'book_donations.level',
                'book_donations.semester',
                'accounts.userName as point',
                'book_donations.receiptDate',
                'book_donations.created_at',
                (DB::raw('residential_quarters.name AS residentialQuarter')),
            ])
            ->orderByDesc('book_donations.created_at')
            ->paginate();
    }



    public function attachBeneficiaryUser(BookDonation $bookDonation,int $user_id,$data)
    {
        $bookDonation->reservations()->attach($user_id,$data);
    }


    public function updateReservation($whereConditions ,$data): bool
    {
        $reservation=DB::table('reservations')->where($whereConditions);
        if($reservation){
            $reservation->update($data);
            return true;
        }
        return false;
    }

    public function update(BookDonation $bookDonation, $data): void
    {
        $bookDonation->update($data);
    }

    public function updateById(int $bookDonation_id, $data)
    {
        $bookDonation=BookDonation::find($bookDonation_id);
        if($bookDonation){
            $bookDonation->update($data);
            return true;
        }
        return false;
    }

    public function getReservations(int $user_id,array $status, $selectedData): LengthAwarePaginator
    {
        return DB::table('reservations')->where('reservations.user_id', $user_id,)
            ->whereIn('reservations.status',$status)
            ->join('book_donations','bookDonation_id','=','book_donations.id')
            ->join('exchange_points','exchangePoint_id','=','exchange_points.id')
            ->join('accounts','account_id','=','accounts.id')
            ->join('residential_quarters','residentialQuarter_id','=','residential_quarters.id')
            ->select($selectedData)
            ->orderByDesc('reservations.created_at')
            ->paginate();
    }

    public function getWaitedDonationsByPhoneNumber(string $phoneNumber,int $exchangePoint_id): Collection
    {
        return DB::table('accounts')->where('accounts.phoneNumber', $phoneNumber)
            ->join('users','account_id','=','users.account_id')
            ->join('book_donations',function ($join) use ($exchangePoint_id) {
                $join->on('users.id','=','book_donations.donor_id')
                    ->where('book_donations.exchangePoint_id',$exchangePoint_id)
                    ->where('book_donations.status','محجوز في انتظار الاستلام')
                    ->orWhere('canAcceptEvenItIsNotWaited',true);
            })
            ->select([
                'accounts.userName as donor',
                'book_donations.id',
                'book_donations.donorName',
                'level',
                'semester',
                'book_donations.created_at'

            ])
            ->get();
    }

    public function getUnWaitedDonationsByPhoneNumber(string $phoneNumber,int $exchangePoint_id): Collection
    {
        return DB::table('accounts')->where('accounts.phoneNumber', $phoneNumber)
            ->join('users','account_id','=','users.account_id')
            ->join('book_donations',function ($join) use ($exchangePoint_id) {
                $join->on('users.id','=','book_donations.donor_id')
                    ->where('book_donations.exchangePoint_id',$exchangePoint_id)
                    ->where('book_donations.status','غير محجوز وليس في النقطة');
            })
            ->select([
                'accounts.userName',
                'book_donations.id',
                'level',
                'semester',
                'book_donations.created_at'
            ])
            ->get();
    }

/*
    public function getActiveReservationsInPointByPhoneNumber(int $exchange_id,string $phoneNumber)
    {
        DB::table('accounts')->where('phoneNumber',$phoneNumber)
            ->join('users','accounts.id','=','users.account_id')
            ->join('reservations',function ($join) use ($exchange_id) {
                $join->on('users.id', '=', 'reservations.user_id')
                    ->where('reservations.exchange_id',$exchange_id)
                    ->where('reservations.status','')
            })
            ->

    }
*/
    public function getWaitedReservationsByPhoneNumber(mixed $phoneNumber, int $exchangePoint_id):Collection
    {
        return DB::table('accounts')->where('accounts.phoneNumber', $phoneNumber)
            ->join('users','accounts.id','=','users.account_id')
            ->join('reservations',function ($join) {
                $join->on('users.id','=','reservations.user_id')
                    ->where('reservations.status','بانتظار مجيئك واستلامها');
            })
            ->join('book_donations',function ($join) use ($exchangePoint_id) {
                $join->on('reservations.bookDonation_id','=','book_donations.id')
                    ->where('book_donations.exchangePoint_id',$exchangePoint_id);
            })
            ->select([
                'accounts.userName',
                DB::raw('book_donations.id as book_donations_id'),
                'reservations.id',
                'level',
                'semester',
                'reservations.created_at'
            ])
            ->get();
    }

    public function getRemovalDonation($exchangePoint_id): Collection
    {
        return DB::table('book_donations')->where([
            'exchangePoint_id'=>$exchangePoint_id,
            'isRemovable'=>true,
            'status'=>'غير محجوز في النقطة'
        ])
            ->select([
                'id',
                'level',
                'semester',
                'book_donations.created_at'
            ])
            ->get();
    }

    public function removeByExchangePoint($bookDonation)
    {
        $bookDonation->update([
            'status'=>'تم الحذف من النقطة',
            'isHide'=>true
        ]);
    }

    public function getDonationInPoint($exchangePoint_id)
    {
        return BookDonation::where('exchangePoint_id',$exchangePoint_id)
            ->whereIn('status',['غير محجوز في النقطة','محجوز في انتظار التسليم'])
            ->selesct([
                'id',
                'level',
                'semester',
                'no_rejecting',
                'created_at'
            ])
            ->get();
    }



    public function getBookDonationInPoint($exchangePoint_id): Collection
    {
        return DB::table('bookDonations')->where('exchangePoint_id',$exchangePoint_id)
            ->whereIn('status',['غير محجوز في النقطة','محجوز في انتظار التسليم'])
            ->select([
                'id',
                'level',
                'semester',
                'receiptDate'
            ])
            ->get();
    }

    public function getRemovableDonation($exchangePoint_id)
    {
        return DB::table('bookDonations')->where('exchangePoint_id',$exchangePoint_id)
            ->where('')
            ->select([
                'id',
                'level',
                'semester',
                'receiptDate'
            ])
            ->get();
    }




}


/*
  void main() {
  // Example DateTime objects
  DateTime startTime = DateTime.now();
  DateTime endTime = DateTime.now().add(Duration(hours: 1, minutes: 30));

  // Find the difference between the two DateTime objects
  Duration difference = endTime.difference(startTime);

  // Create a descending clock using the difference
  Timer.periodic(Duration(seconds: 1), (timer) {
    if (difference.inSeconds <= 0) {
      timer.cancel(); // Stop the timer when the difference becomes zero
      print('Countdown finished!');
    } else {
      difference -= Duration(seconds: 1);
      print('${difference.inHours}:${difference.inMinutes.remainder(60)}:${difference.inSeconds.remainder(60)}');
    }
  });
}
 */
