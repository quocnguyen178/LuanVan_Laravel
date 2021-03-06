@extends('admin.layout.master')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại Luận Văn
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
                <form action="{{route('phanloailv.postsua', $loailv-> maloailv)}}" method="POST">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}" />
                	<div class="form-group">
                        <label>Mã loại luận văn</label>
                        <input class="form-control" name="maloailv" readonly="" value="{{$loailv-> maloailv}}" placeholder="Nhập mã loại luận văn" />
                    </div>
                    <div class="form-group">
                        <label>Tên loại luận văn</label>
                        <input class="form-control" name="tenloailv" value="{{$loailv-> tenloailv}}" placeholder="Nhập tên loại luận văn" />
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