<?php

namespace App\Http\Controllers;

use App\Models\BookedTicket;
use App\Models\Event;
use Illuminate\Http\Request;

class BookedTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        $bookedTickets = BookedTicket::whereIn('event_batch_id', $event->batches->pluck('id'))
            ->orderBy('updated_at' , 'DESC')
            ->get();
        return view('backEnd.bookedTicket.index', compact('event', 'bookedTickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookedTicket  $bookedTicket
     * @return \Illuminate\Http\Response
     */
    public function redeem(Request $request, $bookedTicket)
    {
        $bookedTicket = BookedTicket::where('code', $bookedTicket)->first();

        if(! in_array($request->status, ['redeemed', 'payment_successful']) 
            && ! in_array($bookedTicket->status, ['redeemed', 'payment_successful'])) {
            return redirect()->route('bookedTicket.index')
                ->with('message', 'Invalid action.')
                ->with('status', 'error');
        }

        foreach($bookedTicket->tickets as $ticket) {
            $ticket->status = $request->status;
            $ticket->save();
        }

        $bookedTicket->status = $request->status;
        $bookedTicket->save();

        return redirect()->route('bookedTicket.index', $bookedTicket->batch->event->id)
            ->with('message', 'Status tiket berhasil diubah.')
            ->with('status', 'success');
    }
}
