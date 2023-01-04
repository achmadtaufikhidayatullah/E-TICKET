@extends('backEnd.layouts.app')

@section('title', 'Tambah Event')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>Tambah Batch Event</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('users.index') }}">Event Batch</a>
                </div>
                <div class="breadcrumb-item active">Tambah Batch Event</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <form class="col-12" action="{{ route('batch.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputRole">Event Name</label>
                                <select name="event_id" class="form-control">
                                    @foreach($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>
                                @error('event_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputName">Batch Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    id="inputName" placeholder="Nama batch" value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Start Date</label>
                                <input type="date" name="start_date"
                                    class="form-control @error('start_date') is-invalid @enderror" id="inputEmail"
                                    placeholder="Alamat email anda..." value="{{ old('start_date') }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">End Date</label>
                                <input type="date" name="end_date"
                                    class="form-control @error('end_date') is-invalid @enderror" id="inputPassword"
                                    placeholder="Password akun anda..." value="{{ old('end_date') }}">
                                <!-- <small id="passwordHelpBlock"
                                            class="form-text text-muted">
                                            Kosongkan isian ini jika tidak ingin mengubah password.
                                        </small> -->
                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPhoneNumber">Price</label>
                                <input type="number" name="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    id="inputPhoneNumber" placeholder="Price for this batch"
                                    value="{{ old('Price') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPhoneNumber">Max Ticket</label>
                                <input type="number" name="max_ticket"
                                    class="form-control @error('max_ticket') is-invalid @enderror"
                                    id="inputPhoneNumber" placeholder="Max Ticket for this Batch"
                                    value="{{ old('max_ticket') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="13"
                                    style="height: 200px;" name="description"></textarea>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-lg btn-warning">Submit</button>
                            <a href="{{ route('users.index') }}" class="btn btn-lg btn-link text-warning">Kembali</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->

<!-- Page Specific JS File -->
@endpush
