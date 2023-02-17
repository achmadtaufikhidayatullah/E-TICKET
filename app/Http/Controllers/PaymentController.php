<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Ticket;
use App\Models\UserBankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccess;
use Jenssegers\Agent\Agent;

class PaymentController extends Controller
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function upload(Request $request, $code) {
        $request->validate([
            'bank_code' => 'required|string',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_holder_name' => 'required|string',
            'payment_proof' => 'required|file|max:2048|mimes:jpg,png,jpeg',
        ]);

        // dd($request->all());
        $payment = Payment::whereCode($code)->firstOrFail();

        if($payment->bookedTicket->batch->isFull()) {
            return redirect()->route('ticket.index')
                ->with('message', 'Kuota telah habis.')
                ->with('status', 'error');
        }

        $payment->update([
            'bank_code' => $request->bank_code,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder_name' => $request->account_holder_name,
            'payment_proof' => $request->file('payment_proof')->store('public/payment_proof'),
            'status' => 'validating_payment'
        ]);

        $payment->bookedTicket->update([
            'status' => 'validating_payment'
        ]);

        if(empty(auth()->user()->userBankAccount)) {
            UserBankAccount::create([
                'user_id' => auth()->user()->id,
                'bank_code' => $request->bank_code,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_holder_name' => $request->account_holder_name,
                'status' => 'member_account'
            ]);
        } else {
            auth()->user()->userBankAccount->update([
                'bank_code' => $request->bank_code,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_holder_name' => $request->account_holder_name,
            ]);
        }

        $agent = new Agent();
        if(auth()->user()->role == 'Super Admin' || auth()->user()->role == 'Admin' || auth()->user()->role == 'Affiliator'){
            if($agent->isDesktop()) {
            return redirect()->route('offline.order')
                ->with('message', 'Berhasil melakukan pembayaran. Silahkan tunggu validasi oleh admin.')
                ->with('status', 'success');
            }

            return redirect()->route('events.index', ['show' => 'myTicket'])
                     ->with('message', 'Berhasil melakukan pembayaran. Silahkan tunggu validasi oleh admin.')
                     ->with('status', 'success');
        }else{
            if($agent->isDesktop()) {
            return redirect()->route('ticket.index')
                ->with('message', 'Berhasil melakukan pembayaran. Silahkan tunggu validasi oleh admin.')
                ->with('status', 'success');
            }

            return redirect()->route('events.index', ['show' => 'myTicket'])
                     ->with('message', 'Berhasil melakukan pembayaran. Silahkan tunggu validasi oleh admin.')
                     ->with('status', 'success');
        }
    }

    public function approve($code)
    {
        $payment = Payment::whereCode($code)->firstOrFail();

        $payment->update([
            'status' => 'payment_successful'
        ]);

        $payment->bookedTicket->update([
            'status' => 'payment_successful'
        ]);

        // Cek apakah pembayaran sudah pernah di-acc dan dicetak tiketnya
        $checkTicket = Ticket::where('booked_ticket_id', $payment->bookedTicket->id)->first();
        if( ! $checkTicket) {
            for($i = 0; $i < $payment->bookedTicket->quantity; $i++) {
                do {
                    $code = $payment->code . Str::upper(Str::random(4));
                    $ticket = Ticket::where('code', $code)->first();
                } while( ! empty($ticket));
    
                Ticket::create([
                    'code' => $code,
                    'booked_ticket_id' => $payment->bookedTicket->id,
                    'status' => 'payment_successful'
                ]);
            }
        }

        $invoiceLink = route('payments.invoice', $payment->code);

        Mail::to($payment->bookedTicket->user->email)->send(new PaymentSuccess($invoiceLink));

        return redirect()->route('events.payment', $payment->bookedTicket->batch->id)
            ->with('message', 'Pembayaran berhasil disetujui.')
            ->with('status', 'success');
    }

    public function reject($code)
    {
        $payment = Payment::whereCode($code)->firstOrFail();

        $payment->update([
            'status' => 'payment_rejected'
        ]);

        $payment->bookedTicket->update([
            'status' => 'payment_rejected'
        ]);

        return redirect()->route('events.payment', $payment->bookedTicket->batch->id)
            ->with('message', 'Pembayaran berhasil ditolak.')
            ->with('status', 'success');
    }

    public function invoice($code)
    {
        $payment = Payment::whereCode($code)->firstOrFail();
        return view('backEnd.event.invoice', compact('payment'));
    }
}
