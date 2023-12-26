<?php

namespace App\Http\Controllers;

use App\Models\TermsPrivacy;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Validator;

class TermPrivacyController  extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $lang = app()->getLocale();
            $data = TermsPrivacy::where('lang',$lang)->latest()->get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;

                })

                ->rawColumns(['action'])

                ->make(true);

            return;
        }

        return view('admin.term_privacy.index');
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
    public function add_new_term()
    {
        return view('admin.term_privacy.add_term');
    }

    public function update_ter(Request $request){

        $validateErrors = Validator::make($request->all(),
            [
                'title' => 'required',
            ]);
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        }

        $data =[
            'title' => $request->title,
            'content' => $request->content1
        ];
        TermsPrivacy::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => 'تم الحفظ بنجاح' ]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
        $validateErrors = Validator::make($request->all(),[

        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }
        $lang = app()->getLocale();


        if($lang == 'ar'){
            $data =[
                'title' => $request->title_ar,
                'content' => $request->text_ar,
                'lang' => $lang
            ];

            TermsPrivacy::updateOrCreate(['id' => $request->_id],
                $data)->id;

            $data_en=[
                'title' => $request->title_en,
                'content' => $request->text_en,
                'lang' => 'en'

            ];

            TermsPrivacy::create(
                $data_en);
        }

        if($lang == 'en'){
            $data =[
                'title' => $request->title_en,
                'content' => $request->text_en,
                'lang' => $lang
            ];

            TermsPrivacy::updateOrCreate(['id' => $request->_id],
                $data)->id;
            //ar
            $data_ar=[
                'title' => $request->title_ar,
                'content' => $request->text_ar,
                'lang' => 'ar'

            ];


            TermsPrivacy::create(
                $data_ar);
        }
        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TermsPrivacy  $termsPrivacy
     * @return \Illuminate\Http\Response
     */
    public function show(TermsPrivacy $termsPrivacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TermsPrivacy  $termsPrivacy
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(TermsPrivacy::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TermsPrivacy  $termsPrivacy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TermsPrivacy $termsPrivacy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TermsPrivacy  $termsPrivacy
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(TermsPrivacy::class,$id);
    }
}
