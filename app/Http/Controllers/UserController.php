<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;

class UserController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.user');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = $request->user_id;
        $role = 'user';
        User::updateOrCreate(
            ['id' => $userId],
            [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $role,
                'password' => password_hash($request->password, PASSWORD_BCRYPT),
            ]);
        return response()->json(['success'=>'User saved successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $user  = User::where($where)->first();

        return  response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::where('id', $id)->forceDelete();

        return response()->json(['success'=>'User deleted successfully.']);
    }

    /**
     * Softdelete the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function trashed($id)
    {
        User::where('id', $id)->delete();

        return response()->json(['success'=>'User deactive successfully.']);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        User::where('id', $id)->restore();

        return response()->json(['success'=>'User active successfully.']);
    }

    /**
     * json
     *
     * @return void
     */
    public function json()
    {
        return Datatables::of(User::withTrashed()->where('isAdmin', '!=', '1')->get())
            ->addColumn('action', function ($data) {
                return view('user.action_button', $data);
            })
            ->addColumn('status', function ($data) {
                return view('user.status_button', $data);
            })
            ->rawColumns(['action','status'])
            ->addIndexColumn()
            ->make(true);
    }
}
