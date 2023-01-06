<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SenEmail;
use App\Mail\resetPassword;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('backEnd.users.index', ['users' => $users]);
    }


    public function verificationSuccess()
    {
        $name = session()->get('name');
        return view('frontEnd.verifSuccess' , compact('name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = ['Super Admin', 'Member'];
        return view('backEnd.users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->no_ktp = $request->no_ktp;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = "Aktif";
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')
            ->with('message', 'Berhasil menambahkan user baru.')
            ->with('status', 'success');
    }
    

    public function registrationStore(Request $request)
    {
      //   dd($request->all());

         $validator = Validator::make($request->all(), [
               'email' => 'required|unique:users',
         ]);

         if ($validator->fails()) {
               return redirect()->back()->with('toast_error', 'Email has been registered!');
         }


        if ($request->password != $request->confirm_password) {
            return redirect()->back()->with('toast_error', 'Confirmation Email does not match with entered email!')->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->no_ktp = $request->no_ktp;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->role = "Member";
        $user->password = bcrypt($request->password);
        $user->status = 'Tidak Aktif';
        $user->save();

        $UserId = $user->id;

        Mail::to($request->email)->send(new SenEmail($UserId));

        return view('frontEnd.registSuccess');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = ['Super Admin', 'Member'];
        $statuses = ['Aktif', 'Tidak Aktif'];
        return view('backEnd.users.edit', [
            'roles' => $roles, 
            'statuses' => $statuses, 
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->no_ktp = $request->no_ktp;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = $request->status;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('users.index')
            ->with('message', 'Berhasil mengubah data user.')
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function email()
    {
        $UserId = 1;
        Mail::to('achmadtaufikhidayatullah6@gmail.com')->send(new SenEmail($UserId));
        return 'Berhasil';
    }

    public function verification($id)
    {
        $user = User::where('id' , $id)->first();

        $user->update([
            'status' => 'Aktif',
        ]);

        $name = $user->name;

        return redirect()->route('regist.verification.success')->with(compact('name'));
    }

    public function emailForm()
    {
        return view('frontEnd.emailForm');
    }

    public function sendResetPasswordMail(Request $request)
    {
         $user = User::where('email' , $request->email)->first();

         if ($user == null) {
            return redirect()->back()->with('toast_error', 'Your email has not been registered!');
         }

         $email = $request->email;

         Mail::to($email)->send(new resetPassword($email));

         // dd($user);

        return view('frontEnd.resetRequest');
    }

    public function resetForm($email)
    {
         // $user = User::where('email' , $email)->first();

         // dd($email);

        return view('frontEnd.resetForm', compact('email'));
    }

    public function resetPassword(Request $request)
    {
         // $user = User::where('email' , $email)->first();

         dd($request->all());

        return view('frontEnd.resetForm', compact('email'));
    }
}
