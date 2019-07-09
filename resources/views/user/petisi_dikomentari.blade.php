@extends('user.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Petisi Dikomentari</div>
            
                <div class="card-body">
                    @if (session('notifikasi'))
                        <div class="alert alert-{{ session('notifikasi')['status'] }}" role="alert">
                            {{ session('notifikasi')['pesan'] }}
                        </div>
                    @endif

                    @if (count($petisiDikomentari) == 0)
                        <p>Belum ada petisi yang dikomentari. <a href="{{ route('user.lihatPetisi') }}">Mulai mencari petisi</a>.</p>
                    @endif

                    @if (count($petisiDikomentari) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Komentar</th>
                                    <th>Dibuat</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($petisiDikomentari as $satuPetisiDikomentari)
                                    <tr>
                                        <td>{{ $satuPetisiDikomentari->judul }}</td>
                                        <td>{{ strlen($satuPetisiDikomentari->komentar) > 100 ? substr($satuPetisiDikomentari->komentar, 0, 100) . '...' : $satuPetisiDikomentari->komentar}}</td>
                                        <td>{{ $satuPetisiDikomentari->created_at }}</td>
                                        <td>
                                            <a class="btn-sm btn-primary" href="{{ route('user.detailPetisi', ['id' => $satuPetisiDikomentari->petisi_id]) }}">Lihat</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
