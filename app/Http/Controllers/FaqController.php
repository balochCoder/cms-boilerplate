<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Page;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:faqs-add|faqs-edit|role-view|faqs-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:faqs-add', ['only' => ['create', 'store']]);
        $this->middleware('permission:faqs-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:faqs-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $faqs = Faq::select('*');
            return DataTables::of($faqs)
                ->addIndexColumn()
                ->addColumn('page', function ($row) {
                    return Str::of(Str::replace('-', ' ', $row->page))->upper();
                })
                ->addColumn('answer', function($row){
                    return Str::of($row->answer)->limit(300);
                })
                ->addColumn('created_at', function ($row) {
                    return date('d-M-Y', strtotime($row->created_at));
                })
                ->addColumn('action', function ($row) {

                        $btn = '';
                        if (Auth::user()->hasPermissionTo('faqs-edit')) {
                            $btn .= '<a href="' . route('faqs.edit', $row->id) . '"><i title="Edit" class="fas fa-edit font-size-18"></i></a>';
                        }

                        if (Auth::user()->hasPermissionTo('faqs-delete')) {
                            $btn .= ' <a href="javascript:void(0);" class="text-danger remove" data-id="' . $row->id . '"><input type="hidden" value="' . $row->id . '"/><i title="Delete" class="fas fa-trash-alt font-size-18"></i></a>';
                        }

                        return $btn;

                })
                ->rawColumns(['page', 'answer', 'created_at', 'action'])
                ->make(true);
        }

        return view('backend.admin.faqs.index');
    }

    public function create()
    {
        $pages = Page::all();

        return view('backend.admin.faqs.create')->with('pages',$pages);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'page' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);

        try {
            Faq::create([
                'page' => $request->page,
                'question' => $request->question,
                'answer' => $request->answer
            ]);


            $data['type'] = "success";
            $data['message'] = "FAQ Added Successfuly!.";
            $data['icon'] = 'mdi-check-all';

            return redirect()->route('faqs.index')->with($data);
        } catch (\Throwable $th) {
            $data['type'] = "danger";
            $data['message'] = "Failed to Add FAQ, please try again.";
            $data['icon'] = 'mdi-block-helper';

            return redirect()->back()->withInput()->with($data);
        }
    }

    public function edit(Faq $faq)
    {
        $pages = Page::all();
        return view('backend.admin.faqs.edit', compact(['pages', 'faq']));
    }


    public function update(Request $request, Faq $faq)
    {
        $this->validate($request, [
            'page' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);

        try {
            $input = $request->all();


            $faq->update($input);


            $data['type'] = "success";
            $data['message'] = "FAQ Update Successfuly!.";
            $data['icon'] = 'mdi-check-all';

            return redirect()->route('faqs.index')->with($data);
        } catch (\Throwable $th) {
            $data['type'] = "danger";
            $data['message'] = "Failed to Update FAQ, please try again.";
            $data['icon'] = 'mdi-block-helper';

            return redirect()->back()->withInput()->with($data);
        }
    }

    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();
            $data['type'] = "success";
            $data['message'] = "FAQ Deleted Successfuly!.";
            $data['icon'] = 'mdi-check-all';

            echo json_encode($data);
        } catch (\Throwable $th) {
            //throw $th;
            $data['type'] = "danger";
            $data['message'] = "Failed to Remove FAQ, please try again.";
            $data['icon'] = 'mdi-block-helper';

            echo json_encode($data);
        }
    }
}
