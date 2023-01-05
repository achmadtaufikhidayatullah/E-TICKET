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
            <h1>Event Payment - {{ $event->name }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('event.index.admin') }}">Event</a></div>
                <div class="breadcrumb-item active">Event Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header">
                            <h4 class="text-warning">Payment List</h4>
                            <div class="card-header-action">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table datatables">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Code</th>
                                            <th>Bank</th>
                                            <th>Account Number</th>
                                            <th>Holder</th>
                                            <th>Grand Total (IDR)</th>
                                            <th>Receipt</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bookedTickets as $bookedTicket)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $bookedTicket->code }}
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
                                                <a target="_blank" href="{{ Storage::url($bookedTicket->payment->payment_proof) }}" class="btn btn-warning">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                            </td>
                                            <td>
                                                @if($bookedTicket->payment->status == "waiting_for_payment")
                                                <div class="badge badge-warning">Waiting For Payment</div>
                                                @elseif($bookedTicket->payment->status == "validating_payment")
                                                <div class="badge badge-info">Validating Payment</div>
                                                @elseif($bookedTicket->payment->status == "payment_successful")
                                                <div class="badge badge-success">Payment Successful</div>
                                                @else
                                                <div class="badge badge-danger">Book / Payment Rejected</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($bookedTicket->payment->status == "validating_payment")
                                                <a class="btn btn-success btn-action mr-1" href="{{ route('payments.approve', $bookedTicket->payment->code) }}" title="Approve"><i class="fas fa-check"></i></a>
                                                <a class="btn btn-danger btn-action mr-1" href="{{ route('payments.reject', $bookedTicket->payment->code) }}" title="Reject"><i class="fas fa-times"></i></a>
                                                @else
                                                <a target="_blank" class="btn btn-info btn-action mr-1" href="{{ route('payments.invoice', $bookedTicket->payment->code) }}" title="Invoice"><i class="fas fa-file-invoice"></i></a>
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