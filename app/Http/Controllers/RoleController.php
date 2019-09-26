<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Role::paginate(10);
        return view('roles.index',compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
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
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'permissions_list' => 'required|array'

        ];
        $messages = [
            'name.required' => 'Name is required',
             'permissions_list.required' => 'permissions_list is required',
            'display_name.required' => 'display_name is required',


        ];
        $this->validate($request,$rules,$messages);
        /*$record = new Governerate;
        $record->name = $request->input('name');
        $record->save();*/
        $record = Role::create($request->all());
        $record->permissions()->attach($request->permissions_list);
        flash()->success('<p style="text-align: center;font-weight: bolder">تــم اضــافة القسم بنجــاح</p>');
        return redirect(route('role.index'));
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
        $model = Role::findOrFail($id);
        return view('roles.edit',compact('model'));
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
            'name' => 'required|unique:roles,name,'.$id,
            'display_name' => 'required',
            'permissions_list' => 'required|array'

        ];
        $message = [
            'name.required' => 'Name is required',
            'permissions_list.required' => 'permissions_list is required',
            'display_name.required' => 'display_name is required',


        ];
        $this->validate($request,$rules,$message);
        $record = Role::findOrFail($id);
        $record->update($request->all());
        $record->permissions()->sync($request->permissions_list);
        flash()->success('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >لقـــد تـــــــم التحــديــــــــث بنــجـــــــاح</p>');
      //  return redirect(route('role.index'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Role::findOrFail($id);

        $record->delete();

        flash()->error('<p class="text-center" style="font-size:20px; font-weight:900;font-family:Arial" >تـــم الحــذف </p>');
        // return redirect(route('role.index'));
        return back();

    }
}
