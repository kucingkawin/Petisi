@extends('user.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Detail Petisi') }}</div>

                <div class="card-body">
                    @if (session('notifikasi'))
                        <div class="alert alert-{{ session('notifikasi')['status'] }}" role="alert">
                            {{ session('notifikasi')['pesan'] }}
                        </div>
                    @endif
                    
                    @if(!empty($userTandaTanganPetisi))
                        <h5><span class="badge badge-success">Sudah Ditandatangani</span></h5>
                    @endif

                    <div style="margin-bottom: 40px">
                        <p><img src='{{ Storage::url($petisi->gambar) }}' alt="Gambar Sebelumnya" style="max-width: 100%"></p>
                    </div>

                    <h1>{{ $petisi->judul }}</h1>
                    <p>{{ $petisi->konten }}</p>
                    <p>Telah ditandatangani sebanyak <strong>{{ $banyakTandaTanganPetisi->nilai }}</strong> kali.</p>

                    <a style="margin-bottom: 20px" href="{{ route('user.postTandatanganiPetisi', ['id' => $petisi->id]) }}" class="btn btn-{{ empty($userTandaTanganPetisi) ? 'success' : 'danger' }}" onclick="event.preventDefault(); document.getElementById('tandatangani-form').submit();">
                        {{ empty($userTandaTanganPetisi) ? 'Tandatangani Petisi Ini' : 'Batalkan Tanda Tangan' }}
                    </a>

                    <form id='tandatangani-form' method="POST" action="{{ route('user.postTandatanganiPetisi', ['id' => $petisi->id]) }}">
                        @csrf
                    </form>

                    <form style="margin-bottom: 20px" id='komentar-form' method="POST" action="{{ route('user.postKomentarPetisi', ['id' => $petisi->id]) }}">
                        @csrf

                        <!-- Komentar -->
                        <div class="form-group">
                            <label for="komentar" class="col-form-label text-md-right">{{ __('Komentar') }}</label>

                            <div>
                                <textarea id="komentar" name="komentar" class="form-control @error('komentar') is-invalid @enderror" rows="5">{{ old('komentar') }}</textarea>

                                @error('komentar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <a href="{{ route('user.postKomentarPetisi', ['id' => $petisi->id]) }}" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('komentar-form').submit();">
                            {{ 'Komentari Petisi Ini' }}
                        </a>
                    </form>

                    <div id="daftar-komentar">
                        @php
                            $komentar = App\Petisi::viewDikomentariTable()->where('petisi_id', '=', $petisi->id)->get();
                        @endphp
                        
                        @forelse($komentar as $satuKomentar)
                            <p><strong>{{ $satuKomentar->user_name}}</strong><br>{{ $satuKomentar->komentar }}</p>
                        @empty
                            <p>Belum ada komentar saat ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
