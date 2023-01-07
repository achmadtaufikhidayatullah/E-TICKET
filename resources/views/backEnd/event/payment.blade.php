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
            <h1>{{ $batch->event->name }} ({{ $batch->name }}) &mdash; Payments</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('event.index.admin') }}">Event</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('events.show', $batch->event->id) }}">{{ $batch->event->name }}</a></div>
                <div class="breadcrumb-item active">{{ $batch->name }}'s Tickets</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <h6>Ticket Sold</h6>
                                    <h4 class="text-dark">
                                        <span class="{{ $batch->quota() >= $batch->max_ticket ? 'text-danger' : 'text-success' }}">{{ $batch->quota() }}</span> / {{ $batch->max_ticket }}
                                    </h4>
                                </div>
                                <div class="col-2">
                                    <h6>Waiting for Payment</h6>
                                    <h4 class="text-dark">
                                        <span>{{ $bookedTickets->where('status', 'waiting_for_payment')->count() }}</span>
                                    </h4>
                                </div>
                                <div class="col-2">
                                    <h6>Needs Validation</h6>
                                    <h4 class="text-dark">
                                        <span>{{ $bookedTickets->where('status', 'validating_payment')->count() }}</span>
                                    </h4>
                                </div>
                                <div class="col-2">
                                    <h6>Approved</h6>
                                    <h4 class="text-dark">
                                        <span>{{ $bookedTickets->where('status', 'payment_successful')->count() }}</span>
                                    </h4>
                                </div>
                                <div class="col-2">
                                    <h6>Rejected</h6>
                                    <h4 class="text-dark">
                                        <span>{{ $bookedTickets->where('status', 'payment_rejected')->count() }}</span>
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
                                        id="waiting-for-payment-tab"
                                        data-toggle="tab"
                                        href="#waiting-for-payment"
                                        role="tab"
                                        aria-controls="waiting-for-payment"
                                        aria-selected="true">Waiting for Payment</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        id="validating-payment-tab"
                                        data-toggle="tab"
                                        href="#validating-payment"
                                        role="tab"
                                        aria-controls="validating-payment"
                                        aria-selected="true">Validating Payment</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        id="payment-successful-tab"
                                        data-toggle="tab"
                                        href="#payment-successful"
                                        role="tab"
                                        aria-controls="payment-successful"
                                        aria-selected="true">Payment Successful</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link"
                                        id="payment-rejected-tab"
                                        data-toggle="tab"
                                        href="#payment-rejected"
                                        role="tab"
                                        aria-controls="payment-rejected"
                                        aria-selected="true">Rejected Payment</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered"
                                id="myTab3Content">
                                <div class="tab-pane fade show active"
                                    id="waiting-for-payment"
                                    role="tabpanel"
                                    aria-labelledby="waiting-for-payment-tab">
                                    <h6 class="my-3">Waiting for Payment</h6>
                                    <div class="table-responsive">
                                        <table class="table-striped table datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>User Name</th>
                                                    <th>Bank</th>
                                                    <th>Acc. Number</th>
                                                    <th>Acc. Holder Name</th>
                                                    <th>Grand Total (IDR)</th>
                                                    <th>Ticket Qty</th>
                                                    <th>Receipt</th>
                                                    <th>Status</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bookedTickets->where('status', 'waiting_for_payment') as $bookedTicket)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $bookedTicket->code }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->bank_name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->account_number }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->account_holder_name }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($bookedTicket->payment->grand_total, 0, '', '.') }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->quantity }}
                                                    </td>
                                                    <td>
                                                        {{-- <a target="_blank" href="{{ Storage::url($bookedTicket->payment->payment_proof) }}" class="btn btn-warning">
                                                            <i class="fa fa-download"></i>
                                                        </a> --}}
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-warning">Waiting For Payment</div>
                                                    </td>
                                                    <td>
                                                        {{-- <a class="btn btn-success btn-action mr-1" href="{{ route('payments.approve', $bookedTicket->payment->code) }}" title="Approve"><i class="fas fa-check"></i></a> --}}
                                                        <a class="btn btn-danger btn-action mr-1" href="{{ route('payments.reject', $bookedTicket->payment->code) }}" title="Reject"><i class="fas fa-times"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade"
                                    id="validating-payment"
                                    role="tabpanel"
                                    aria-labelledby="validating-payment-tab">
                                    <h6 class="my-3">Validating Payment</h6>
                                    <div class="table-responsive">
                                        <table class="table-striped table datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>User Name</th>
                                                    <th>Bank</th>
                                                    <th>Acc. Number</th>
                                                    <th>Acc. Holder Name</th>
                                                    <th>Grand Total (IDR)</th>
                                                    <th>Ticket Qty</th>
                                                    <th>Receipt</th>
                                                    <th>Status</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bookedTickets->where('status', 'validating_payment') as $bookedTicket)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $bookedTicket->code }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->bank_name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->account_number }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->account_holder_name }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($bookedTicket->payment->grand_total, 0, '', '.') }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->quantity }}
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="{{ Storage::url($bookedTicket->payment->payment_proof) }}" class="btn btn-warning">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-info">Validating Payment</div>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-success btn-action mr-1" href="{{ route('payments.approve', $bookedTicket->payment->code) }}" title="Approve"><i class="fas fa-check"></i></a>
                                                        <a class="btn btn-danger btn-action mr-1" href="{{ route('payments.reject', $bookedTicket->payment->code) }}" title="Reject"><i class="fas fa-times"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade"
                                    id="payment-successful"
                                    role="tabpanel"
                                    aria-labelledby="payment-successful-tab">
                                    <h6 class="my-3">Payment Successful</h6>
                                    <div class="table-responsive">
                                        <table class="table-striped table datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>User Name</th>
                                                    <th>Bank</th>
                                                    <th>Acc. Number</th>
                                                    <th>Acc. Holder Name</th>
                                                    <th>Grand Total (IDR)</th>
                                                    <th>Ticket Qty</th>
                                                    <th>Receipt</th>
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
                                                        {{ $bookedTicket->payment->bank_name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->account_number }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->account_holder_name }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($bookedTicket->payment->grand_total, 0, '', '.') }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->quantity }}
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="{{ Storage::url($bookedTicket->payment->payment_proof) }}" class="btn btn-warning">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-success">Payment Successful</div>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" class="btn btn-info btn-action mr-1" href="{{ route('payments.invoice', $bookedTicket->payment->code) }}" title="Invoice"><i class="fas fa-file-invoice"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade"
                                    id="payment-rejected"
                                    role="tabpanel"
                                    aria-labelledby="payment-rejected-tab">
                                    <h6 class="my-3">Payment Rejected</h6>
                                    <div class="table-responsive">
                                        <table class="table-striped table datatables">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Code</th>
                                                    <th>User Name</th>
                                                    <th>Bank</th>
                                                    <th>Acc. Number</th>
                                                    <th>Acc. Holder Name</th>
                                                    <th>Grand Total (IDR)</th>
                                                    <th>Ticket Qty</th>
                                                    <th>Receipt</th>
                                                    <th>Status</th>
                                                    <th width="10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bookedTickets->where('status', 'payment_rejected') as $bookedTicket)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $bookedTicket->code }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->user->name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->bank_name }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->account_number }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->payment->account_holder_name }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($bookedTicket->payment->grand_total, 0, '', '.') }}
                                                    </td>
                                                    <td>
                                                        {{ $bookedTicket->quantity }}
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="{{ Storage::url($bookedTicket->payment->payment_proof) }}" class="btn btn-warning">
                                                            <i class="fa fa-download"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="badge badge-danger">Payment Rejected</div>
                                                    </td>
                                                    <td>
                                                        -
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