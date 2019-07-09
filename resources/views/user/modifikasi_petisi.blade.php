@extends('user.base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __($tipeModifikasi == 'buat' ? 'Buat Petisi' : 'Ubah Petisi') }}</div>

                <div class="card-body">
                    
                    @if($tipeModifikasi == 'ubah')
                        <div style="margin-bottom: 40px">
                            <p><img src='{{ Storage::url($petisi->gambar) }}' alt="Gambar Sebelumnya" style="max-width: 100%"></p>
                        </div>
                    @endif
                    
                    @php
                        $parameterPost = ['tipe' => $tipeModifikasi];
                        if($tipeModifikasi == 'ubah')
                            $parameterPost['id'] = $petisi->id;
                    @endphp

                    <form method="POST" action="{{ route('user.postModifikasiPetisi', $parameterPost) }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Kategori -->
                        <div class="form-group row">
                            <label for="kategori" class="col-md-4 col-form-label text-md-right">{{ __('Kategori') }}</label>

                            <div class="col-md-6">
                                <select id="kategori" name="kategori" class="form-control @error('kategori') is-invalid @enderror" autofocus>
                                    @php $kategoriPetisi = App\KategoriPetisi::all(); @endphp
                                    @foreach($kategoriPetisi as $satuKategoriPetisi)
                                        <option value="{{ $satuKategoriPetisi->id }}" {{ old('kategori', $tipeModifikasi == 'ubah' ? $petisi->kategori_petisi_id : null) == $satuKategoriPetisi->id ? 'selected' : '' }}>{{ $satuKategoriPetisi->nama }}</option>
                                    @endforeach
                                </select>

                                @error('kategori')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Judul -->
                        <div class="form-group row">
                            <label for="judul" class="col-md-4 col-form-label text-md-right">{{ __('Judul') }}</label>

                            <div class="col-md-6">
                                <input id="judul" type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul', $tipeModifikasi == 'ubah' ? $petisi->judul : '') }}" required autocomplete="judul">

                                @error('judul')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Konten -->
                        <div class="form-group row">
                            <label for="konten" class="col-md-4 col-form-label text-md-right">{{ __('Konten') }}</label>

                            <div class="col-md-6">
                                <textarea id="konten" name="konten" class="form-control @error('konten') is-invalid @enderror" rows="5">{{ old('konten', $tipeModifikasi == 'ubah' ? $petisi->konten : '') }}</textarea>

                                @error('konten')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div class="form-group row">
                            <label for="gambar" class="col-md-4 col-form-label text-md-right">{{ __('Gambar (Min: 300x300)') }}</label>

                            <div class="col-md-6">
                                <input id="gambar" name="gambar" type="file" class="form-control @error('gambar') is-invalid @enderror">

                                @error('gambar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
