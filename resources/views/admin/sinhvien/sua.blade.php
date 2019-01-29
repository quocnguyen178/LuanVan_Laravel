@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sinh Viên
                    <small>Sửa</small>
                </h1>
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
                <form action="{{route('sinhvien.postsua', $sinhvien-> masv)}}" method="POST">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                	<div class="form-group">
                        <label>Mã số sinh viên</label>
                        <input class="form-control" name="masv" readonly="" value="{{$sinhvien->masv}}" placeholder="Nhập mã số sinh viên" />
                    </div>
                    <div class="form-group">
                        <label>Họ tên sinh viên</label>
                        <input class="form-control" name="hotensv" value="{{$sinhvien->hotensv}}" placeholder="Nhập họ tên sinh viên" />
                    </div>
                    <div class="form-group">
                        <label>Lớp</label>
                        <input class="form-control" name="lop" value="{{$sinhvien->lop}}" placeholder="Nhập lớp" />
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input class="form-control" name="sdt" id="SDT" onChange="ktsdt()" onkeypress="return KTDT(/\d/,event);" value="{{$sinhvien->sdt}}" placeholder="Nhập số điện thoại" />
                        <span id="SDT_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" value="{{$sinhvien->email}}" placeholder="Nhập Email" />
                    </div>
                    <button type="submit" id="them" class="btn btn-info" onclick="return confirm_tb()">Sửa</button>
                    {{-- <button type="submit" class="btn btn-default">Thêm</button> --}}
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
@section('script_sdt')
<script type="text/javascript">
    function confirm_tb(){
        return confirm("Bạn có chắc chắn thực hiện hành động này");
    }
    function KTDT(numcheck, e) 
    {
        var keynum, keychar, numcheck;
        if (window.event) 
        {
            keynum = e.keyCode;
        }
        else if (e.which) 
        {
            keynum = e.which;
        }
        if (keynum == 8 || keynum == 127 || keynum == null || keynum == 9 || keynum == 0 || keynum == 13 ) 
            return true;
        keychar = String.fromCharCode(keynum);
        var result = numcheck.test(keychar);
        return result;
    }   
    function ktsdt() 
    {
        var sodt = $.trim($('#SDT').val());
        var a=sodt.substr(0,1);
                if(sodt.length<10 || sodt.length>11)
        {   
            $('#SDT_error').text('Số điện thoại phải từ 10 đến 11 số');
            $('#them').prop('disabled',true);
        } 
        else if(a!=0) { 
            $('#SDT_error').text('Số bạn nhập không phải là số điện thoại');
            $('#them').prop('disabled',true);
        } 
        else 
        {
            $('#SDT_error').text(" "); 
            $('#them').prop('disabled',false);
        }
    } 
</script>
@endsection