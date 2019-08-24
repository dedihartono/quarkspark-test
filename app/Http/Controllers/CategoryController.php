<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use DataTables;

class CategoryController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('category.category');
    }
    /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
    public function store(Request $request)
    {
        $categoryId = $request->category_id;
        Category::updateOrCreate(
            ['id' => $categoryId],
            [
                'name' => $request->name,
            ]
        );
        return response()->json(['success'=>'Category saved successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $category  = Category::where($where)->first();

        return  response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id', $id)->delete();

        return response()->json(['success'=>'Category deleted successfully.']);
    }

    /**
     * json
     *
     * @return void
     */
    public function json()
    {
        return Datatables::of(Category::get())
            ->addColumn('action', function ($data) {
                return view('category.action_button', $data);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}
