<?php

namespace App\Http\Controllers\Api\Shared;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassword;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Account;
use App\Models\emailVerificationToken;
use App\Models\PasswordResetToken;
use App\Models\phoneVerificationToken;
use App\Models\updateEmailToken;
use App\RepositoryPattern\AccountRepository;
use App\RepositoryPattern\UserRepository;
use Carbon\Carbon;
use HTTP_Request2;
use HTTP_Request2_Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Validation\ValidationException;
use PDOException;
use PHPUnit\Exception;
use Random\RandomException;

class AccountController extends Controller
{
    protected AccountRepository $AccountRepository;
    protected UserRepository $UserRepository;
    function __construct(AccountRepository $AccountRepository,UserRepository $UserRepository)
    {
        $this->AccountRepository=$AccountRepository;
        $this->UserRepository=$UserRepository;
    }

    public function sendNotification()
    {


    }


    public function registerPointAccount(Request $request)
    {
        $email=$request->email;
        $password=Hash::make($request->password);
        $phoneNumber=$request->phoneNumber;
        $residentialQuarter_id=$request->residentialQuarter_id;
    }




    public function verify()
    {

    }

    public function RegisterAdmin()
    {

    }

    public function RegisterExchangePoint()
    {

    }

    //                              - Shared between Point and User -




    /**
     *
     * @throws ValidationException
     */
    public function Login(Request $request)
    {
        $emailOrPhone = $request->emailOrPhone;
        $user = Account::where(function (Builder $builder) use ($emailOrPhone) {
            $builder->where('email', $emailOrPhone)
                ->orWhere(function (\Illuminate\Database\Eloquent\Builder $query) use ($emailOrPhone) {
                    $query->where('phoneNumber', $emailOrPhone);

        })
                ->whereIn('role',['point','user']);

        })->first();
        $device_name=$request->device_name;
        if (!$user ||!Hash::check($request->password, $user->password)) {
            return response()->json(['status'=>'validationFail' , 'error'=>'كلمة المرور أو البريد الإلكتروني غير صحيحة']);
        }
        $token=$user->createToken($device_name)->plainTextToken;
        return response()->json(['status'=>'success','token'=>$token , 'user'=>[
            'phoneNumber'=>$user->phoneNumber, 'role'=>$user->role ,'userName'=>$user->userName ]]);

    }




    public function logout(): void
    {
        $account=Auth::guard('sanctum')->user();
        $account->tokens()->where('id', $account->currentAccessToken()->id)->delete();
    }


    /**
     * @throws \HTTP_Request2_Exception
     * @throws \HTTP_Request2_LogicException
     * @throws RandomException
     */
    public function sendVerificationCodeForPhone(Request $_request):JsonResponse
    {
        Gate::authorize('isPointOrUser');
        $account=auth()->user();
        $phoneNumber=$_request->phoneNumber;
        $verifyPhoneToken=str_pad(random_int(1,9999),4,'0',STR_PAD_LEFT);
        // $basic  = new \Vonage\Client\Credentials\Basic("efdbb8d6", "mDE6x1Ihl9hGykGY");
        // $client = new \Vonage\Client($basic);
        $basic  = new \Vonage\Client\Credentials\Basic("1d4d3644", "yWNzoLtm77v1UnIo");
        $client = new \Vonage\Client($basic);
        try {
            if(! $phoneVerificationToken =phoneVerificationToken::where('phoneNumber',$phoneNumber)->first()){
                phoneVerificationToken::create([
                    'phoneNumber'=>$phoneNumber,
                    'token'=>$verifyPhoneToken
                ]);
            }
            else{
                $phoneVerificationToken->update([
                    'token'=>$verifyPhoneToken
                ]);
            }
            $response = $client->sms()->send(
                new \Vonage\SMS\Message\SMS("967780261514", "Booking", 'BookBridge App, Your code for verify phone number: "'.$verifyPhoneToken.'" ')
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {
                return response()->json(['status'=>'success']);
            } else {
                return response()->json(['status'=>'fail', 'message'=>'هناك خطأ بالخادم']);
            }


        }
        catch(Exception $e) {
            return response()->json(['status'=>'fail', 'message'=>'هناك خطأ بالخادم']);

        }


    }

    public function verifyPhoneNumber(Request $request): JsonResponse
    {
        Gate::authorize('isPointOrUser');
        $account = \auth()->user();
        $token=$request->token;
        $phoneNumber=$request->phoneNumber;
        $alreadyAccountWithSamePhone=$this->AccountRepository->exist($phoneNumber);
        $verifyRequest = phoneVerificationToken::where('phoneNumber', $phoneNumber)->first();
        if (!$verifyRequest || $verifyRequest->token != $token ) {
            return response()->json(['status'=>'fail','message'=>'الرمز المدخل غير صحيح']);
        }
        $UsedForMoreOneAccount=false;
        try{
            DB::beginTransaction();
            if($alreadyAccountWithSamePhone) {
                $UsedForMoreOneAccount=$alreadyAccountWithSamePhone->exist;
                $account->update([
                    'exist'=> true
                ]);
                if ($UsedForMoreOneAccount) {
                    $no_bookingOfFirstSemester=$alreadyAccountWithSamePhone->user->no_bookingOfFirstSemester;
                    $no_bookingOfSecondSemester=$alreadyAccountWithSamePhone->user->no_bookingOfSecondSemester;
                    $this->UserRepository->updateNo_booking($account->user, $no_bookingOfFirstSemester,
                        $no_bookingOfSecondSemester);
                }
                $alreadyAccountWithSamePhone->update([
                    'exist'=>false,
                    'phoneNumber'=>null
                ]);
            }

            $account->fill([
                'phoneNumber' => $phoneNumber
            ]);
            //send Notification To User to change phoneVerified
            // update the phoneVerified field to true
            $account->save();
            $verifyRequest->delete();
            DB::commit();
            return \response()->json(['status'=>'success']);
        }
        catch (PDOException $exception){
            DB::rollBack();
            return \response()->json(['status'=>'fail','message'=>'هناك خطأ بالسرفر']);

        }


    }



    public function ResetPassword(Request $request):JsonResponse
    {
        $email=$request->email;
        $token=$request->token;
        $password=$request->password;
        $account=Account::where('email',$email)->first();

        if(!$account){
            return response()->json(['status'=>'fail','message'=>'لا يوجد حساب بهذا البريد الإلكتروني']);
        }

        $resetRequest=PasswordResetToken::where('email',$email)->first();

        if(!$resetRequest || $resetRequest->token != $token){
            return response()->json(['status'=>'fail','message'=>'الرمز المدخل غير صحيح']);
        }

        $account->fill([
            'password'=>$password
        ]);
        $account->save();

        //$account->tokens()->delete();
        // send notification to all logined user with same account to logout them
        $resetRequest->delete();
        $token=$account->createToken('laptop')->plainTextToken;

        return response()->json(['status'=>'success']);

    }

    public function ForgotPassword(Request $request): JsonResponse
    {
        $account=($query=Account::query());
        $account=Account::where($query->qualifyColumn('email'),$request->input('email'))->first();
        if(!$account){
            return response()->json(['status'=>'fail','message'=>'لا يوجد حساب بهذا البريد الإلكتروني']);
        }

        $resetPasswordToken=str_pad(random_int(1,9999),4,'0',STR_PAD_LEFT);

        if(! $userPasRest =PasswordResetToken::where('email',$account->email)->first()){
            PasswordResetToken::create([
                'email'=>$account->email,
                'token'=>$resetPasswordToken
            ]);
        }
        else{
            $userPasRest->update([
                'email'=>$account->email,
                'token'=>$resetPasswordToken
            ]);
        }
        try{
            Mail::to('asmsb2012@gmail.com')->send(new \App\Mail\CodeForEmailVerification($account->userName,$resetPasswordToken));
            return response()->json(['status'=>'success']);
        }
        catch (Exception $e) {
            return response()->json(['status'=>'fail','message'=>'هناك خطأ بالخادم']);
        }

    }

    public function UpdatePassword(UpdatePasswordRequest $request)
    {
        //TODO: Gate::authorize('isUserOrPoint');
        $account=\auth()->user();
        $newPassword=$request->newPassword;
        $account->update([
            'password'=>$newPassword
        ]);

    }


    public function changeEmailRequest(UpdateEmailRequest $request)
    {
        //TODO: Gate::authorize('isUserOrPoint');
        $account=\auth()->user();
        $newEmail=$request->newEmail;
        $token=str_pad(random_int(1,9999),4,'0',STR_PAD_LEFT);
        if(! $updateEmailToken =updateEmailToken::where('account_id',\auth()->id())->first()){
            updateEmailToken::create([
                'email'=>$newEmail,
                'token'=>$token
            ]);
        }
        else{
            $updateEmailToken->update([
                'email'=>$newEmail,
                'token'=>$token
            ]);
        }

        Mail::to('asmsb2012@gmail.com')->send(new \App\Mail\CodeForEmailVerification($account->userName,$token));


    }

    /**
     * @throws RandomException
     */
    public function sendEmailVerificationCode(): void
    {
        $account=auth()->user();

        $verifyEmailToken=str_pad(random_int(1,9999),4,'0',STR_PAD_LEFT);
        if(! $account->emailVerified){
            abort(400,'تم التحق من الايميل مسبقا');
        }

        if(! $userEmailVerification =emailVerificationToken::where('email',$account->email)->first()){
            emailVerificationToken::create([
                'email'=>$account->email,
                'token'=>$verifyEmailToken
            ]);
        }
        else{
            $userEmailVerification->update([
                'email'=>$account->email,
                'token'=>$verifyEmailToken
            ]);
        }

        Mail::to('asmsb2012@gmail.com')->send(new \App\Mail\CodeForEmailVerification($account->userName,$verifyEmailToken));


    }

    public function verifyEmail(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|digits:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $account = \auth()->user();
        $token = $request->token;
        $verifyRequest = emailVerificationToken::where('email', $account->email)->first();
        if (!$verifyRequest || $verifyRequest->token != $token ) {
            abort(400);
        }
        $account->fill([
            'emailVerified' => Carbon::now()
        ]);
        $account->save();
        return \response()->json();
    }

    public function updateEmail(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|digits:5',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $account = \auth()->user();
        $token = $request->token;
        $changeEmailRequest = updateEmailToken::where('account_id', $account->id)->first();
        if (!$changeEmailRequest || $changeEmailRequest->token != $token ) {
            abort(400);
        }
        $account->fill([
            'email'=> $changeEmailRequest->email,
            'emailVerified' => Carbon::now()
        ]);
        $account->save();
        return \response()->json();
    }




}
