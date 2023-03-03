<table>
    <thead>
        <tr class="font-weight-bold">
            <th>NO</th>
            <th>TANGGAL</th>
            <th>NIK</th>
            <th>NAMA</th>
            <th>NO TLPN</th>
            <th>JUMLAH TIKET</th>
            <th>CODE</th>
            <th>VOUCHER</th>
            <th>POTONGAN</th>
            <th>HARGA</th>
            <th>TAX</th>
            <th>TOTAL</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
        @php
        $nomor = 1;
        @endphp
        @foreach($data as $data)
        <tr>
            <td>{{ $nomor }}</td>
            <td>{{ date('d-m-Y', strtotime($data->created_at))}}</td>
            <td data-format="0">{{ $data->user->no_ktp }}</td>
            <td>{{ $data->user->name }}</td>
            <td>{{ $data->user->phone_number }}</td>
            <td>{{ $data->quantity }}</td>
            <td>{{ $data->code }}</td>
            {{-- VOUCHER --}}
            @if ($data->payment->kode_kupon == null)
            <td> - </td>
            @else
            <td>{{ $data->payment->kode_kupon }}</td>
            @endif

            {{-- POTONGAN --}}
            @if ($data->payment->jumlah_potongan == null)
            <td> - </td>
            @else
            <td style="text-align: right;" data-format="#,##0_-">{{ $data->payment->jumlah_potongan }}</td>
            @endif

            <td style="text-align: right;" data-format="#,##0_-">{{ $data->payment->harga_setelah_potongan}}</td>
            <td style="text-align: right;" data-format="#,##0_-">{{ $data->tax}}</td>
            <td style="text-align: right;" data-format="#,##0_-">{{ $data->payment->grand_total}}</td>
            <td>{{ $data->status }}</td>
        </tr>
        @php
        $nomor++;
        @endphp
        @endforeach
    </tbody>
</table>
