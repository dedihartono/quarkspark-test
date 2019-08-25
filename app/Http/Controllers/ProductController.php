<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use DataTables;

class ProductController extends Controller
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
        $data['dropdowns'] = $this->getDataDropdown();
        return view('product.product', $data);
    }

    /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
    public function store(Request $request)
    {
        $productId = $request->product_id;
        Product::updateOrCreate(
            ['id' => $productId],
            [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'user_id' => 1,
                'price' => $request->price,
                'stock' => $request->stock,
                'note' => $request->note,
            ]
        );
        return response()->json(['success'=>'Product saved successfully.']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $product  = Product::where($where)->first();

        return  response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }

    /**
     * json
     *
     * @return void
     */
    public function json()
    {
        return Datatables::of(Product::with('category')->get())
            ->addColumn('action', function ($data) {
                return view('product.action_button', $data);
            })
            ->addColumn('category', function($data){
                return $data->category->name ?? '';
            })
            ->rawColumns(['category','action'])
            ->addIndexColumn()
            ->make(true);
    }

    protected function getDataDropdown()
    {
        $data = [];
        $model = Category::all();

        if (!empty($model)) {
            foreach ($model as $key => $value) {
                $data[$key]['value'] = $value->id;
                $data[$key]['label'] = $value->name;
            }
        }
        return  $data;
    }
}
