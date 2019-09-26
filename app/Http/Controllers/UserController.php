<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function changePassword()
    {
        return view('users.reset-password');
    }

    public function changePasswordSave(Request $request)
    {
        $messages = [
            'old-password' => 'required',
            'password' => 'required|confirmed',
        ];
        $rules = [
            'old-password.required' => 'كلمة السر الحالية مطلوبة',
            'password.required' => 'كلمة السر مطلوبة',
        ];
        $this->validate($request,$messages,$rules);

        $user = Auth::user();

        if (Hash::check($request->input('old-password'), $user->password)) {
            // The passwords match...
            $user->password = bcrypt($request->input('password'));
            $user->save();
            flash()->success('تم تحديث كلمة المرور');
            return view('users.reset-password');
        }else{
            flash()->error('كلمة المرور غير صحيحة');
            return view('users.reset-password');
        }

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = User::paginate(10);
        return view('users.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $model)
    {
        return view('users.create',compact('model'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'email',//required
            'password' => 'required|confirmed',
            'roles_list' => 'required',

        ];
        $messages = [
            'name.required' => 'Name is required',
            'password.required' => 'password is required',
            'roles_list.required' => 'roles_list is required',

        ];
        $this->validate($request,$rules,$messages);
        /*$record = new Governerate;
        $record->name = $request->input('name');
        $record->save();*/
      //  $request->merge(['api_token'=>str_random(60)]);
        $request->merge(['password'=>bcrypt($request->password)]);
        $record = User::create($request->except('roles_list'));
        $record->roles()->attach($request->input('roles_list'));
        flash()->success('<p style="text-align: center;font-weight: bolder">تــم اضــافة القسم بنجــاح</p>');
        return redirect(route('user.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = User::findOrFail($id);
        return view('users.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'email',//required
            'password' => 'confirmed',
            'roles_list' => 'required',

        ];
        $messages = [
            'name.required' => 'Name is required',
            'password.required' => 'password is required',
            'roles_list.required' => 'roles_list is required',

        ];
        $this->validate($request,$rules,$messages);
        /*$record = new Governerate;
        $record->name = $request->input('name');
        $record->save();*/
        //  $request->merge(['api_token'=>str_random(60)]);
        $record = User::findOrFail($id);
        $record->roles()->sync((array)$request->input('roles_list'));
        $request->merge(['password'=>bcrypt($request->password)]);
        $record->update($request->all());
        flash()->success('<p style="text-align: center;font-weight: bolder">تــم تعديل القسم بنجــاح</p>');
        // return redirect(route('user.edit',$id));
        //return  redirect('admin/user/'.$id.'/edit');
        return redirect(route('user.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = User::findOrFail($id);

        $record->delete();
        flash()->error('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        // return redirect(route('role.index'));
        return back();
    }
}
