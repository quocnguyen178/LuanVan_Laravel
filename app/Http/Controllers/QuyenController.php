<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quyen;
use App\GV_Quyen;
use App\SinhVien;

class QuyenController extends Controller
{
    public function getDanhSach()
    {
    	$quyen = Quyen::all();
    	return view('admin.quyen.danhsach',compact('quyen'));
    }

    public function getThem()
    {
        $quyen = Quyen::orderBy('maquyen', 'desc')-> first();
        $maquyen = $quyen-> maquyen + 1;
    	return view('admin.quyen.them',compact('maquyen'));
    }

    public function postThem(Request $request)
    {
    	$this-> validate($request,
    		[
    			'tenquyen' => 'required|unique:quyen,tenquyen'
    		],
    		[
    			'tenquyen.required' => 'Tên quyền không được để trống',
                'tenquyen.unique' => 'Quyền này đã tồn tại rồi'
    		]
    	);
        $quyen = Quyen::orderBy('maquyen', 'desc')-> first();
        $maquyen = $quyen-> maquyen + 1;
        $quyen = new Quyen;
        $quyen-> tenquyen = $request-> tenquyen;
        $quyen-> save();

        return redirect()->route('quyen.danhsach')->with('thongbao','Thêm thành công');
    }

    public function getXoa($id)
    {
    	$quyen = Quyen::find($id);
        $ktgv = GV_Quyen::where('maquyen',$id)->first();
        $ktsv = SinhVien::where('maquyen', $id)->first();
        if(is_null($ktgv) && is_null($ktsv))
	   {
            $quyen-> delete();
            return redirect()->route('quyen.danhsach')->with('thongbao','Xóa quyền thành công');
        }
        else{
            return redirect()->route('quyen.danhsach')->with('thongbao','Không thể xóa quyền này');
        }
    	
    }

    public function getSua($id)
    {
    	$quyen = Quyen::find($id);
    	return view('admin.quyen.sua',compact('quyen'));
    }

    public function postSua(Request $request, $id)
    {
    	$this-> validate($request,
    		[
                'tenquyen' => 'required|unique:quyen,tenquyen'
            ],
            [
                'tenquyen.required' => 'Tên quyền không được để trống',
                'tenquyen.unique' => 'Quyền này đã tồn tại rồi'
            ]
    	);
        $quyen = Quyen::find($id);
        $quyen-> tenquyen = $request-> tenquyen;
        $quyen-> save();

        return redirect()->route('quyen.danhsach')->with('thongbao','Sửa thành công');
    }
}
