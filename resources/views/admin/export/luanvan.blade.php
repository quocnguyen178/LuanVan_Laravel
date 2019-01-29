@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Download file
                    <small>Luận Văn</small>
                </h1>
                @if(session('thongbao'))
                <div class="alert alert-success col-sm-3">
                    {{session('thongbao')}}
                </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if(count($errors) >0)
                    <div class="alert alert-danger">
                        Thông tin bạn nhập không đúng, bạn cần chỉnh sửa như sau:
                        <ul>
                        @foreach($errors->all() as $err)
                            <li>{{$err}}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <form enctype="multipart/form-data" action="{{route('luanvan.postexportluanvanexcel')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row">
                        <div class="form-group">
                            <label>Tháng</label>
                            <select class="form-control" name = "thang" id="loailv">
                                <option value="">----</option>
                                @for($i = 1 ; $i <= 12; $i++)
                                <option value="{{ $i }}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Năm</label>
                            <select class="form-control" name = "nam" id="loailv">
                                @for($i = 2015 ; $i <= date('Y'); $i++)
                                <option
                                 value="{{ $i }}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group" style="margin-top: 25px;">
                        <button type="submit" class="btn btn-info">Download</button>
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
                {{-- <div class="row">
                    <div class="form-group col-sm-4">
                        <label>Lấy tất cả</label>
                        <a href="{{route('thongke.postloailvall')}}"><button type="button" class="btn btn-default">Thống kê</button></a>
                    </div>
                </div> --}}
                
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection