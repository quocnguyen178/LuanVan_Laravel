@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Thống Kê
                    <small>Loại luận văn</small>
                </h1>
                @if(session('thongbao'))
                <div style="color:red;font-size: 20px;">
                    {{session('thongbao')}}
                </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                <form enctype="multipart/form-data" action="{{route('thongke.postloailvall')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row">
                        <div class="form-group">
                            <label>Tháng</label>
                            <select class="form-control" name = "thang" id="loailv">
                                <option value="">----</option>
                                @foreach($arr as $t)
                                <option value="{{ $t }}">{{$t}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Năm</label>
                            <select class="form-control" name = "nam" id="loailv">
                                @foreach($arrnam as $t)
                                <option value="{{ $t }}">{{$t}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 25px;">
                        <button type="submit" class="btn btn-info">Thống kê</button>
                        </div>
                    </div>
                </form>
                
                {{-- <form action="{{route('thongke.postloailvall')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label>Lấy tất cả</label>
                            <button type="submit" class="btn btn-default">Thống kê</button>
                        </div>
                    </div>
                <form> --}}
                @if(session('lava'))
                    <?php $a = session('lava'); ?>
                    @if(isset($a))
                        <div id="pop_div" style="width:150%; margin:0 auto;"></div>
                        <?= $a->render('ColumnChart', 'Column', 'pop_div') ?>
                    @endif
                @endif
                
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection