<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $users = User::select('id', 'name', 'email', 'created_at')->orderByDesc('created_at');
            return DataTables::of($users)->toJson();
        }
        return view('backend.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'phone' => 'required|string|unique:users|unique:admins',
            'email' => 'required|email|unique:users|unique:admins',
            'img'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $img_profile = null;
        if($request->hasFile('img')) {
            $img = $request->file('img');
            $img_name = time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/profile'), $img_name);
            $img_profile = '/uploads/profile/' . $img_name;
        }

        $user = new User();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->img   = $img_profile;
        $user->save();

        return redirect('/admin/users')->with('success',  __('trans.alert.success.done_create'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('orders.products')->find($id);
        if(!$user){
            return back()->with('error', __('trans.alert.error.data_not_found'));
        }
        // dd($user);
        return view('backend.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('backend.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string',
            'phone' => 'required|string|unique:users,phone,' . $user->id . '|unique:admins,phone,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id . '|unique:admins,email,' . $user->id,
            'img'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $img_profile = $user->img;
        if ($request->hasFile('img')) {
            if ($user->img != null) {
                if(file_exists(public_path($user->img))){
                    unlink(public_path($user->img));
                }
            }
            $image = $request->file('img');
            $img_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile'), $img_name);
            $img_profile = '/uploads/profile/' . $img_name;
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->img   = $img_profile;
        $user->save();

        return back()->with('success',  __('trans.alert.success.done_update'));
    }


    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success',  __('trans.alert.success.done_delete'));
    }
}
