<?php

namespace App\Http\Controllers;

use App\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function index(): JsonResponse
    {
        $status = 0;
        $title = 'Index products';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;


        $product = Product::with(['brand_id','category_id','unit_id'])->get();

        if(Product::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($product)->toJson();
            $code = 201;
        }

        //return view('products', compact('product'));
        //$product->brand_id()->create(request()->all());

        return response()->json([
            'status' => $status,
            'title' => $title,
            'msg' => $msg,
            'data' => $data
        ], $code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $status = 0;
        $tittle = 'Store product';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'product_name' => 'required|string',
            'product_key' => 'required|string',
            'product_price' => 'required|numeric',
            'product_cost' => 'nullable|numeric',
            'product_image' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'product_model' => 'required|string',
            'unit_id' => 'required|exists:units,id'
        ]);

        $response = Product::store(
            $request->product_name,
            $request->product_key,
            $request->product_price,
            !empty($request->product_cost) ? $request->product_cost : null,
            !empty($request->product_image) ? $request->product_image : null,
            $request->brand_id,
            $request->category_id,
            $request->product_model,
            $request->unit_id
        );

        if(!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = 201;
        }

        return response()->json([
            'status' => $status,
            'title' => $tittle,
            'msg' => $msg,
            'data' => $data
        ], $code);
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public static function show(int $id): JsonResponse
    {
        $status = 0;
        $title = 'Show product';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $product = Product::where('id', $id)->first();

        if($product!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Product::with(['brand_id','category_id','unit_id'])->get()->find($id);
            $code = 201;
        }

        return response()->json([
            'status' => $status,
            'title' => $title,
            'msg' => $msg,
            'data' => $data
        ], $code);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param integer $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $status = 0;
        $title = 'Update product';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'product_name' => 'required|string',
            'product_key' => 'required|string',
            'product_price' => 'required|numeric',
            'product_cost' => 'nullable|numeric',
            'product_image' => 'nullable|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'product_model' => 'required|string',
            'unit_id' => 'required|exists:units,id'
        ]);

        $product = Product::where('id', $id)->first();

        if(empty($product)) {
            $msg = 'Product cannot be null';
        } else {
            $response = Product::updateModel(
                $request->product_name,
                $request->product_key,
                $request->product_price,
                !empty($request->product_cost) ? $request->product_cost : null,
                !empty($request->product_image) ? $request->product_image : null,
                $request->brand_id,
                $request->category_id,
                $request->product_model,
                $request->unit_id,
                $product
            );

            if(!empty($response)) {
                $status = 1 ;
                $msg = 'Successful update!';
                $data = $response;
                $code = 201;
            }
        }

        return response()->json([
            'status' => $status,
            'title' => $title,
            'msg' => $msg,
            'data' => $data
        ], $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $status = 0;
        $title = 'Destroy product';
        $code = 200;

        $product = Product::find($id);

        // if not exists
        if (!isset($product)) {
            $msg = 'Task cannot be null';
        } else {
            $product->delete();
            $status = 1 ;
            $msg = 'Successful destroy!';
        }

        return response()->json([
            'status' => $status,
            'title' => $title,
            'msg' => $msg
        ], $code);
    }

     /**
     * Return an array data of objects with value and text.
     *
     * @param Request $request
     * @return JsonResponse
      */
    public function select2(Request $request): JsonResponse
    {
        $status = 0;
        $title = 'Select2 product';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = Product::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Product::exists()) {
            $status = 1 ;
            $msg = 'Successful select2!';
            $data = $response;
        }

        return response()->json([
            'status' => $status,
            'title' => $title,
            'msg' => $msg,
            'data' => $data
        ], $code);
    }




    ////////
    public function cart()
    {
        session()->flash('success', 'Cart updated successfully');

        return view('cart');
    }

    public function addToCart($id)
    {
        $product = Product::find($id);

        if(!$product) {

            abort(404);

        }

        $cart = session()->get('cart');

        // if cart is empty then this the first product
        if(!$cart) {

            $cart = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price,
                    "photo" => $product->photo
                ]
            ];

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }

        // if cart not empty then check if this product exist then increment quantity
        if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Product added to cart successfully!');

        }

        // if item not exist in cart then add to cart with quantity = 1
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "photo" => $product->photo
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function update2(Request $request)
    {
        if($request->id and $request->quantity)
        {
            $cart = session()->get('cart');

            $cart[$request->id]["quantity"] = $request->quantity;

            session()->put('cart', $cart);

            session()->flash('success', 'Cart updated successfully');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {

            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {

                unset($cart[$request->id]);

                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product removed successfully');
        }
    }
}
