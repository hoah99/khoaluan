<?php

namespace App\Modules\DeThi\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

use App\Modules\DeThi\Models\DeThi;
use App\Modules\MonThi\Models\MonThi;
use App\Modules\Lop\Models\Lop;
use App\Modules\GiangVien\Models\GiangVien;
use App\Modules\CauHoi\Models\CauHoi;
use App\Modules\CauHoiDeThi\Models\CauHoiDeThi;

class DeThiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dethi = DeThi::latest()->get();
        if ($request->ajax()) {
            $data = DeThi::latest()->get();
            foreach ($data as $key => $value) {
                $data[$key]->tenmon = MonThi::where('id','=',$data[$key]->idmonthi)->first()->tenmon;
                $data[$key]->hoten = GiangVien::where('id','=',$data[$key]->idgiangvien)->first()->hoten;
           }     
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm editDeThi"><i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;Sửa</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteDeThi"><i class="fa fa-trash" aria-hidden="true"></i></i>&nbsp;Xóa</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }
                return view('DeThi::dethi',compact('dethi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DeThi::updateOrCreate(['id' => $request->id],
            [
                'tieude' => $request->tieude,
                'socauhoi' => $request->socauhoi,
                'thoigian' => $request->thoigian,
                'matkhau' => $request->matkhau,
                'ghichu' => $request->ghichu,
                'idmonthi' => $request->idmonthi,
                'idgiangvien' => $request->idgiangvien,
                'idlop' => $request->idlop
            ]);
            
            // foreach($request->dschuong as $dsc)
            // {
            //     $cauhoi = CauHoi::where('idmonthi', $request->idmonthi)
            //             ->where('chuong', $dsc)
            //             ->inRandomOrder()->limit($request->unit)
            //             ->get();
            //     $cauhoidethi = new CauHoiDeThi();
            //     $cauhoidethi->idmonthi -> $request->idmonthi;
            //     $cauhoidethi->idcauhoi -> $cauhoi;
            // }
            
        
            return redirect()->route('dethi.index')->with('themthanhcong', 'Thêm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dethi = DeThi::find($id);
        return response()->json($dethi);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DeThi::find($id)->delete();

        return response()->json(['success'=>'Xóa thành công']);
    }

    // public function laydschuong($id){
    //     $sochuong = CauHoi::distinct()->count('chuong')->where('idmonthi', $id)->get();
    //     return view('DeThi::dethi')->with('sochuong', $sochuong);
    // }

    public function socaucuachuong($id)
    {
        $socau = CauHoi::groupBy('chuong')->select('chuong', CauHoi::raw('count(id) as Total'))->where('idmonthi','=', $id)->get()->toArray();
        return $socau;
    }
}