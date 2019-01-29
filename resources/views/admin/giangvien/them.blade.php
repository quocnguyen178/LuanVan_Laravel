@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Giảng Viên
                    <small>Thêm</small>
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
                <form action="{{route('giangvien.postthem')}}" method="POST">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                	<div class="form-group">
                        <label>Mã giảng viên</label>
                        <input class="form-control" name="magv" readonly=""  value="{{$magv}}" placeholder="Nhập mã số giảng viên" />
                    </div>
                    <div class="form-group">
                        <label>Họ tên giảng viên</label>
                        <input class="form-control" name="hotengv" value="{{old('hotengv')}}" placeholder="Nhập họ tên giảng viên" />
                    </div>
                    <div class="form-group">
                        <label>Học hàm</label>
                        <select class="form-control" name="hocham">
                            <option value="GS">Giáo Sư</option>
                            <option value="PGS">Phó Giáo Sư</option>
                            <option value="GVC">Giảng Viên Chính</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Học vị</label>
                        <select class="form-control" name="hocvi">
                            <option value="KS">Kỹ Sư</option>
                            <option value="CN">Cử Nhân</option>
                            <option value="ThS">Thạc Sĩ</option>
                            <option value="TS">Tiến Sĩ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Loại giảng viên</label>
                        <select class="form-control" name="loaigv">
                            <option value="Cơ Hữu">Cơ Hữu</option>
                            <option value="Bán Cơ Hữu">Bán Cơ Hữu</option>
                            <option value="Thỉnh Giảng">Thỉnh Giảng</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Số điện thoại 1</label>
                        <input class="form-control" maxlength="11" name="sdt1" id="SDT" onChange="ktsdt()" onkeypress="return KTDT(/\d/,event);" value="{{old('sdt1')}}" placeholder="Nhập số điện thoại 1" />
                        <span id="SDT_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại 2</label>
                        <input class="form-control" maxlength="11" name="sdt2" id="SDT2" onChange="ktsdt2()" onkeypress="return KTDT(/\d/,event);" value="{{old('sdt2')}}" placeholder="Nhập số điện thoại 2" />
                        <span id="SDT2_error" class="error" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" value="{{old('email')}}" placeholder="Nhập Email" />
                    </div>
                    <div class="form-group">
                        <label>Quyền Admin: </label>
                        <label class="radio-inline">
                            <input name="maquyen" value="0" checked="" type="radio">Không
                        </label>
                        <label class="radio-inline">
                            <input name="maquyen" value="1" type="radio">Có
                        </label>
                    </div>
                    <button type="submit" id="them" class="btn btn-info" onclick="return confirm_tb()">Thêm</button>
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
<script>
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
        var sodt    = $.trim($('#SDT').val());
        var sodt2    = $.trim($('#SDT2').val());
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
        else if(sodt==sodt2) { 
            $('#SDT_error').text('Số điện thoại 1 bạn nhập bị trùng với số điện thoại 2');
            $('#them').prop('disabled',true);
        } 
        else 
        {
            $('#SDT_error').text(" "); 
            $('#them').prop('disabled',false);
        }
    } 
    function ktsdt2() 
    {
        var sodt2    = $.trim($('#SDT2').val());
        var sodt    = $.trim($('#SDT').val());
        var a=sodt2.substr(0,1);
        if(sodt2.length<10 || sodt2.length>11)
        {   
            $('#SDT2_error').text('Số điện thoại phải từ 10 đến 11 số');
            $('#them').prop('disabled',true);
        } 
        else if(a!=0) { 
            $('#SDT2_error').text('Số bạn nhập không phải là số điện thoại');
            $('#them').prop('disabled',true);
        } 
        else if(sodt==sodt2) { 
            $('#SDT2_error').text('Số điện thoại 2 bạn nhập bị trùng với số điện thoại 1');
            $('#them').prop('disabled',true);
        } 
        else 
        {
            $('#SDT2_error').text(" "); 
            $('#them').prop('disabled',false);
        }
    } 
</script>
@endsection