@extends('layouts.app')

@section('title', 'ホーム - 天気予報比較アプリ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-search"></i> 都市名で天気予報を検索</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('weather.search') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="city" class="form-label">都市名を入力してください</label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" placeholder="例: 東京" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> 検索
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-4">
            <div class="alert alert-info">
                <h5><i class="bi bi-info-circle"></i> 開発段階について</h5>
                <p class="mb-0">現在フェーズ1を開発中です。まずは基本的な検索機能から実装し、段階的にAPI連携と比較機能を追加していきます。</p>
            </div>
        </div>
    </div>
</div>
@endsection