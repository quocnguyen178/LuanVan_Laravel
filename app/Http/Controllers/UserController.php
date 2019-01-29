<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Quyen;
use App\SinhVien;
use App\GiangVien;
use App\GV_Quyen;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getDangnhapAdmin()
    {
        //return view('login');
    }

    public function postDangnhapAdmin(Request $request)
    {
        $this->validate($request,
            [
                'username' => 'nullable|required',
                'password' => 'nullable|required|min:3|max:32',
                'maquyen' => 'required'
            ],
            [
                'username.required' => 'Bạn chưa nhập tài khoản',
                'password.required' => 'Bạn chưa nhập mật khẩu',
                'password.min' => 'Password không được nhỏ hơn 3 ký tự',
                'password.max' => 'Password không được lớn hơn 32 ký tự',
                'maquyen.required' => 'Bạn phải chọn quyền'
            ]
        );
        if($request-> maquyen == 1)
        {
            //kiểm tra gv đó có tồn tại hay chưa
            $gv = GiangVien::where('magv',$request-> username)->where('matkhau',md5($request-> password))-> first();
            if(is_null($gv))
                return redirect()->route('trangchu.get')->with('thongbao','Sai thông tin tài khoản hoặc mật khẩu');
            $quyen= $gv-> gv_quyen->where('maquyen',1)->first();
            if(is_null($quyen))
                return redirect()->route('trangchu.get')->with('thongbao','Sai thông tin tài khoản hoặc mật khẩu');
            if($request-> maquyen == $quyen-> maquyen)
            {
                $request->session()->put('login1', true);
                $request->session()->put('name1', $gv-> hotengv);
                $request->session()->put('magv1', $gv-> magv);
                $request->session()->put('email1', $gv-> email);
                return redirect()->route('giangvien.danhsach');
            }
        }
        elseif($request-> maquyen == 2){
            $gv = GiangVien::where('magv',$request-> username)->where('matkhau',md5($request-> password))-> first();
            if(is_null($gv))
                return redirect()->route('trangchu.get')->with('thongbao','Sai thông tin tài khoản hoặc mật khẩu');
            $quyen= $gv-> gv_quyen->where('maquyen',2)->first();
            if(is_null($quyen))
                return redirect()->route('trangchu.get')->with('thongbao','Sai thông tin tài khoản hoặc mật khẩu');
            if($request-> maquyen == $quyen-> maquyen)
            {
                $request->session()->put('login2', true);
                $request->session()->put('name2', $gv-> hotengv);
                $request->session()->put('magv2', $gv-> magv);
                $request->session()->put('email2', $gv-> email);
                return redirect()->route('trangchu.get');
            }
        }
        elseif($request-> maquyen == 3){
            $sv = SinhVien::where('masv',$request-> username)
                            ->where('matkhau',md5($request-> password))
                            ->where('maquyen',3)-> first();
            
            if(is_null($sv))
                return redirect()->route('trangchu.get')->with('thongbao','Sai thông tin tài khoản hoặc mật khẩu');
            if($request-> maquyen == $sv-> maquyen)
            {
                $request->session()->put('login3', true);
                $request->session()->put('name3', $sv-> hotensv);
                $request->session()->put('masv3', $sv-> masv);
                $request->session()->put('email3', $sv-> email);
                return redirect()->route('trangchu.get');
            }
        }
        else{
            return redirect()->route('trangchu.get')->with('thongbao','Sai thông tin tài khoản hoặc mật khẩu');
        }
    }
    public function getDangXuatAdmin(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('trangchu.get');
    }

    public function doiMatKhauAdmin(Request $request, $id)
    {
        $this->validate($request,
            [
                'matkhaucu' => 'required',
                'matkhaumoi' => 'required',
                'nhaplaimatkhau' => 'required'
            ],
            [
                'matkhaucu.required' => 'Bạn chưa nhập mật khẩu cũ',
                'matkhaumoi.required' => 'Bạn chưa nhập mật khẩu mới',
                'nhaplaimatkhau.required' => 'Bạn chưa nhập lại mật khẩu mới'
            ]
        );
        $gv= GiangVien::find($id);
        if($gv-> matkhau == md5($request-> matkhaucu)){
            if($request-> matkhaumoi == $request-> nhaplaimatkhau){
                $gv-> matkhau = md5($request-> matkhaumoi);
                $gv-> save();
                return redirect()-> route('giangvien.danhsach')-> with('thongbao1','Thay đổi mật khẩu thành công');
            }else{
                return redirect()-> route('giangvien.danhsach')-> with('thongbao1','Thay đổi mật khẩu không thành công');
            }
        }else{
            return redirect()-> route('giangvien.danhsach')-> with('thongbao1','Thay đổi mật khẩu không thành công');
        }
    }

    public function doiMatKhauGiangVien(Request $request, $id)
    {
        $this->validate($request,
            [
                'matkhaucu' => 'required',
                'matkhaumoi' => 'required',
                'nhaplaimatkhau' => 'required'
            ],
            [
                'matkhaucu.required' => 'Bạn chưa nhập mật khẩu cũ',
                'matkhaumoi.required' => 'Bạn chưa nhập mật khẩu mới',
                'nhaplaimatkhau.required' => 'Bạn chưa nhập lại mật khẩu mới'
            ]
        );
        $gv= GiangVien::find($id);
        if($gv-> matkhau == md5($request-> matkhaucu)){
            if($request-> matkhaumoi == $request-> nhaplaimatkhau){
                $gv-> matkhau = md5($request-> matkhaumoi);
                $gv-> save();
                return redirect()->route('trangchu.get')->with('thongbao','Thay đổi mật khẩu thành công');
            }else{
                return redirect()->route('trangchu.get')->with('thongbao','Thay đổi mật khẩu không thành công');
            }
        }else{
            return redirect()->route('trangchu.get')->with('thongbao','Thay đổi mật khẩu không thành công');
        }
    }

    public function doiMatKhauSinhVien(Request $request, $id)
    {
        $this->validate($request,
            [
                'matkhaucu' => 'required',
                'matkhaumoi' => 'required',
                'nhaplaimatkhau' => 'required'
            ],
            [
                'matkhaucu.required' => 'Bạn chưa nhập mật khẩu cũ',
                'matkhaumoi.required' => 'Bạn chưa nhập mật khẩu mới',
                'nhaplaimatkhau.required' => 'Bạn chưa nhập lại mật khẩu mới'
            ]
        );
        $sv= SinhVien::find($id);
        if($sv-> matkhau == md5($request-> matkhaucu)){
            if($request-> matkhaumoi == $request-> nhaplaimatkhau){
                $sv-> matkhau = md5($request-> matkhaumoi);
                $sv-> save();
                return redirect()->route('trangchu.get')->with('thongbao','Thay đổi mật khẩu thành công');
            }else{
                return redirect()->route('trangchu.get')->with('thongbao','Thay đổi mật khẩu không thành công');
            }
        }else{
            return redirect()->route('trangchu.get')->with('thongbao','Thay đổi mật khẩu không thành công');
        }
    }
}
