@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Điểm
                    <small>Sửa</small>
                </h1>
                @if(session('thongbao'))
                <div class="alert alert-success">
                    {{session('thongbao')}}
                </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                @if(!$errors-> has('matkhaucu') || !$errors-> has('matkhaumoi') || !$errors-> has('nhaplaimatkhau'))
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
                @endif
                <form action="{{route('sv_bv_lv.postsua', [$diem-> masv,$diem -> malv])}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>Sinh viên</label>
                        <select class="form-control" name = "masv" id="masv">
                            @foreach($sinhvien as $sv)
                            <option 
                            @if($sv-> masv == $diem-> masv)
                                {{"selected"}}
                            @endif
                            value="{{ $sv -> masv }}">{{$sv-> masv}} - {{$sv-> hotensv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Luận văn</label>
                        <select class="form-control" name = "malv" id="malv">
                            @foreach($luanvan as $lv)
                            <option 
                            @if($lv-> malv == $diem-> malv)
                                {{"selected"}}
                            @endif
                            value="{{ $lv -> malv }}">{{ $lv -> malv }} - {{$lv-> tenlv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Giảng viên hướng dẫn</label>
                        <p id="huongdan"></p>
                    </div>
                    <div class="form-group">
                        <label>Điểm</label>
                        <input class="form-control" name="diem" value="{{$diem-> diem}}" placeholder="Nhập điểm" />
                    </div>
                    <button type="submit" class="btn btn-info" onclick="return confirm_tb()">Sửa</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
@section('xacnhan')
    <script>
        function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
    </script>
@endsection
@section('ajax')
    <script>
        $(document).ready(function() {
            $("#masv").ready(function(){
                var masv = $('#masv').val();
                var malv = $('#malv').val();
                $.get("admin/ajax/diem/"+masv+"/"+malv, function(data){
                    //alert(data);
                    $('#huongdan').html(data);
                });
            });
            $("#masv").change(function(){
                var masv = $('#masv').val();
                var malv = $('#malv').val();
                $.get("admin/ajax/diem/"+masv+"/"+malv, function(data){
                    //alert(data);
                    $('#huongdan').html(data);
                });
            });
            $("#malv").change(function(){
                var masv = $('#masv').val();
                var malv = $('#malv').val();
                $.get("admin/ajax/diem/"+masv+"/"+malv, function(data){
                    //alert(data);
                    $('#huongdan').html(data);
                });
            });
        });
    </script>
@endsection