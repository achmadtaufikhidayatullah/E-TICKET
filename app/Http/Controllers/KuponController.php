<?php

namespace App\Http\Controllers;

use App\Models\Kupon;
use App\Models\EventBatch;
use Illuminate\Http\Request;

class KuponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kupon = Kupon::orderBy('id' , 'DESC')->get();

        return view('backEnd.kupon.index', compact('kupon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $event = EventBatch::all();

      //   dd($event);
        return view('backEnd.kupon.create' , compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //   dd($request->all());
        if ($request->tipe_kupon == 'Voucher Code') {
            $kupon = new Kupon;
            $kupon->nama_kupon = $request->nama_kupon;
            $kupon->jumlah_kupon = $request->jumlah_kupon;
            $kupon->tipe_kupon = $request->tipe_kupon;
            $kupon->kode_kupon = $request->kode_kupon;
            $kupon->tipe_potongan = $request->tipe_potongan;
            $kupon->value = $request->value;
            $kupon->kadaluarsa = $request->kadaluarsa;
            $kupon->save();
        }else if($request->tipe_kupon == 'Ticket Code'){
            $kupon = new Kupon;
            $kupon->nama_kupon = $request->nama_kupon;
            $kupon->jumlah_kupon = $request->jumlah_kupon;
            $kupon->tipe_kupon = $request->tipe_kupon;
            $kupon->event_id = $request->event_id;
            $kupon->tipe_potongan = $request->tipe_potongan;
            $kupon->value = $request->value;
            $kupon->kadaluarsa = $request->kadaluarsa;
            $kupon->save();
        }else{
          return redirect()->back()->with('message', 'Jangan lupa memilih tipe kupon.')->with('status', 'error');
        }

        return redirect()->route('coupons.index')
            ->with('message', 'Berhasil menambahkan kupon baru.')
            ->with('status', 'success');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kupon  $kupon
     * @return \Illuminate\Http\Response
     */
    public function show(Kupon $kupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kupon  $kupon
     * @return \Illuminate\Http\Response
     */
    public function edit($kupon)
    {
       $kupon = Kupon::where('id' , $kupon)->first();
       $event = EventBatch::all();
       return view('backEnd.kupon.edit', compact('kupon', 'event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kupon  $kupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kupon)
    {
        $kupon = Kupon::where('id' , $kupon)->first();

        if ($request->tipe_kupon == 'Voucher Code') {
            $kupon->nama_kupon = $request->nama_kupon;
            $kupon->jumlah_kupon = $request->jumlah_kupon;
            $kupon->tipe_kupon = $request->tipe_kupon;
            $kupon->kode_kupon = $request->kode_kupon;
            $kupon->tipe_potongan = $request->tipe_potongan;
            $kupon->value = $request->value;
            $kupon->kadaluarsa = $request->kadaluarsa;
            $kupon->save();
        }else if($request->tipe_kupon == 'Ticket Code'){
            $kupon->nama_kupon = $request->nama_kupon;
            $kupon->jumlah_kupon = $request->jumlah_kupon;
            $kupon->tipe_kupon = $request->tipe_kupon;
            $kupon->event_id = $request->event_id;
            $kupon->tipe_potongan = $request->tipe_potongan;
            $kupon->value = $request->value;
            $kupon->kadaluarsa = $request->kadaluarsa;
            $kupon->save();
        }else{
          return redirect()->back()->with('message', 'Jangan lupa memilih tipe kupon.')->with('status', 'error');
        }

        return redirect()->route('coupons.index')
            ->with('message', 'Berhasil mangubah data kupon.')
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kupon  $kupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kupon $kupon)
    {
        //
    }
}
