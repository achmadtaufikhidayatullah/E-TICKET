@extends('backEnd.layouts.app')

@section('title', $event->name)

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <div class="row">
                <div class="col-lg-1 col-sm-12">
                    @if($event->image == NULL)
                    <img class="img-fluid" src="{{ asset('FrontAssets/img/BG.jpg') }}">
                    @else
                    <img src="{{ asset('storage/event/' . $event->image) }}" style="width:100%;">
                    @endif
                </div>
                <div class="col-lg-11 col-sm-12">
                    <h1>{{ $event->name }}</h1>
                    <h6 class="mt-1"><em>{{ $event->description ?? "No Description Available" }}</em></h6>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 shadow-lg">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Batch</h4>
                        </div>
                        <div class="card-body">
                            {{ $event->batches->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 shadow-lg">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-ticket"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Ticket Sold (All Batch)</h4>
                        </div>
                        <div class="card-body">
                            {{ $soldTicket }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1 shadow-lg">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-rupiah-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Earnings (All Batch)</h4>
                        </div>
                        <div class="card-body">
                            {{ number_format($earnings, 0, '', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow-lg">
                    <div class="card-header">
                        <h4 class="text-warning">Event Batches</h4>
                        <div class="card-header-action">
                            <button data-id="{{ $event->id }}" data-toggle="modal" data-target="#addNewBatch"
                                class="btn btn-warning btn-lg">
                                <i class="fa fa-plus mr-1"></i> Add New Batch
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-striped table datatables">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th class="text-center" width="5%">Image</th>
                                        <th width="15%">Batch Name</th>
                                        <th class="text-center" width="10%">Start Date</th>
                                        <th class="text-center" width="10%">End Date</th>
                                        <th class="text-right" width="10%">Price (Rp.)</th>
                                        <th class="text-center" width="15%">Ticket Sold / Max</th>
                                        <th class="text-center" width="10%">Status</th>
                                        <th width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->batches as $batch)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <a href="{{ asset('storage/batch/' . $batch->image) }}">
                                                <img src="{{ asset('storage/batch/' . $batch->image) }}" width="50px">
                                            </a>
                                        </td>
                                        <td>
                                            {{ $batch->name }}
                                        </td>
                                        <td class="text-center">
                                            {{ date('d/m/Y', strtotime($batch->start_date)) }}
                                        </td>
                                        <td class="text-center">
                                            {{ date('d/m/Y', strtotime($batch->end_date)) }}
                                        </td>
                                        <td class="text-right">
                                            {{ number_format($batch->price, 0, '', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="{{ $batch->quota() >= $batch->max_ticket ? 'text-danger' : 'text-success' }}">{{ $batch->quota() }}</span>
                                            / {{ $batch->max_ticket }}
                                        </td>
                                        <td class="text-center">
                                            <div class="badge badge-success">{{ $batch->status }}</div>
                                        </td>
                                        <td>
                                            <a class="btn btn-success btn-action mr-1"
                                                href="{{ route('report.export', $batch->id) }}" title="export"><i
                                                    class="fas fa-file-excel"></i></a>
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
    </section>
</div>

<form action="{{ route('batch.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="event_id" value="{{ $event->id }}">
    <div class="modal fade" tabindex="-1" role="dialog" id="addNewBatch">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Batch</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputName">Batch Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="inputName" placeholder="Batch name..." value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category">Batch Category</label>
                        <select class="custom-select" name="category" id="category">
                            <option>Pilih Kategori Batch</option>
                            <option value="Ticket">
                                Ticket</option>
                            <option value="Merchandise">
                                Merchandise
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputNationalIdentityNumber">Batch Image</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                            id="inputNationalIdentityNumber" value="{{ old('image') }}">
                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputEmail">Start Date</label>
                                <input type="date" name="start_date"
                                    class="form-control @error('start_date') is-invalid @enderror" id="inputEmail"
                                    placeholder="Alamat email anda..."
                                    value="{{ old('start_date') ?? today()->format('Y-m-d') }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputPassword">End Date</label>
                                <input type="date" name="end_date"
                                    class="form-control @error('end_date') is-invalid @enderror" id="inputPassword"
                                    placeholder="Password akun anda..."
                                    value="{{ old('end_date') ?? today()->format('Y-m-d') }}">
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPhoneNumber">Price</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                id="inputPhoneNumber" placeholder="ex: 100000" value="{{ old('Price') }}">
                        </div>
                        @error('phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputPhoneNumber">Max Ticket</label>
                        <input type="number" name="max_ticket"
                            class="form-control @error('max_ticket') is-invalid @enderror" id="inputPhoneNumber"
                            placeholder="ex: 500" value="{{ old('max_ticket') }}">
                        @error('phone_number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kupon_status">Coupons Status</label>
                        <select class="custom-select" name="kupon_status" id="kupon_status">
                            <option selected>Pilih Status Kupon</option>
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="form-group" id="kupon_aktif">
                        <label for="kupon_aktif">Kupon Aktif</label>
                        <select class="custom-select" name="kupon_aktif">
                            <option selected>Pilih Kupon</option>
                            <option value="All Voucher Code">All Voucher Code</option>
                            @foreach ($kupon as $kupon)
                            <option value="{{ $kupon->id }}">{{ $kupon->nama_kupon }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" style="height: 100%"
                            name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-link text-warning" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<!-- JS Libraies -->

<script>
    $('#kupon_aktif').hide();
    $('#kupon_status').on('change', function () {
        console.log(this.value);
        if (this.value == 'Aktif') {
            $('#kupon_aktif').show();
        } else if (this.value == 'Tidak Aktif') {
            $('#kupon_aktif').hide();
        }
    })

</script>
@endpush
