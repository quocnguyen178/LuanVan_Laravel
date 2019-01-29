@extends('layout.master')
@section('content')
@include('layout.navbar')
    <div class="col col-sm-3" style=" margin: 5px 0px 0px 400px; padding: 10px 0px;">
        <p style="text-align: center; font-weight: bold; color: #0F197E;">Xem Luận Văn</p>
        <form enctype="multipart/form-data" action="{{ route('thongke.postluanvan') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group col-sm-3" style="margin: 0px 15px">
                    <label>Tháng</label>
                        <select class="form-control" name = "thang">
                            <option value="">----</option>
                            @for($i = 1 ; $i <= 12; $i++)
                            <option value="{{ $i }}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                    <label>Năm</label>
                        <select class="form-control" name = "nam">
                            @for($i = 2015 ; $i <= date('Y'); $i++)
                            <option
                             value="{{ $i }}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                <div class="form-group col-sm-2 col-sm-offset-1"  style="margin: 25px 0px 0px 10px">
                <button type="submit" class="btn btn-info">Xem</button>
                </div>
        </form>
    </div>
    @if(session('data'))
    <?php $data = session('data'); ?>
    @if(!count($data))
        <div class="col-sm-12">
            <p style="color:red;font-size: 20px; text-align: center;">Không tìm thấy kết quả</p>
        </div>
        @else
            @if(isset($data))
                <table class="table table-striped table-bordered table-hover">
                <thead style="background: #1A91EA; color: white;">
                    <tr align="center">
                        <td>STT</td>
                        <td>MSLV</td>
                        <td>Tên Luận Văn</td>
                        <td>Tháng năm nộp</td>
                        <td>Loại luận văn</td>
                        <td>Nội dung tóm tắt</td>
                        <td>Giảng viên hướng dẫn</td>
                        <td>Tải về</td>
                    </tr>
                </thead>
                <?php $i=1; ?>
                @foreach($data as $lv)
                    <tr align="center">
                        <td>{{$i}}</td>
                        <td>{{$lv-> malv}}</td>
                        <td align="left">{{$lv-> tenlv}}</td>
                        <td >{{date('m-Y', strtotime($lv -> thangnam))}}</td>
                        <td >{{$lv-> tenloailv}}</td>
                        <td><a href="" data-toggle="modal" data-target="#{{$lv-> malv}}">Xem chi tiết</a></td>
                        
                        
                        {{-- Pop-up --}}
                        <div class="modal fade" id="{{$lv-> malv}}" role="dialog">
                            <div class="modal-dialog modal-md">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Nội dung tóm tắt: {{ $lv -> tenlv }}</h4>
                                </div>
                                <div class="modal-body">
                                  <p>{{ $lv-> noidungtomtat }}</p>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                        </div>
                        <td >{{$lv-> hotengv }}</td>
                        <td ><a href="">Tải về</a></td>
                    </tr>
                <?php $i++; ?>
                @endforeach
            </table>
            @endif
        @endif
	@endif
@endsection