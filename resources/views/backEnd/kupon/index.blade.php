@extends('backEnd.layouts.app')

@section('title', 'Coupons')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('library/izitoast/dist/css/iziToast.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header shadow-lg">
                <h1>Coupons</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active">Coupons</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <h4 class="text-warning">Daftar Coupons</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('coupons.create') }}"
                                        class="btn btn-warning btn-lg">
                                        Tambah Data
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table datatables">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="5%">#</th>
                                                <th>Nama</th>
                                                <th>Jumlah Kupon</th>
                                                <th>Tipe Kupon</th>
                                                <th>Event</th>
                                                <th>Kode Kupon</th>
                                                <th>Tipe Potongan</th>
                                                <th>Value</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($kupon as $kupon)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $kupon->nama_kupon }}
                                                </td>
                                                <td>
                                                    {{ $kupon->jumlah_kupon }}
                                                <td>
                                                    {{ $kupon->tipe_kupon }}
                                                </td>

                                                @if ($kupon->tipe_kupon == 'Ticket Code')
                                                <td>
                                                    {{ $kupon->eventBatch->name }}
                                                </td>
                                                <td>
                                                    -
                                                </td>
                                                @else
                                                <td>
                                                    -
                                                </td>
                                                <td>
                                                    {{ $kupon->kode_kupon }}
                                                </td> 
                                                @endif
                                                <td>
                                                    {{ $kupon->tipe_potongan }}
                                                </td>
                                                <td>
                                                    {{ $kupon->value }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning btn-action mr-1"
                                                        href="{{ route('coupons.edit', $kupon->id) }}"
                                                        title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    <!-- <a class="btn btn-danger btn-action btn-delete"
                                                        data-toggle="tooltip"
                                                        title="Delete"
                                                        data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                        data-confirm-yes="deleteItem('{{ route('users.destroy', $kupon->id) }}')"><i class="fas fa-trash"></i></a> -->
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
