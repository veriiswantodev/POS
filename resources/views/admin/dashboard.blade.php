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
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $kategori }}</h3>

                <p>Total Kategori</p>
            </div>
            <div class="icon">
                <i class="fas fa-cube"></i>
            </div>
            <a href="{{route('kategori.index')}}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$produk}}</h3>

                <p>Total Produk</p>
            </div>
            <div class="icon">
                <i class="fas fa-cubes"></i>
            </div>
            <a href="{{route('produk.index')}}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $suplier }}</h3>

                <p>Total Supplier</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
            <a href="{{route('supplier.index')}}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $member }}</h3>

                <p>total Member</p>
            </div>
            <div class="icon">
                <i class="fas fa-id-card"></i>
            </div>
            <a href="{{route('member.index')}}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Grafik Pendapatan {{ tgl_ID($tgl_awal, false) }} s/d {{ tgl_ID($tgl_akhir, false) }}</h5>

                
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- ./card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection

@push('script')
    <script src="{{ asset('AdminLTE/plugins/chart.js/Chart.min.js')}}"></script>

    <script>
        $(function (){
            // Get context with jQuery - using jQuery's .get() method.
           var salesChartCanvas = $('#salesChart').get(0).getContext('2d')
   
           var salesChartData = {
           labels: {{json_encode($data_tanggal) }},
           datasets: [
               {
               label: 'Pendapatan',
               backgroundColor: 'rgba(60,141,188,0.9)',
               borderColor: 'rgba(60,141,188,0.8)',
               pointRadius: false,
               pointColor: '#3b8bba',
               pointStrokeColor: 'rgba(60,141,188,1)',
               pointHighlightFill: '#fff',
               pointHighlightStroke: 'rgba(60,141,188,1)',
               data: {{ json_encode($data_pendapatan )}}
               },
               ]
           };

           var salesChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                // legend: {
                // display: false
                // },
                scales: {
                xAxes: [{
                    gridLines: {
                    display: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                    display: false
                    }
                }]
                }
            }

           var salesChart = new Chart(salesChartCanvas, {
                type: 'line',
                data: salesChartData,
                options: salesChartOptions
                }
            )
        });
    </script>
@endpush
