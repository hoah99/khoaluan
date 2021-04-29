<?php

namespace App\Modules\GiangVien\Controllers;

use Illuminate\Support\Facades\Hash;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

use App\Modules\GiangVien\Models\GiangVien;

class GiangVienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $giangvien = GiangVien::latest()->get();
        if ($request->ajax()) {
            $data = GiangVien::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm editGiangVien"><i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;Sửa</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteGiangVien"><i class="fa fa-trash" aria-hidden="true"></i></i>&nbsp;Xóa</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }
                return view('GiangVien::giangvien',compact('giangvien'));
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
        GiangVien::updateOrCreate(['id' => $request->id],
            [
                'hoten' => $request->hoten,
                'taikhoan' => $request->taikhoan,
                'matkhau' => Hash::make($request->matkhau),
                'email' => $request->email,
                'sdt' => $request->sdt,
            ]);        
        
            return redirect()->route('giangvien.index')->with('themthanhcong', 'Thêm thành công');
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
        $giangvien = GiangVien::find($id);
        return response()->json($giangvien);
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
        GiangVien::find($id)->delete();

        return response()->json(['success'=>'Xóa thành công']);
    }
}
