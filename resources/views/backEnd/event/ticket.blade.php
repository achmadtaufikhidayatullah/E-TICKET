@extends('backEnd.layouts.app')

@section('title', $batch->event->name)

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>{{ $batch->event->name }} ({{ $batch->name }}) &mdash; Ticket</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('event.index.admin') }}">Event</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('events.show', $batch->event->id) }}">{{ $batch->event->name }}</a></div>
                <div class="breadcrumb-item active">{{ $batch->name }}'s Ticket</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
            <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <h6>Ticket Sold</h6>
                                    <h4 class="text-dark">
                                        <span class="{{ $batch->quota() >= $batch->max_ticket ? 'text-danger' : 'text-success' }}">{{ $batch->quota() }}</span> / {{ $batch->max_ticket }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ticket Code</th>
                                            <th>Payment Code</th>
                                            <th>Payment Approved At</th>
                                            <th>Buyer</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tickets as $ticket)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
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
                                                @elseif($ticket->status == "cancelled")
                                                <div class="badge badge-danger">Ticket Cancelled</div>
                                                @else
                                                <div class="badge badge-danger">Book / Payment Rejected</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ticket->status != "cancelled")
                                                <a class="btn btn-danger btn-action btn-delete"
                                                        data-toggle="tooltip"
                                                        title="Cancel"
                                                        data-confirm="Cancel Ticket Code: {{ $ticket->code }} ?| Do you want to continue?"
                                                        data-confirm-yes="deleteItem('{{ route('ticket.destroy', $ticket->id) }}')"><i class="fas fa-trash"></i></a>
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