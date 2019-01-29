@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Hướng dẫn
                    <small>Thêm</small>
                </h1>
                @if(session('thongbao'))
                <div class="alert alert-danger">
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
                <form action="{{route('gv_sv_lv.postthem')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <label>Sinh viên</label>
                        <select class="form-control" name = "masv" {{-- id="loailv" --}}>
                            @foreach($sinhvien as $sv)
                            <option value="{{ $sv -> masv }}">{{$sv-> masv}} - {{$sv-> hotensv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Giảng viên</label>
                        <select class="form-control" name = "magv" {{-- id="loailv" --}}>
                            @foreach($giangvien as $gv)
                            <option value="{{ $gv -> magv }}">{{$gv-> magv}} - {{$gv-> hotengv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Luận văn</label>
                        <select class="form-control" name = "malv" id="malv" >
                            <option value="">----</option>
                            @foreach($luanvan as $lv)
                            <option value="{{ $lv -> malv }}">{{ $lv -> malv }} - {{$lv-> tenlv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tháng năm nộp của luận văn trên là</label>
                        <p id="thangnop">Chưa có luận văn nào được chọn</p>
                    </div>
                    <div class="form-group">
                        <label>Ngày bắt đầu</label> <span> ( dd-mm-yyyy )</span>
                        <input class="form-control"  name="ngaybd" id="ngaybd" value="{{old('ngaybd')}}" placeholder="Nhập ngày bắt đầu" />
                    </div>
                    <div class="form-group">
                        <label>Ngày kết thúc</label> <span> ( dd-mm-yyyy )</span>
                        <input class="form-control" name="ngaykt" value="{{old('ngaykt')}}" placeholder="Nhập ngày kết thúc" />
                    </div>
                    <div class="form-group">
                        <label>Hướng dẫn</label> <span>(%)</span>
                        <input class="form-control" name="phantramhd" value="{{old('phantramhd')}}" placeholder="Nhập phần trăm hướng dẫn" />
                    </div>
                    <button type="submit" class="btn btn-info" onclick=" return confirm_tb()">Thêm</button>
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
        function aaa(){
            var a=$('#ngaybd').val();
            var thangnop=$('#thangnop').val();
            var thangbd=a.substr(3,2);
            alert(thangnop);
        }
        function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");}
         $(document).ready(function() {
            $('#malv').change(function(){
                var malv = $('#malv').val();
                $.get("admin/ajax/huongdan/"+malv, function(data){
                    $('#thangnop').html(data);
            });
            });
        });
    
    </script>
@endsection