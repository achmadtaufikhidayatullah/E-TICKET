<?php

namespace App\Http\Controllers;

use App\Models\BookedTicket;
use App\Models\Event;
use App\Models\EventBatch;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventsBatch = EventBatch::whereDate('start_date', '<=', Carbon::today()->format('Y-m-d'))->whereDate('end_date', '>=', Carbon::today()->format('Y-m-d'))->get();
        //   $eventsBatch = EventBatch::where('start_date', '>=' ,'2023-01-01')->get();

        // dd($eventsBatch->first()->quota());
        return view('backEnd.event.index', compact('eventsBatch'));
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

        $earnings = Payment::whereIn('booked_ticket_id', $bookedTickets->where('status', 'payment_successful')->pluck('id'))
            ->where('status', 'payment_successful')->sum('grand_total');

        return view('backEnd.event.show', compact('bookedTickets', 'soldTicket', 'earnings', 'event'));
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
        $validate = $request->validate([
            'event_id' => 'required',
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required',
            'max_ticket' => 'required',
        ]);

        $validate = array_merge($validate, ['status' => 'Aktif']);

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
        return view('backEnd.batch.edit', [
            'statuses' => $statuses,
            'events' => $events,
            'batch' => $batch,
        ]);
    }

    public function updateBatch(Request $request, EventBatch $batch)
    {
        // dd($request->all());
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

        $batch->update($validate);

        return redirect()->route('events.show', $batch->event->id)
            ->with('message', 'Berhasil mengubah data batch.')
            ->with('status', 'success');
    }

    public function eventForm(EventBatch $batch)
    {
        if($batch->isFull()) {
            return redirect()->route('events.index')
                ->with('message', 'Dah penuh coy, masih aja maksa!')
                ->with('status', 'error');
        }
        //   dd($batch);
        $setting = Setting::first();
        return view('backEnd.event.form', compact('batch', 'setting'));
    }

    public function purchase(Request $request, EventBatch $batch)
    {
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

        $totalPrice = $batch->price * $request->quantity;
        $tax = (Setting::first()->tax_percentage / 100) * $totalPrice;

        $bookedTicket = BookedTicket::create([
            'event_batch_id' => $batch->id,
            'code' => $code,
            'user_id' => auth()->user()->id,
            'price_per_ticket' => $batch->price,
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
            'status' => 'waiting_for_payment',
        ]);

        return redirect()->route('ticket.index')
            ->with('message', 'Berhasil melakukan pemesanan tiket. Silahkan lanjutkan ke pembayaran.')
            ->with('status', 'success');
    }

    public function uploadPayment($code)
    {
        $bookedTicket = BookedTicket::where('code', $code)->firstOrFail();
        $setting = Setting::first();
        return view('backEnd.event.form', compact('batch', 'setting'));
    }

    public function ticket(EventBatch $batch)
    {
        $bookedTickets = BookedTicket::where('event_batch_id', $batch->id)->pluck('id');
        $tickets = Ticket::whereIn('booked_ticket_id', $bookedTickets)->latest()->get();

        return view('backEnd.event.ticket', compact('tickets', 'batch'));
    }

    public function payment(EventBatch $batch)
    {
        $bookedTickets = BookedTicket::where('event_batch_id', $batch->id)->latest()->get();
        return view('backEnd.event.payment', compact('batch', 'bookedTickets'));
    }
}
