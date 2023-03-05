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
            <h1>{{ $event->name }} &mdash; All Booked Tickets</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('event.index.admin') }}">Event</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('events.show', $event->id) }}">{{ $event->name }}</a></div>
                <div class="breadcrumb-item active">{{ $event->name }} Tickets</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                    <h6>Total Ticket</h6>
                                    <h4 class="text-dark">
                                        <span></span>
                                    </h4>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                    <h6>Waiting for Redeem</h6>
                                    <h4 class="text-dark">
                                        <span></span>
                                    </h4>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                    <h6>Redeemed</h6>
                                    <h4 class="text-dark">
                                        <span></span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-fill"
                                id="myTab2"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active"
                                        id="waiting-for-redeem-tab"
                                        data-toggle="tab"
                                        href="#waiting-for-redeem"
                                        role="tab"
                                        aria-controls="waiting-for-redeem"
                                        aria-selected="true">Waiting for Redeem</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        id="redeemed-tab"
                                        data-toggle="tab"
                                        href="#redeemed"
                                        role="tab"
                                        aria-controls="redeemed"
                                        aria-selected="true">Redeemed Ticket</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered"
                                id="myTab3Content">
                                <div class="tab-pane fade show active"
                                    id="waiting-for-redeem"
                                    role="tabpanel"
                                    aria-labelledby="waiting-for-redeem-tab">
                                    <h6 class="my-3">Waiting for Redeem</h6>
                                    <div class="table-responsive">
                                        <table class="table-striped table datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Booking Code</th>
                                                    <th>Name</th>
                                                    <th>No. KTP</th>
                                                    <th>No. HP</th>
                                                    <th>Tickets</th>
                                                    <th>Status</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bookedTickets->where('status', 'payment_successful') as $bookedTicket)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $bookedTicket->code }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->no_ktp }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->phone_number }}
                                                    </td>
                                                    <td>
                                                        <strong>{{ $bookedTicket->tickets->count() }} ticket(s)</strong>
                                                        <br>
                                                        <ul>
                                                        @foreach($bookedTicket->tickets as $ticket)
                                                            <li>{{ $ticket->code }}</li>
                                                        @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-warning">Not redeemed</div>
                                                    </td>
                                                    <td>
                                                        <a onclick="return confirm('Are you sure want to redeem this ticket: {{ $bookedTicket->code }} ?')" class="btn btn-success btn-action mr-1" href="{{ route('bookedTicket.redeem', ['bookedTicket' => $bookedTicket->code, 'status' => 'redeemed']) }}" title="Redeem Now"><i class="fas fa-check"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade"
                                    id="redeemed"
                                    role="tabpanel"
                                    aria-labelledby="redeemed-tab">
                                    <h6 class="my-3">Redeemed Ticket</h6>
                                    <div class="table-responsive">
                                    <table class="table-striped table datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Booking Code</th>
                                                    <th>Name</th>
                                                    <th>No. KTP</th>
                                                    <th>No. HP</th>
                                                    <th>Tickets</th>
                                                    <th>Status</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bookedTickets->where('status', 'redeemed') as $bookedTicket)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $bookedTicket->code }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->no_ktp }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->phone_number }}
                                                    </td>
                                                    <td>
                                                        <strong>{{ $bookedTicket->tickets->count() }} ticket(s)</strong>
                                                        <br>
                                                        <ul>
                                                        @foreach($bookedTicket->tickets as $ticket)
                                                            <li>{{ $ticket->code }}</li>
                                                        @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-success">Redeemed</div>
                                                    </td>
                                                    <td>
                                                        <a onclick="return confirm('Are you sure want to cancel this ticket redeem: {{ $bookedTicket->code }} ?')" class="btn btn-danger btn-action mr-1" href="{{ route('bookedTicket.redeem', ['bookedTicket' => $bookedTicket->code, 'status' => 'payment_successful']) }}" title="Cancel Redeem"><i class="fas fa-times"></i></a>
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
            </div>
        </div>
    </section>
</div>
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