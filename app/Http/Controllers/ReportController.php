<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookedTicket;
use App\Models\Event;
use App\Models\EventBatch;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Kupon;
use App\Models\Offline;
use App\Models\UserBankAccount;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use Session;
use App\Exports\BatchExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return view('backEnd.report.index', compact('events'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $report)
    {
      //   dd($report);
        $event = $report;
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

        return view('backEnd.report.show', compact('bookedTickets', 'soldTicket', 'earnings', 'event', 'kupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export($batch)
    {
       $bookedTickets = BookedTicket::where('event_batch_id' , $batch)->where('status', 'payment_successful')->get();
       $batch = EventBatch::Where('id' , $batch)->first();
       $name = str_replace(' ', '-', $batch->name);
      //  dd($name);

       return Excel::download(new BatchExport($bookedTickets , $batch), 'Report-'. $name .'.xlsx');
    }
}
