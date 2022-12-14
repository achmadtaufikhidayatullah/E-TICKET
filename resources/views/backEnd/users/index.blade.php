@extends('backEnd.layouts.app')

@section('title', 'User')

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
                <h1>User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a class="text-warning" href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item active">User</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-lg">
                            <div class="card-header">
                                <h4 class="text-warning">Daftar User</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('users.create') }}"
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
                                                <th width="65%">Nama</th>
                                                <th width="10%">Role</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ $user->name }}
                                                </td>
                                                <td>
                                                    <div class="badge badge-warning">{{ $user->role }}</div>
                                                </td>
                                                <td>
                                                    <div class="badge badge-success">{{ $user->status }}</div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning btn-action mr-1"
                                                        href="{{ route('users.edit', $user->id) }}"
                                                        title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    <!-- <a class="btn btn-danger btn-action btn-delete"
                                                        data-toggle="tooltip"
                                                        title="Delete"
                                                        data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                        data-confirm-yes="deleteItem('{{ route('users.destroy', $user->id) }}')"><i class="fas fa-trash"></i></a> -->
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
