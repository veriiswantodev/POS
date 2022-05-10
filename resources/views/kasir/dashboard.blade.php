@extends('template.master')

@section('title')
Dashboard
@endsection

@section('breadcumb')
@parent
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body text-center">
          <h1>SELAMAT DATANG</h1>
          <h2>Anda Login Sebagai KASIR</h2>
          <br><br>
          <a href="{{ route('transaksi.baru') }}" class="btn btn-success btn-lg btn-flat">Transaksi Baru</a>
        </div>
      </div>
    </div>
</div>
@endsection
