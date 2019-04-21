<?php

namespace App\Http\Controllers\Api;

use App\BloodType;
use App\Category;
use App\City;
use App\DonationRequest;
use App\Governorate;
use App\Post;
use App\Setting;
use App\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{

    public function posts(Request $request)
    {
      //  $posts=Post::with('Category')->paginate(10);
        $posts = Post::with('category')->where(function($post) use($request){
            if ($request->input('category_id'))
            {
                $post->where('category_id',$request->category_id);
            }

            if ($request->input('keyword'))
            {
                $post->where(function($post) use($request){
                    $post->where('title','like','%'.$request->keyword.'%');
                    $post->orWhere('content','like','%'.$request->keyword.'%');
                });
            }

        })->latest()->paginate(10);
        return responseJson(1, 'success', $posts);
    }
    public function post(Request $request)
    {
        $post = Post::with('category')->find($request->post_id);
        if (!$post) {
            return responseJson(0, '404 no post found');
        }
        return responseJson(1, 'success', $post);
    }
    public function blood_types()
    {
        $bloodTypes = BloodType::all();
        return responseJson(1, 'success', $bloodTypes);
    }

    public function categories()
    {
        $categories = Category::all();
        return responseJson(1, 'success', $categories);
    }

    public function  governorates(){

        $governrates=Governorate::all();
        return responseJson(1,"success",$governrates);
    }

    public function  cities(Request $request){

        $cities=City::where(function ($query) use($request){
            if($request->has('governorate_id'))
            {
                $query->where('governorate_id',$request->governorate_id);
            }
        })->get();
        return responseJson(1,"success",$cities);
    }
    public function donations_requests(Request $request)
    {
        $donations = DonationRequest::where(function ($query) use ($request) {
            if ($request->input('governorate_id')) {
                $query->whereHas('city', function ($query) use($request){
                    $query->where('governorate_id',$request->governorate_id);
                });
            }elseif ($request->input('city_id')) {
                $query->where('city_id', $request->city_id);
            }
            if ($request->input('blood_type_id')) {
                $query->where('blood_type_id', $request->blood_type_id);
            }
        })->with('city', 'client','blood_type')->latest()->paginate(10);
        return responseJson(1, 'success', $donations);
    }

    public function donation_request(Request $request)
    {
        $donation = DonationRequest::with('city', 'client','blood_type')->find($request->donation_requests_id);
        if (!$donation) {
            return responseJson(0, '404 no donation found');
        }
        return responseJson(1, 'success', $donation);
    }
    public function donation_request_create(Request $request)
    {
        // validation
        $validator = validator()->make($request->all(),
         [
            'patient_name' => 'required',
            'patient_age' => 'required:digits',
            'blood_type_id' => 'required|exists:blood_types,id',
            'bags_number' => 'required:digits',
            'hospital_address' => 'required',
             'hospital_name' => 'required',
             'city_id' => 'required|exists:cities,id',
            'phone' => 'required|digits:11',
             'notes' => 'required',

         ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        // create donation request
        $donationRequest = $request->user()->requests()->create($request->all())->load('city.governorate','blood_type');

        // dd($donationRequest);
        // find clients suitable for this donation request
        $clientsIds = $donationRequest->city->governorate->clients()
            ->whereHas('blood_types', function ($q) use ($request,$donationRequest) {
                $q->where('blood_types.id', $donationRequest->blood_type_id);
            })->pluck('clients.id')->toArray();
       // dd($clientsIds);
        $send = "";
        if (count($clientsIds)) {
            // create a notification on database
            $notification = $donationRequest->notifications()->create([
                'title' => 'يوجد حالة تبرع قريبة منك',
                'content' =>$donationRequest->blood_type->name . 'محتاج متبرع لفصيلة ',
            ]);
            // attach clients to this notofication
            $notification->clients()->attach($clientsIds);

            $tokens = Token::whereIn('client_id',$clientsIds)->where('token','!=',null)->pluck('token')->toArray();
            // dd($tokens);
            if (count($tokens))
            {
                //public_path();
                $title = $notification->title;
                $body = $notification->content;
                $data = [
                    'donation_request_id' => $donationRequest->id
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
                info("firebase result: " . $send);
//                info("data: " . json_encode($data));
            }

        }

        return responseJson(1, 'تم الاضافة بنجاح', compact('donationRequest'));

    }
    public function notifications(Request $request)
    {
        $items = $request->user()->notifications()->latest()->paginate(20);
        return responseJson(1, 'success', $items);
    }
    public function post_favourite(Request $request)
    {
        $validator = validator()->make($request->all(),
         [
            'post_id' => 'required|exists:posts,id',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        $toggle = $request->user()->posts()->toggle($request->post_id);// attach() detach() sync() toggle()
        // [1,2,4] - sync(2,5,7) -> [1,2,4,5,7]

        return responseJson(1, 'Success', $toggle);
    }

    public function my_favourites(Request $request)
    {
        $posts = $request->user()->posts()->latest()->paginate(20);// oldest()
        return responseJson(1, 'success', $posts);
    }

    public function contact(Request $request)
    {
        $validator = validator()->make($request->all(),
        [
            'title' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $contact = $request->user()->contacts()->create($request->all());
        return responseJson(1, 'تم الارسال', $contact);
    }

    public function report(Request $request)
    {
        $validator = validator()->make($request->all(),
        [
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }

        $report = $request->user()->reports()->create($request->all());
        return responseJson(1, 'تم الارسال', $report);
    }

    /*public function settings()
    {
        return responseJson(1, 'success', settings());
    }*/
    public function settings()
    {
        $data=Setting::firstOrNew();
        return responseJson(1, 'success', $data);
    }



}
