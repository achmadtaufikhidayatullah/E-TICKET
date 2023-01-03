@extends('backEnd.layouts.app')

@section('title', 'Edit Event')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>Edit Event</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('users.index') }}">Event List</a>
                </div>
                <div class="breadcrumb-item active">Edit Event</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <form class="col-12" action="{{ route('events.update', $event->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Event Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    id="inputName" placeholder="Nama user..." value="{{ $event->name ?? old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputNationalIdentityNumber">Event Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror"
                                    id="inputNationalIdentityNumber" placeholder="No KTP Anda...">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Kosongkan isian ini jika tidak ingin mengubah Image.
                                </small>
                                @error('no_ktp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Start Date</label>
                                <input type="date" name="start_date"
                                    class="form-control @error('email') is-invalid @enderror" id="inputEmail"
                                    placeholder="Alamat email anda..." value="{{ $event->start_date ?? old('email') }}">
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">End Date</label>
                                <input type="date" name="end_date"
                                    class="form-control @error('password') is-invalid @enderror" id="inputPassword"
                                    placeholder="Password akun anda..." value="{{ $event->end_date ?? old('password') }}">
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
                                <label for="inputPhoneNumber">Contact Persons</label>
                                <input type="number" name="contact_persons"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    id="inputPhoneNumber" placeholder="Nomor telepon user..."
                                    value="{{ $event->contact_persons ?? old('phone_number') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="13"
                                    style="height: 200px;" name="description">{{ $event->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control form-control-lg">
                                    @foreach($statuses as $status)
                                    <option @if($event->status == $status) selected @endif
                                        value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
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
