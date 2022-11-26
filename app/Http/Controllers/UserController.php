<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SenEmail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user->email = $request->email;
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
        //
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
        //
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
}
