@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Đĩa Luận Văn
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
                @if(session('thongbao'))
                <div class="alert alert-success" id="anthongbao">
                    {{session('thongbao')}}
                </div>
                @endif
                <form enctype="multipart/form-data" action="{{route('dialuanvan.postthem')}}" method="POST">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                	<div class="form-group">
                        <label>Mã đĩa luận văn</label>
                        <input class="form-control" name="madia" readonly="" value="{{$madia}}" placeholder="Nhập mã loại luận văn" />
                    </div>
                    <div class="form-group">
                        <label>Luận văn</label>
                        <select class="form-control" name = "malv" id="loailv">
                            @foreach($luanvan as $lv)
                            <option value="{{ $lv -> malv }}">{{$lv-> malv}} - {{$lv-> tenlv}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>URL WORD</label>
                        <input type="file" class="form-control" name="fileword"   />
                    </div>
                    <div class="form-group">
                        <label>URL PDF</label>
                        <input type="file" class="form-control" name="filepdf" />
                    </div>
                    <div class="form-group">
                        <label>URL SOURCE</label>
                        <input type="file" class="form-control" name="filesrc"  />
                    </div>
                    
                    <button type="submit" class="btn btn-info" onclick="confirm_tb()">Thêm</button>
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