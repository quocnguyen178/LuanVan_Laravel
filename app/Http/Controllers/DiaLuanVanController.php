<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\DiaLuanVan;
use App\LuanVan;
use File;
class DiaLuanVanController extends Controller
{
    public function getDanhSach()
    {
    	$dialuanvan = DiaLuanVan::all();
    	return view('admin.dialuanvan.danhsach', compact('dialuanvan'));
    }

    public function getThem()
    {
        // Lấy mã đĩa văn cuối cùng ra
        $dlv_temp= DiaLuanVan::orderBy('madia','desc')->first();
        $madia='';
        $namdlv = date("y");//18
        if(is_null($dlv_temp))
       {
           $madia="LVD".$namdlv."0001";  
       }else
       {
            //lấy tiền tố LVD
            $tiento = substr( $dlv_temp-> madia,  0, 3);
            //lấy năm LVD
            $nam = substr( $dlv_temp-> madia,  3, 2);
            // độ dài của mã = 8(LVD180001)
            $len = $dlv_temp-> madia;
            //cắt bỏ tiền tố 'LVD'-> 0001 + 1 = 2 
            $next= substr( $dlv_temp-> madia,  5, 4) + 1;
            //lấy độ dài mã trừ độ dài tiền tố 8-2=5
            $lenght= strlen($len) - strlen($tiento) -strlen($nam);
            //chuỗi chứa dãy số 0
            $zero='';
            for ($i=1; $i <= $lenght ; $i++) { 
            //pow(10,i) lấy bình phương 10^i
                if($next < pow(10,$i)){
                    for ($j=1; $j <= $lenght - $i  ; $i++) {
                        $zero .="0";
                    }
                    $madia = $tiento.$nam.$zero.$next;
                }
            }
        }
    	$luanvan = LuanVan::all();
    	return view('admin.dialuanvan.them', compact('luanvan','madia'));
    }

    public function postThem(Request $request)
    {
    	$this-> validate($request,
    		[
             'malv' => 'required|unique:dialuanvan,malv',
             'urlfilelv' => 'nullable'
            ],

            [
                'malv.required' => 'Mã luận văn không được để trống',
                'malv.unique' => 'Luận văn này đã có đĩa rồi'
            ]
    	);
        // Lấy mã luận văn cuối cùng ra
        $dlv_temp= DiaLuanVan::orderBy('madia','desc')->first();
        $madia='';
        $namdlv = date("y");//18
        if(is_null($dlv_temp))
       {
           $madia="LVD".$namdlv."0001";  
       }else
       {
            //lấy tiền tố LVD
            $tiento = substr( $dlv_temp-> madia,  0, 3);
            //lấy năm LVD
            $nam = substr( $dlv_temp-> madia,  3, 2);
            // độ dài của mã = 8(LVD180001)
            $len = $dlv_temp-> madia;
            //cắt bỏ tiền tố 'LVD'-> 0001 + 1 = 2 
            $next= substr( $dlv_temp-> madia,  5, 4) + 1;
            //lấy độ dài mã trừ độ dài tiền tố 8-2=5
            $lenght= strlen($len) - strlen($tiento) -strlen($nam);
            //chuỗi chứa dãy số 0
            $zero='';
            for ($i=1; $i <= $lenght ; $i++) { 
            //pow(10,i) lấy bình phương 10^i
                if($next < pow(10,$i)){
                    for ($j=1; $j <= $lenght - $i  ; $i++) {
                        $zero .="0";
                    }
                    $madia = $tiento.$nam.$zero.$next;
                }
            }
        }
        if($request->hasFile('fileword') && $request->hasFile('filepdf') && $request->hasFile('filesrc'))
        {
        $dialuanvan = new DiaLuanVan;
        $dialuanvan-> madia = $request-> madia;
        $dialuanvan-> malv = $request-> malv;
        $fileword= $request->file('fileword');
        $filepdf= $request->file('filepdf');
        $filesrc= $request->file('filesrc');
        $duoiword = $fileword-> getClientOriginalExtension();
        //dd($duoiword);
            if($duoiword == 'doc' || $duoiword == 'docx' )
            {
                $dialuanvan-> fileword = $fileword->getClientOriginalName();
            }
            else{   
                return redirect()-> back()->with('thongbao','File bạn chọn không phải Word');
            }
        $duoipdf = $filepdf-> getClientOriginalExtension();
            if($duoipdf != 'pdf')
                return redirect()-> back()->with('thongbao','File bạn chọn không phải PDF');
            $dialuanvan-> filepdf = $filepdf->getClientOriginalName();
        $duoisrc = $filesrc-> getClientOriginalExtension();
            if($duoisrc == 'rar' || $duoisrc == 'zip' ){
                $dialuanvan-> filesrc = $filesrc->getClientOriginalName();
            }else{
                return redirect()-> back()->with('thongbao','File bạn chọn không phải nén');
            }
        $fileword->move('url/doc',$fileword->getClientOriginalName());
        $filepdf->move('url/pdf',$filepdf->getClientOriginalName());
        $filesrc->move('url/src',$filesrc->getClientOriginalName());
        $dialuanvan-> save();
        return redirect()->route('dialuanvan.danhsach')->with('thongbao','Thêm đĩa luận văn thành công');
        } else return redirect()->back()->with('thongbao','Bạn chưa chọn đủ 3 file!');
    }

    public function getXoa($id)
    {
    	$dialuanvan = DiaLuanVan::find($id);
        unlink("url/doc/".$dialuanvan->fileword);
        unlink("url/pdf/".$dialuanvan->filepdf);
        unlink("url/src/".$dialuanvan->filesrc);
        $dialuanvan->delete();
    	return redirect()->route('dialuanvan.danhsach')->with('thongbao','Xóa đĩa luận văn thành công');
    }

    public function getSua($id)
    {
    	$dialuanvan = DiaLuanVan::find($id);
    	$luanvan = LuanVan::all();
    	return view('admin.dialuanvan.sua',compact('dialuanvan','luanvan'));
    }

    public function postSua(Request $request, $id)
    {
    	$this-> validate($request,
    		[
             'malv' => 'required|unique:dialuanvan,malv',
             'urlfilelv' => 'nullable'
            ],

            [
                'malv.required' => 'Mã luận văn không được để trống',
                'malv.unique' => 'Luận văn này đã có đĩa rồi'
            ]
    	);
        $dialuanvan = DiaLuanVan::find($id);
        $fileword= $request->file('fileword');
        // dd($fileword);
        $filepdf= $request->file('filepdf');
        $filesrc= $request->file('filesrc');
        //dd($request->file('fileword'));
        if($request->file('fileword')){
            $duoiword = $fileword-> getClientOriginalExtension();
            if($duoiword == 'doc' || $duoiword == 'docx' )
                {
                    unlink("url/doc/".$dialuanvan->fileword);
                    $dialuanvan-> fileword = $fileword->getClientOriginalName();
                    //dd($dialuanvan-> fileword);
                    $fileword->move('url/doc',$fileword->getClientOriginalName());
                }
            else{   
                return redirect()-> back()->with('thongbao','File bạn chọn không phải Word');
            }
        }
        if($request->file('filepdf')){
            $duoipdf = $filepdf-> getClientOriginalExtension();
            if($duoipdf == 'pdf')
                {
                    unlink("url/pdf/".$dialuanvan->filepdf);
                    $dialuanvan-> filepdf = $filepdf->getClientOriginalName();
                    $filepdf->move('url/pdf',$filepdf->getClientOriginalName()); 
                }
            else{   
                return redirect()-> back()->with('thongbao','File bạn chọn không phải PDF');
            }
        }
        if($request->file('filesrc')){
            $duoisrc = $filesrc-> getClientOriginalExtension();
            if($duoisrc == 'rar' || $duoisrc == 'zip')
                {
                    unlink("url/src/".$dialuanvan->filesrc);
                    $dialuanvan-> filesrc = $filesrc->getClientOriginalName();

                    $filesrc->move('url/src',$filesrc->getClientOriginalName()); 
                }
            else{   
                return redirect()-> back()->with('thongbao','File bạn chọn không phải PDF');
            }
        }
        $dialuanvan-> malv=$request-> malv;
        $dialuanvan->save();
        return redirect()->route('dialuanvan.danhsach')->with('thongbao','Sửa đĩa luận văn thành công');
    }
}
