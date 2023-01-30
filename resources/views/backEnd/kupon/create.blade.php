@extends('backEnd.layouts.app')

@section('title', 'Tambah User')

@push('style')
<!-- CSS Libraries -->
@endpush

@section('main')
<script>
   
</script>
<div class="main-content">
    <section class="section">
        <div class="section-header shadow-lg">
            <h1>Tambah Coupons</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a class="text-warning" href="{{ route('coupons.index') }}">Coupons</a>
                </div>
                <div class="breadcrumb-item active">Tambah Coupons</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <form class="col-12" action="{{ route('coupons.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama Kupon</label>
                                <input type="text" name="nama_kupon" class="form-control @error('nama_kupon') is-invalid @enderror"
                                    id="nama_kupon" placeholder="Nama Kupon..." value="{{ old('nama_kupon') }}">
                                @error('nama_kupon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jumlah_kupon">Jumlah kupon</label>
                                <input type="number" class="form-control" id="jumlah_kupon"
                                    placeholder="Masukan jumlah kupon" name="jumlah_kupon" min="0">
                            </div>

                            <div class="form-group">
                                <label for="nama">Tipe Kupon</label>
                                <select class="custom-select" name="tipe_kupon" id="tipe_kupon">
                                    <option selected>Pilih tipe kupon</option>
                                    <option value="Voucher Code">Voucher Code</option>
                                    <option value="Ticket Code">Ticket Code</option>
                                </select>
                            </div>

                            <div class="form-group" id="event">
                                <label for="nama">Event</label>
                                <select class="custom-select" name="event_id">
                                    <option selected>Pilih Event</option>
                                    @foreach ($event as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="kode">
                                <label for="kode_kupon">Kode Kupon</label>
                                <input type="text" class="form-control" id="kode_kupon"
                                    placeholder="Masukan Kode Kupon" name="kode_kupon">
                            </div>

                            <div class="form-group">
                                <label for="nama">Tipe Potongan</label>
                                <select class="custom-select" name="tipe_potongan" id="tipe_potongan">
                                    <option selected>Pilih tipe potongan</option>
                                    <option value="Persentase">Persentase</option>
                                    <option value="Harga">Harga</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="kode_kupon">Jumlah potongan (tanpa % jika persentase)</label>
                                <input type="number" class="form-control" id="value"
                                    placeholder="Masukan jumlah potongan" name="value">
                            </div>

                            <div class="form-group">
                                <label for="kode_kupon">Tanggal Kadaluarsa</label>
                                <input type="date" class="form-control" id="kadaluarsa"
                                    placeholder="Tanggal Kadaluarsa" name="kadaluarsa">
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
   $('#event').hide();
   $('#kode').hide();
   $('#tipe_kupon').on('change', function(){
      if (this.value == 'Voucher Code') {
         $('#event').hide();
         $('#kode').show();
      }else if (this.value == 'Ticket Code') {
         $('#event').show();
         $('#kode').hide();
      }
   })
</script>
@endpush
