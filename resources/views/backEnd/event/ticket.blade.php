@extends('backEnd.layouts.app')

@section('title', $event->name)

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>Event Tickets - {{ $event->name }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('event.index.admin') }}">Event</a></div>
                <div class="breadcrumb-item active">Event Ticket</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h4 class="text-warning">Ticket List</h4>
                            <div class="card-header-action">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Event / Batch</th>
                                            <th>Ticket Code</th>
                                            <th>Payment Code</th>
                                            <th>Payment Approved At</th>
                                            <th>Buyer</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets as $ticket)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $ticket->bookedTicket->batch->event->name . ' / ' . $ticket->bookedTicket->batch->name }}
                                            </td>
                                            <td>
                                                {{ $ticket->code }}
                                            </td>
                                            <td>
                                                {{ $ticket->bookedTicket->payment->code }}
                                            </td>
                                            <td>
                                                {{ $ticket->bookedTicket->payment->updated_at->format('Y/m/d h:i') }}
                                            </td>
                                            <td>
                                                {{ $ticket->bookedTicket->user->name }}
                                            </td>
                                            <td>
                                                @if($ticket->status == "waiting_for_payment")
                                                <div class="badge badge-warning">Waiting For Payment</div>
                                                @elseif($ticket->status == "validating_payment")
                                                <div class="badge badge-info">Validating Payment</div>
                                                @elseif($ticket->status == "payment_successful")
                                                <div class="badge badge-success">Payment Successful</div>
                                                @else
                                                <div class="badge badge-danger">Book / Payment Rejected</div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<form id="deleteForm" action="{{ route('users.destroy', '') }}" method="POST">
    @method('DELETE')
    @csrf
</form>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('library/izitoast/dist/js/iziToast.min.js') }}"></script>

<script src="{{ asset('js/datatable.js') }}"></script>
@if(session()->has('message'))
<script>
    let data = {
        message: "{{ session()->get('message') }}",
        status: "{{ session()->get('status') }}",
        position: 'topCenter',
    }
</script>
<script src="{{ asset('js/toastr.js') }}"></script>
@endif
@endpush