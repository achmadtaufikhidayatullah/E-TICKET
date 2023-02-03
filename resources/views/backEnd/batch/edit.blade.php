@extends('backEnd.layouts.app')

@section('title', 'Edit Event')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>Edit Event Batch</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('users.index') }}">Event Batch</a>
                </div>
                <div class="breadcrumb-item active">Edit Event Batch</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <form class="col-12" action="{{ route('batch.update', $batch->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Event Name</label>
                                <select name="event_id" class="form-control form-control-lg">
                                    @foreach($events as $event)
                                    <option @if($batch->event_id == $event->id) selected @endif
                                        value="{{ $event->id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputName">Batch Name</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    id="inputName" placeholder="Nama user..." value="{{ $batch->name ?? old('name') }}">
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
                                    <option value="Ticket" {{ ($batch->category == 'Ticket') ? 'selected' : '' ;}}>
                                        Ticket</option>
                                    <option value="Merchandise"
                                        {{ ($batch->category == 'Merchandise') ? 'selected' : '' ;}}>Merchandise
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputNationalIdentityNumber">Batch Image</label>
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
                                    placeholder="Alamat email anda..." value="{{ $batch->start_date ?? old('email') }}">
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
                                    placeholder="Password akun anda..."
                                    value="{{ $batch->end_date ?? old('password') }}">
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
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    id="inputPhoneNumber" placeholder="Price for this batch"
                                    value="{{ $batch->price ?? old('price') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="inputPhoneNumber">Max Ticket</label>
                                <input type="number" name="max_ticket"
                                    class="form-control @error('phone_number') is-invalid @enderror"
                                    id="inputPhoneNumber" placeholder="Maximum Ticket for this batch"
                                    value="{{ $batch->max_ticket ?? old('price') }}">
                                @error('phone_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kupon_status">Coupons Status</label>
                                <select class="custom-select" name="kupon_status" id="kupon_status">
                                    <option>Pilih Status Kupon</option>
                                    <option value="Aktif" {{ ($batch->kupon_status == 'Aktif') ? 'selected' : '' ;}}>
                                        Aktif</option>
                                    <option value="Tidak Aktif"
                                        {{ ($batch->kupon_status == 'Tidak Aktif') ? 'selected' : '' ;}}>Tidak Aktif
                                    </option>
                                </select>
                            </div>

                            <div class="form-group" id="kupon_aktif">
                                <label for="kupon_aktif">Kupon Aktif</label>
                                <select class="custom-select" name="kupon_aktif">
                                    <option {{ ($batch->kupon_aktif == null) ? 'selected' : '' ;}}>Pilih Kupon</option>
                                    <option value="All Voucher Code" {{ ($batch->kupon_aktif == 'All Voucher Code') ? 'selected' : '' ;}}>All Voucher Code</option>
                                    @foreach ($kupon as $kupon)
                                    <option value="{{ $kupon->id }}" {{ ($batch->kupon_aktif == $kupon->id) ? 'selected' : '' ;}}>{{ $kupon->nama_kupon }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="13"
                                    style="height: 200px;" name="description">{{ $batch->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control form-control-lg">
                                    @foreach($statuses as $status)
                                    <option @if($batch->status == $status) selected @endif
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
<script>
    $('#kupon_aktif').hide();
    if ($('#kupon_status option:selected').val() == 'Aktif') {
        $('#kupon_aktif').show();
    }

    $('#kupon_status').on('change', function(){
      console.log(this.value);
      if (this.value == 'Aktif') {
         $('#kupon_aktif').show();
      }else if (this.value == 'Tidak Aktif') {
         $('#kupon_aktif').hide();
      }
   })

</script>
@endpush
