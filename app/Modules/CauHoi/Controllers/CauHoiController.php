<?php

namespace App\Modules\CauHoi\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

use App\Modules\CauHoi\Models\CauHoi;
use App\Modules\MonThi\Models\MonThi;

class CauHoiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cauhoi = CauHoi::latest()->get();
        if ($request->ajax()) {
            $data = CauHoi::latest()->get();
            foreach ($data as $key => $value) {
                $data[$key]->tenmon = MonThi::where('id','=',$data[$key]->idmonthi)->first()->tenmon;
           }     
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm editCauHoi"><i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;Sửa</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteCauHoi"><i class="fa fa-trash" aria-hidden="true"></i></i>&nbsp;Xóa</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }
                return view('CauHoi::cauhoi',compact('cauhoi'));
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
        CauHoi::updateOrCreate(['id' => $request->id],
            [
                'noidung' => $request->noidung,
                'phuongana' => $request->phuongana,
                'phuonganb' => $request->phuonganb,
                'phuonganc' => $request->phuonganc,
                'phuongand' => $request->phuongand,
                'dapan' => $request->dapan,
                'chuong' => $request->chuong,
                'dokho' => $request->dokho,
                'idmonthi' => $request->idmonthi
            ]);        
        
            return redirect()->route('cauhoi.index')->with('themthanhcong', 'Thêm thành công');
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
        $cauhoi = CauHoi::find($id);
        return response()->json($cauhoi);
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
        CauHoi::find($id)->delete();

        return response()->json(['success'=>'Xóa thành công']);
    }
}
