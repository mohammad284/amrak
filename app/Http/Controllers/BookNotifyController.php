<?php

namespace App\Http\Controllers;

use App\Models\BookNotify;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;


class BookNotifyController extends Controller
{  use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = BookNotify::get();

            return Datatables::of($data)
                ->addIndexColumn()
//                ->addColumn('customer', function($row){
//                    return $row->user->name ?? "غير محدد";
//
//                })
                ->addColumn('provider', function($row) {
                    $lang = app()->getLocale();

                    if ($lang == 'ar'){
                        return $row->provider->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';

                    }elseif ($lang == 'en'){
                        return $row->provider->name ?? '<span class="badge bg-warning text-light">undefined</span>';

                    }
                })
                ->addColumn('customer', function($row) {
                    $lang = app()->getLocale();

                    if ($lang == 'ar'){
                        return $row->customer->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';

                    }elseif ($lang == 'en'){
                        return $row->customer->name ?? '<span class="badge bg-warning text-light">undefined</span>';

                    }
                })
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    return $btn;

                })

                ->rawColumns(['action','customer','provider'])

                ->make(true);

            return;
        }
        return view('admin.notifications.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookNotify  $bookNotify
     * @return \Illuminate\Http\Response
     */
    public function show(BookNotify $bookNotify)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookNotify  $bookNotify
     * @return \Illuminate\Http\Response
     */
    public function edit(BookNotify $bookNotify)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookNotify  $bookNotify
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookNotify $bookNotify)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookNotify  $bookNotify
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BookNotify $bookNotify,$id)
    {
        return $this->destroyController(BookNotify::class,$id);
    }
}
