<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Mail\ResetPassword;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator=validator()->make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:clients',
            'password'=>'required|confirmed',
            'phone'=>'required|unique:clients|digits:11',
            'birth_date'=>'required',
            'donation_last_date'=>'required',
            'city_id'=>'required|exists:cities,id',
            'blood_type_id'=>'required|exists:blood_types,id',
        ]);
        if($validator->fails()){
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $request->merge(['password'=>bcrypt($request->password)]);
        $client=Client::create($request->all());
       // $client->password=bcrypt($request->password);
        $client->api_token=str_random(60);
        $client->save();
        $client->governorates()->attach($request->governorate_id);
        $client->blood_types()->attach($request->blood_type_id);
        return responseJson(1,'تم الاضافه بنجاح',[
            'api_token'=>$client->api_token,
            'client'=>$client
        ]);
        /*
        if($client){
            $data=[
                'api_token'=>$client->api_token,
                'client'=>$client->fresh()->load('city','blood_type')
            ];
            return responseJson(1,'تم الاضافه بنجاح',$data);

        }else{
            return responseJson(0,'حدث خطأ حاول مره اخري');

        }
        */
    }

    public function login(Request $request){
        $validator=validator()->make($request->all(),[
            'password'=>'required',
            'phone'=>'required'
        ]);
        if($validator->fails()){
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        /*
        $client=Client::where(function ($query)use($request){
            $query->where('email',$request->input('email'));
        })->first();
        */
        $client=Client::where('phone',$request->phone)->first();
        if($client){
            /*
            if($client->is_active==0){
                return responseJson(0,'الحساب غير مفعل');
            }
            */
            if(Hash::check($request->password,$client->password)){
                return responseJson(1,'تم الدخول بنجاح',[
                    'api_token'=>$client->api_token,
                    'client'=>$client
                ]);
            }else{
                return responseJson(0,'بيانات الدخول غير صحيحه');

            }
        }else{
            return responseJson(0,'بيانات الدخول غير صحيحه');
        }
    }

    public function profile(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        $loginUser = $request->user();
        $loginUser->update($request->all());
        if ($request->has('password'))
        {
            $loginUser->password = bcrypt($request->password);
        }
        $loginUser->save();
        if ($request->has('governorate_id'))
        {
            $loginUser->governorates()->detach($request->governorate_id);
            $loginUser->governorates()->attach($request->governorate_id);
        }
        $data = [
            'user' => $request->user()->fresh()->load('city.governorate','blood_type')
        ];
        return responseJson(1,'تم تحديث البيانات',$data);
    }

    public function reset_password(Request $request){
        $validation = validator()->make($request->all(), [
            'phone' =>'required',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        $user=Client::where('phone',$request->phone)->first();
        if($user){
            $code=rand(1111,9999);
            //$pin_code = bcrypt($code);
            $update=$user->update(['pin_code'=>$code]);
            if($update){
                //send sms
               // smsMisr($request->phone,"your reset code is :".$code);
                //send email
                Mail::to($user->email)
                    ->bcc("almohamady1195@gmail.com")
                    ->send(new ResetPassword($user));

                return responseJson(1,'برجاء فحص هاتفك',
                    [
                        'pin_code_for_test'=>$code,
                        'mail_fails'=>Mail::failures(),
                        'email'=>$user->email,
                    ]);
            }else{
                return responseJson(0,'حدث خطأ حاول مره اخري');
            }
        }else{
            return responseJson(0,'لا يوجد اي حساب مرتبط بالهاتف');
        }

    }

    public function new_password(Request $request){
        $validation = validator()->make($request->all(), [
            'pin_code' =>'required',
            'phone' =>'required',
            'password' =>'required|confirmed',
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
         $user=Client::where('pin_code',$request->pin_code)->where('pin_code','!=',0)->where('phone',$request->phone)->first();
        if($user){
            $user->password=bcrypt($request->password);
            $user->pin_code=null;
            if($user->save()){
                return responseJson(1,'تم تغير كلمه المرور بنجاح');

            }else{
                return responseJson(0,'حدث خطأ حاول مره اخري');
            }
        }else{
            return responseJson(0,'الكود غير صالح');
        }
    }
    public function notifications_settings(Request $request)
    {
        $validator = validator()->make($request->all(),
         [
            'governorates.*' => 'exists:governorates,id',
            'blood_types.*' => 'exists:blood_types,id',
        ]);
        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }

        if ($request->has('governorates'))
        {
            $request->user()->governorates()->sync($request->governorates);
        }

        if ($request->has('blood_types'))
        {
            $request->user()->blood_types()->sync($request->blood_types);
        }

        $data = [
            'governorates' => $request->user()->governorates()->pluck('governorates.id')->toArray(),
            'blood_types' => $request->user()->blood_types()->pluck('blood_types.id')->toArray(),
        ];
        return responseJson(1,'تم  التحديث',$data);
    }


    public function register_token(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
            'platform' => 'required|in:android,ios',

        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        Token::where('token',$request->token)->delete();
        $request->user()->tokens()->create($request->all());
        return responseJson(1,'تم التسجيل بنجاح');
    }


    public function remove_token(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required',
        ]);

        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }

        Token::where('token',$request->token)->delete();

        return responseJson(1,'تم  الحذف بنجاح بنجاح');
    }


    }
