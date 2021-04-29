<?php

namespace App\Modules\Lop\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

use App\Modules\Lop\Models\Lop;
use App\Modules\BoMon\Models\BoMon;

class LopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lop = Lop::latest()->get();
        if ($request->ajax()) {
            $data = Lop::latest()->get();
            foreach ($data as $key => $value) {
                $data[$key]->tenbomon = BoMon::where('id','=',$data[$key]->idbomon)->first()->tenbomon;
           }     
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm editLop"><i class="fa fa-wrench" aria-hidden="true"></i>&nbsp;Sửa</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteLop"><i class="fa fa-trash" aria-hidden="true"></i></i>&nbsp;Xóa</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                }
                return view('Lop::lop',compact('lop'));
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
        Lop::updateOrCreate(['id' => $request->id],
            [
                'malop' => $request->malop,
                'tenlop' => $request->tenlop,
                'idbomon' => $request->idbomon
            ]);        
        
            return redirect()->route('lop.index')->with('themthanhcong', 'Thêm thành công');
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
        $lop = Lop::find($id);
        return response()->json($lop);
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
        Lop::find($id)->delete();

        return response()->json(['success'=>'Xóa thành công']);
    }
}
