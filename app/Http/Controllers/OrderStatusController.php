<?php

namespace App\Http\Controllers;

use App\Order_status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class OrderStatusController extends Controller
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
        $title = 'Index order status';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $order_status = Order_status::all();

        if(Order_status::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($order_status)->toJson();
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
        $tittle = 'Store order status';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'order_status_name' => 'required|string',
            'order_status_description' => 'nullable|string'
        ]);

        $response = Order_status::store(
            $request->order_status_name,
            !empty($request->order_status_description) ? $request->order_status_description : null
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
        $title = 'Show order status';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $order_status = Order_status::where('id', $id)->first();

        if($order_status!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Order_status::find($id);
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
        $title = 'Update order status';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'order_status_name' => 'required|string',
            'order_status_description' => 'nullable|string'
        ]);

        $order_status = Order_status::where('id', $id)->first();

        if(empty($order_status)) {
            $msg = 'Order status cannot be null';
        } else {
            $response = Order_status::updateModel(
                $request->order_status_name,
                !empty($request->order_status_description) ? $request->order_status_description : null,
                $order_status
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
        $title = 'Destroy order status';
        $code = 200;

        $order_status = Order_status::find($id);

        // if not exists
        if (!isset($order_status)) {
            $msg = 'Task cannot be null';
        } else {
            $order_status->delete();
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
        $title = 'Select2 order status';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = Order_status::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Order_status::exists()) {
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
}
