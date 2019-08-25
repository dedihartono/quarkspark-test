<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Product;
use DataTables;
use App\Http\Controllers\MailController;

class ProductController extends Controller
{
    protected $user_id;
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
        $data['status'] = $this->getDataStatus();
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
        $this->user_id = auth()->user()->id;

        $productId = $request->product_id;

        Product::updateOrCreate(
            ['id' => $productId],
            [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'user_id' => $this->user_id,
                'price' => $request->price,
                'stock' => $request->stock,
                'note' => $request->note,
                'status' => $request->status,
            ]
        );

        if (env('APP_ENV') == 'production') {
            if ($request->status == 'WAITING') {
                $this->sendMail('PRODUCT', 'dedihartono1993@gmail.com', 'nonename1k@gmail.com', 'test', 'test', 'hello there');
            }
        }

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
        return $this->getDataTables();
    }

    protected function getDataTables()
    {
        $this->user_id = auth()->user()->id;
        if (auth()->user()->isAdmin == 1) {
            return Datatables::of(Product::with('category')->get())
                ->addColumn('action', function ($data) {
                    return view('product.action_button', $data);
                })
                ->addColumn('status', function ($data) {
                    return view('product.status', $data);
                })
                ->addColumn('category', function ($data) {
                    return $data->category->name ?? '';
                })
                ->rawColumns(['action','category','status'])
                ->addIndexColumn()
                ->make(true);
        } else {
            return Datatables::of(Product::with('category')->where('user_id', $this->user_id)->get())
                ->addColumn('action', function ($data) {
                    return view('product.action_button', $data);
                })
                ->addColumn('status', function ($data) {
                    return view('product.status', $data);
                })
                ->addColumn('category', function ($data) {
                    return $data->category->name ?? '';
                })
                ->rawColumns(['action','category','status'])
                ->addIndexColumn()
                ->make(true);
        }
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

    protected function getDataStatus()
    {
        $data = [];
        $status = ['WAITING', 'APPROVE', 'REJECT'];
        foreach ($status as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }

    protected function sendMail($to_name, $to_mail, $from, $subject, $title, $data)
    {
        $mail = new MailController;
        $mail->index($to_name, $to_mail, $from, $subject, $title, $data);
    }
}
