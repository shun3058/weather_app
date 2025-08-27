@extends('layouts.app')

@section('title', '検索結果 - 天気予報比較アプリ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-geo-alt"></i> {{ $cityName }}</h2>
            <a href="{{ route('weather.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> 戻る
            </a>
        </div>

        <div class="alert alert-warning">
            <i class="bi bi-wrench"></i> {{ $message }}
        </div>

        <!-- 将来的にここに天気予報データを表示 -->
        <div class="card">
            <div class="card-header">
                <h5>天気予報データ（Phase 2で実装予定）</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <i class="bi bi-cloud"></i> OpenWeatherMap
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted">API連携後に表示</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <i class="bi bi-cloud"></i> WeatherAPI
                            </div>
                            <div class="card-body text-center">
                                <p class="text-muted">API連携後に表示</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection