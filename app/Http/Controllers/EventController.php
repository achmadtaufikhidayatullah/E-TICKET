<?php

namespace App\Http\Controllers;

use App\Models\BookedTicket;
use App\Models\Event;
use App\Models\EventBatch;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Kupon;
use App\Models\Offline;
use App\Models\UserBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Session;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agent = new Agent();
        $eventsBatch = EventBatch::where('category' , 'Ticket')->whereDate('start_date', '<=', Carbon::today()->format('Y-m-d'))
            ->whereDate('end_date', '>=', Carbon::today()->format('Y-m-d'))
            ->where('status', 'Aktif')
            ->get();

        $merchandiseBatch = EventBatch::where('category' , 'Merchandise')->whereDate('start_date', '<=', Carbon::today()->format('Y-m-d'))
            ->whereDate('end_date', '>=', Carbon::today()->format('Y-m-d'))
            ->where('status', 'Aktif')
            ->get();
        //   $eventsBatch = EventBatch::where('start_date', '>=' ,'2023-01-01')->get();

        // dd($eventsBatch->first()->quota());
        if($agent->isDesktop()) {
            return view('backEnd.event.index', compact('eventsBatch' , 'merchandiseBatch'));
        } else {
            $setting = Setting::first();
            $ownerAccounts = UserBankAccount::ownerAccounts();
            $bookedTickets = BookedTicket::where('user_id', auth()->user()->id)->latest()->get();
            return view('backEnd.event.mobile', compact('eventsBatch', 'merchandiseBatch' , 'bookedTickets', 'setting', 'ownerAccounts'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image = "";
        
        // Validasi file
        $validate = $request->validate([
            'name' => 'required',
            'image' => 'file|mimes:jpg,bmp,png,jpeg',
            'start_date' => 'required',
            'end_date' => 'required',
            'contact_persons' => 'required',
        ]);

        if($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $nameFile = str_replace(' ', '-', $request->name);
            $image = $nameFile . '.' . $extension;

            $path = Storage::putFileAs('public/event', $request->file('image'), $image);
        }

        // Upload file

        $validate = array_merge($validate, ['status' => 'Aktif'], ['image' => $image]);

        $event = Event::create($validate);

        return redirect()->route('event.index.admin')
            ->with('message', 'Berhasil menambahkan event baru.')
            ->with('status', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $soldTicket = 0;
        $eventBatch = [];
        
        foreach($event->batches as $batch) {
            $eventBatch[] = $batch->id;
        }

        $bookedTickets = BookedTicket::whereIn('event_batch_id', $eventBatch)->get();
        
        foreach($event->batches as $batch) {
            $soldTicket += $batch->quota();
        }

        $kupon = Kupon::all();

        $earnings = Payment::whereIn('booked_ticket_id', $bookedTickets->where('status', 'payment_successful')->pluck('id'))
            ->where('status', 'payment_successful')->sum('grand_total');

        return view('backEnd.event.show', compact('bookedTickets', 'soldTicket', 'earnings', 'event', 'kupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //   dd($event);
        $statuses = ['Aktif', 'Tidak Aktif'];
        return view('backEnd.event.edit', [
            'statuses' => $statuses,
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        if ($request->image != null) {
            $extension = $request->file('image')->extension();
            $nameFile = str_replace(' ', '-', $request->name);
            $image = $nameFile . '.' . $extension;

            // Validasi file
            $validate = $request->validate([
                'image' => 'required|file|mimes:jpg,bmp,png,jpeg,pdf'
            ]);

            // Hapus file yang lama (jika ada)
            if (!empty($event->image)) {
                $delete = Storage::delete('public/event/' . $event->image);
            }

            // kemudian upload file yang baru
            $path = Storage::putFileAs('public/event', $request->file('image'), $image);

            // Update image
            $event->update([
                'image' => $image,
            ]);
        }


        $validate = $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'contact_persons' => 'required',
            'status' => 'required',
        ]);
        // dd($request->all());

        $event->update($validate);

        return redirect()->route('event.index.admin')
            ->with('message', 'Berhasil mengubah data event.')
            ->with('status', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }




    //  =======  CUSTOM FUNCTION  =========

    // event List
    public function indexAdmin()
    {
        $events = Event::all();
        return view('backEnd.event.eventList', compact('events'));
    }


    // Batch Event
    public function indexBatch()
    {
        $batches = EventBatch::all();
        return view('backEnd.batch.index', compact('batches'));
    }

    public function createBatch()
    {
        $events = Event::all();
        return view('backEnd.batch.create', compact('events'));
    }

    public function storeBatch(Request $request)
    {
        // dd($request->all());
         $image = "";

        $validate = $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'image' => 'file|mimes:jpg,bmp,png,jpeg',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required',
            'max_ticket' => 'required',
        ]);

        if($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $nameFileSpecialCharacter = str_replace('+', '', $request->name);
            $nameFile = str_replace(' ', '-', $nameFileSpecialCharacter);
            $image = $nameFile . '.' . $extension;

            $path = Storage::putFileAs('public/batch', $request->file('image'), $image);
        }

        $validate = array_merge($validate, ['status' => 'Aktif'] , ['kupon_status' => $request->kupon_status] , ['kupon_aktif' => $request->kupon_aktif] , ['image' => $image], ['category' => $request->category]);

        $batch = EventBatch::create($validate);

        return redirect()->route('events.show', $batch->event->id)
            ->with('message', 'Berhasil menambahkan batch baru.')
            ->with('status', 'success');
    }

    public function editBatch(EventBatch $batch)
    {
        //   dd($batch);
        $statuses = ['Aktif', 'Tidak Aktif'];
        $events = Event::all();
        $kupon = Kupon::all();
        return view('backEnd.batch.edit', [
            'statuses' => $statuses,
            'events' => $events,
            'batch' => $batch,
            'kupon' => $kupon,
        ]);
    }

    public function updateBatch(Request $request, EventBatch $batch)
    {
        // dd($request->all());
        if ($request->image != null) {
            $extension = $request->file('image')->extension();
            $nameFileSpecialCharacter = str_replace('+', '', $request->name);
            $nameFile = str_replace(' ', '-', $nameFileSpecialCharacter);
            $image = $nameFile . '.' . $extension;

            // Validasi file
            $validate = $request->validate([
                'image' => 'required|file|mimes:jpg,bmp,png,jpeg,pdf'
            ]);

            // Hapus file yang lama (jika ada)
            if (!empty($event->image)) {
                $delete = Storage::delete('public/batch/' . $batch->image);
            }

            // kemudian upload file yang baru
            $path = Storage::putFileAs('public/batch', $request->file('image'), $image);

            // Update image
            $batch->update([
                'image' => $image,
            ]);
        }

        $validate = $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required',
            'max_ticket' => 'required',
            'status' => 'required',
        ]);
        // dd($request->all());
        $validate = array_merge($validate, ['kupon_status' => $request->kupon_status] , ['kupon_aktif' => $request->kupon_aktif] , ['category' => $request->category]);

        $batch->update($validate);

        return redirect()->route('events.show', $batch->event->id)
            ->with('message', 'Berhasil mengubah data batch.')
            ->with('status', 'success');
    }

    public function cekKupon(Request $request , EventBatch $batch)
    {
         if ($batch->kupon->tipe_kupon == 'Ticket Code') {
            // $checkKuponTersedia = BookedTicket::where(['code' => $request->kupon_code ,'event_batch_id' => $batch->kupon->event_id, 'status' => 'payment_successful'])->first();
            $checkKuponTersedia = BookedTicket::whereIn('event_batch_id', [1,$batch->kupon->event_id])->where(['code' => $request->kupon_code , 'status' => 'payment_successful'])->first();

            if (!$checkKuponTersedia) {
               return redirect()->back()->with('message', 'Oh, coupon code is not found!')->with('status', 'error');
            }

            $checkKuponDigunakan = Payment::where('kode_kupon' , $request->kupon_code)->whereNotIn('status' , ['payment_rejected' , 'booking_canceled'])->first();
            
            if($checkKuponDigunakan){
               return redirect()->back()->with('message', 'Oh, your coupon code is already used!')->with('status', 'error');
            }

            Session::put('kupon_digunakan', 1);
            Session::put('kupon_code', $request->kupon_code);
            Session::put('max_code', $checkKuponTersedia->quantity);

            return redirect()->back()->with('message', 'YEYYYY!!! your coupon is activated.')->with('status', 'success');

         }

      //   return view('backEnd.event.form', compact('batch', 'setting'));
    }

    public function removeKupon()
    {
         Session::forget('kupon_digunakan');
         Session::forget('kupon_code');
         Session::forget('max_code');   

         return redirect()->back()->with('message', 'Your coupon has been cancelled.')->with('status', 'success');

      //   return view('backEnd.event.form', compact('batch', 'setting'));
    }

    public function eventForm(EventBatch $batch)
    {
        if($batch->isFull()) {
            return redirect()->route('events.index')
                ->with('message', 'Dah penuh coy, masih aja maksa!')
                ->with('status', 'error');
        }
        
        if( ! $batch->isActive()) {
            return redirect()->route('events.index')
                ->with('message', 'Batch "' . $batch->name . '" sudah ditutup. Stay tune untuk batch selanjutnya!')
                ->with('status', 'error');
        }

        if (session()->get('kupon_digunakan') == 1) {
            $kupon_digunakan = 1;
            $kupon_code = session()->get('kupon_code');
            $max_code = session()->get('max_code');
        }else{
            $kupon_digunakan = 0;
            $kupon_code = null;
            $max_code = 999;
        }

        //   dd($batch);
        $setting = Setting::first();
        return view('backEnd.event.form', compact('batch', 'setting' , 'kupon_digunakan' , 'kupon_code' , 'max_code'));
    }

    public function purchase(Request $request, EventBatch $batch)
    {
       // Check User Rule  
        if(auth()->user()->role == 'Super Admin' || auth()->user()->role == 'Admin'){
            // dd($request->all());
            // Cek Kuota Tiket
            if($request->quantity > $batch->max_ticket) {
                  return redirect()->route('events.form', $batch->id)
                     ->with('message', 'Jumlah pesanan melebihi kuota tiket tersisa.')
                     ->with('status', 'error');
            }

            if($batch->isFull()) {
                  return redirect()->route('ticket.index')
                     ->with('message', 'Kuota telah habis.')
                     ->with('status', 'error');
            }

            do {
                  $code = Str::upper(Str::random(8));
                  $bookedTicket = BookedTicket::where('code', $code)->first();
            } while( ! empty($bookedTicket));

            $price = $batch->price;

            if (session()->get('kupon_digunakan') == 1) {
                  $kupon_digunakan = 1;
                  $kupon_code = session()->get('kupon_code');
                  $max_code = session()->get('max_code');

                  $price = $batch->price - $batch->kupon->value;
            }

            //   dd($price);

            $totalPrice = $price * $request->quantity;
            $tax = (Setting::first()->tax_percentage / 100) * $totalPrice;

            $bookedTicket = BookedTicket::create([
                  'event_batch_id' => $batch->id,
                  'code' => $code,
                  'user_id' => auth()->user()->id,
                  'price_per_ticket' => $price,
                  'quantity' => $request->quantity,
                  'tax' => $tax,
                  'sub_total' => $totalPrice,
                  'status' => 'waiting_for_payment'
            ]);

            $uniquePaymentCode = rand(1, 999);

            $payment = Payment::create([
                  'code' => $code,
                  'booked_ticket_id' => $bookedTicket->id,
                  'bank_name' => NULL,
                  'account_number' => NULL,
                  'account_holder_name' => NULL,
                  'unique_payment_code' => $uniquePaymentCode,
                  // 'grand_total' => $bookedTicket->sub_total + $bookedTicket->tax + $uniquePaymentCode,
                  'grand_total' => $bookedTicket->sub_total + $bookedTicket->tax,
                  'payment_proof' => NULL,
                  'kode_kupon' => (session()->get('kupon_digunakan') == 1) ? $request->kode_kupon : NULL,
                  'jumlah_potongan' => (session()->get('kupon_digunakan') == 1) ? $batch->kupon->value * $request->quantity : NULL,
                  'harga_setelah_potongan' => $price,
                  'status' => 'waiting_for_payment',
            ]);

            // Add to offline table
            $offline = Offline::create([
                  'code' => $code,
                  'booked_ticket_id' => $bookedTicket->id,
                  'name' => $request->name,
                  'nik' => $request->nik,
                  'email' => $request->email,
                  'phone' => $request->phone,
            ]);

               Session::forget('kupon_digunakan');
               Session::forget('kupon_code');
               Session::forget('max_code');

            $agent = new Agent();
            if($agent->isDesktop()) {
                  return redirect()->route('offline.order')
                     ->with('message', 'Berhasil melakukan pemesanan tiket. Silahkan lanjutkan ke pembayaran.')
                     ->with('status', 'success');
            }

            return redirect()->route('events.index', ['show' => 'myTicket'])
                     ->with('message', 'Berhasil melakukan pemesanan tiket. Silahkan lanjutkan ke pembayaran.')
                     ->with('status', 'success');
        }else{
            // Cek Kuota Tiket
            if($request->quantity > $batch->max_ticket) {
                  return redirect()->route('events.form', $batch->id)
                     ->with('message', 'Jumlah pesanan melebihi kuota tiket tersisa.')
                     ->with('status', 'error');
            }

            if($batch->isFull()) {
                  return redirect()->route('ticket.index')
                     ->with('message', 'Kuota telah habis.')
                     ->with('status', 'error');
            }

            do {
                  $code = Str::upper(Str::random(8));
                  $bookedTicket = BookedTicket::where('code', $code)->first();
            } while( ! empty($bookedTicket));

            $price = $batch->price;

            if (session()->get('kupon_digunakan') == 1) {
                  $kupon_digunakan = 1;
                  $kupon_code = session()->get('kupon_code');
                  $max_code = session()->get('max_code');

                  $price = $batch->price - $batch->kupon->value;
            }

            //   dd($price);

            $totalPrice = $price * $request->quantity;
            $tax = (Setting::first()->tax_percentage / 100) * $totalPrice;

            $bookedTicket = BookedTicket::create([
                  'event_batch_id' => $batch->id,
                  'code' => $code,
                  'user_id' => auth()->user()->id,
                  'price_per_ticket' => $price,
                  'quantity' => $request->quantity,
                  'tax' => $tax,
                  'sub_total' => $totalPrice,
                  'status' => 'waiting_for_payment'
            ]);

            $uniquePaymentCode = rand(1, 999);

            $payment = Payment::create([
                  'code' => $code,
                  'booked_ticket_id' => $bookedTicket->id,
                  'bank_name' => NULL,
                  'account_number' => NULL,
                  'account_holder_name' => NULL,
                  'unique_payment_code' => $uniquePaymentCode,
                  // 'grand_total' => $bookedTicket->sub_total + $bookedTicket->tax + $uniquePaymentCode,
                  'grand_total' => $bookedTicket->sub_total + $bookedTicket->tax,
                  'payment_proof' => NULL,
                  'kode_kupon' => (session()->get('kupon_digunakan') == 1) ? $request->kode_kupon : NULL,
                  'jumlah_potongan' => (session()->get('kupon_digunakan') == 1) ? $batch->kupon->value * $request->quantity : NULL,
                  'harga_setelah_potongan' => $price,
                  'status' => 'waiting_for_payment',
            ]);

               Session::forget('kupon_digunakan');
               Session::forget('kupon_code');
               Session::forget('max_code');

            $agent = new Agent();
            if($agent->isDesktop()) {
                  return redirect()->route('ticket.index')
                     ->with('message', 'Berhasil melakukan pemesanan tiket. Silahkan lanjutkan ke pembayaran.')
                     ->with('status', 'success');
            }

            return redirect()->route('events.index', ['show' => 'myTicket'])
                     ->with('message', 'Berhasil melakukan pemesanan tiket. Silahkan lanjutkan ke pembayaran.')
                     ->with('status', 'success');
        }
    }

    public function uploadPayment($code)
    {
        $bookedTicket = BookedTicket::where('code', $code)->firstOrFail();
        $setting = Setting::first();
        return view('backEnd.event.form', compact('batch', 'setting'));
    }

    public function cancel($code)
    {
        $bookedTicket = BookedTicket::where('code', $code)->firstOrFail();
        $bookedTicket->update([
            'status' => 'booking_canceled'
        ]);

        if(auth()->user()->role == "Super Admin") {
            return redirect()->route('events.payment', $bookedTicket->batch->id)
                ->with('message', 'Pemesanan tiket berhasil dibatalkan.')
                ->with('status', 'success');
        }

        if(auth()->user()->role == "Admin" || auth()->user()->role == "Affiliator") {
            $agent = new Agent();
            if($agent->isDesktop()) {
                  return redirect()->route('offline.order')
                     ->with('message', 'Berhasil membatalkan pemesanan tiket.')
                     ->with('status', 'success');
            }

            return redirect()->route('events.index', ['show' => 'myTicket'])
                     ->with('message', 'Berhasil membatalkan pemesanan tiket.')
                     ->with('status', 'success');
        }

        $agent = new Agent();
        if($agent->isDesktop()) {
            return redirect()->route('ticket.index')
                ->with('message', 'Berhasil membatalkan pemesanan tiket.')
                ->with('status', 'success');
        }

        return redirect()->route('events.index', ['show' => 'myTicket'])
                ->with('message', 'Berhasil membatalkan pemesanan tiket.')
                ->with('status', 'success');
    }

    public function ticket(EventBatch $batch)
    {
        $bookedTickets = BookedTicket::where('event_batch_id', $batch->id)->pluck('id');
        $tickets = Ticket::whereIn('booked_ticket_id', $bookedTickets)->latest()->get();

        return view('backEnd.event.ticket', compact('tickets', 'batch'));
    }

    public function payment(EventBatch $batch)
    {
        $bookedTickets = BookedTicket::where('event_batch_id', $batch->id)->orderby('updated_at' , 'DESC')->latest()->get();
        return view('backEnd.event.payment', compact('batch', 'bookedTickets'));
    }



   //  OFFLINE STORE

   public function offlineStore()
    {
        $agent = new Agent();
        $eventsBatch = EventBatch::where('category' , 'Ticket')->whereDate('start_date', '<=', Carbon::today()->format('Y-m-d'))
            ->whereDate('end_date', '>=', Carbon::today()->format('Y-m-d'))
            ->where('status', 'Aktif')
            ->get();

        $merchandiseBatch = EventBatch::where('category' , 'Merchandise')->whereDate('start_date', '<=', Carbon::today()->format('Y-m-d'))
            ->whereDate('end_date', '>=', Carbon::today()->format('Y-m-d'))
            ->where('status', 'Aktif')
            ->get();
        //   $eventsBatch = EventBatch::where('start_date', '>=' ,'2023-01-01')->get();

        // dd($eventsBatch->first()->quota());
        if($agent->isDesktop()) {
            return view('backEnd.offline.index', compact('eventsBatch' , 'merchandiseBatch'));
        } else {
            $setting = Setting::first();
            $ownerAccounts = UserBankAccount::ownerAccounts();
            $bookedTickets = BookedTicket::where('user_id', auth()->user()->id)->latest()->get();
            return view('backEnd.event.mobile', compact('eventsBatch', 'merchandiseBatch' , 'bookedTickets', 'setting', 'ownerAccounts'));
        }
    }


    public function offlineForm(EventBatch $batch)
    {
        if($batch->isFull()) {
            return redirect()->route('events.index')
                ->with('message', 'Dah penuh coy, masih aja maksa!')
                ->with('status', 'error');
        }
        
        if( ! $batch->isActive()) {
            return redirect()->route('events.index')
                ->with('message', 'Batch "' . $batch->name . '" sudah ditutup. Stay tune untuk batch selanjutnya!')
                ->with('status', 'error');
        }

        if (session()->get('kupon_digunakan') == 1) {
            $kupon_digunakan = 1;
            $kupon_code = session()->get('kupon_code');
            $max_code = session()->get('max_code');
        }else{
            $kupon_digunakan = 0;
            $kupon_code = null;
            $max_code = 999;
        }

        //   dd($batch);
        $setting = Setting::first();
        return view('backEnd.offline.form', compact('batch', 'setting' , 'kupon_digunakan' , 'kupon_code' , 'max_code'));
    }
}
