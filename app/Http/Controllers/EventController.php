<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $eventsBatch = EventBatch::whereDate('start_date', '<=' ,Carbon::today()->format('Y-m-d'))->whereDate('end_date', '>=' ,Carbon::today()->format('Y-m-d'))->get();
      //   $eventsBatch = EventBatch::where('start_date', '>=' ,'2023-01-01')->get();

      //   dd($eventsBatch);
        return view('backEnd.event.index' , compact('eventsBatch'));
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
         $extension = $request->file('image')->extension();
         $nameFile = str_replace(' ', '-', $request->name);
         $image = $nameFile . '.' . $extension;
         
         // Validasi file
         $validate = $request->validate([
               'image' => 'required|file|mimes:jpg,bmp,png,jpeg'
            ]);
               
         // Upload file
         $path = Storage::putFileAs('public/event', $request->file('image'), $image);

         $validate = $request->validate([
            'name' => 'required',
            'image' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'contact_persons' => 'required',
        ]);

        $validate = array_merge($validate,['status' => 'Aktif'],['image' => $image]);

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
            if(!empty($event->image)){
                $delete = Storage::delete('public/event/'.$event->image);
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
           'description' => 'required',
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
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required',
            'max_ticket' => 'required',
        ]);

        $validate = array_merge($validate,['status' => 'Aktif']);

        $event = EventBatch::create($validate);

        return redirect()->route('batch.index')
            ->with('message', 'Berhasil menambahkan event batch baru.')
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
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'price' => 'required',
            'max_ticket' => 'required',
            'status' => 'required',
         ]);
         // dd($request->all());
         
        $batch->update($validate);

        return redirect()->route('batch.index')
            ->with('message', 'Berhasil mengubah data batch.')
            ->with('status', 'success');
    }
   
   public function eventForm(EventBatch $batch)
    {
      //   dd($batch);
        return view('backEnd.event.form', compact('batch'));
    }
}
