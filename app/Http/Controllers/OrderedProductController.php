<?php

namespace App\Http\Controllers;

use App\Ordered_product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class OrderedProductController extends Controller
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
        $title = 'Index ordered products';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $notifications = Ordered_product::with(['order_id','product_id'])->get();

        if(Ordered_product::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($notifications)->toJson();
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $status = 0;
        $tittle = 'Store ordered product';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'products_order_amount' => 'required|numeric',
            'products_order_cost' => 'required|numeric'
        ]);

        $response = Ordered_product::store(
            $request->order_id,
            $request->product_id,
            $request->products_order_amount,
            $request->products_order_cost
        );

        if(!empty($request)) {
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
    public function show(int $id): JsonResponse
    {
        $status = 0;
        $title = 'Show ordered product';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $notification = Ordered_product::where('id', $id)->first();

        if($notification!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Ordered_product::with(['order_id','product_id'])->get()->find($id);
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
        $title = 'Update ordered product';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'products_order_amount' => 'required|numeric',
            'products_order_cost' => 'required|numeric'
        ]);
        $ordered_product = Ordered_product::where('id', $id)->first();

        if(empty($ordered_product)) {
            $msg = 'Ordered product cannot be null';
        } else {
            $response = Ordered_product::updateModel(
                $request->order_id,
                $request->product_id,
                $request->products_order_amount,
                $request->products_order_cost,
                $ordered_product
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
        $title = 'Destroy ordered product';
        $code = 200;

        $ordered_product = Ordered_product::find($id);

        // if not exists
        if (!isset($ordered_product)) {
            $msg = 'Task cannot be null';
        } else {
            $ordered_product->delete();
            $status = 1 ;
            $msg = 'Successful destroy!';
        }

        return response()->json([
            'status' => $status,
            'title' => $title,
            'msg' => $msg
        ], $code);
    }
}
