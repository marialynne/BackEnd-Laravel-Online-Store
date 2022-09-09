<?php

namespace App\Http\Controllers;

use App\Order;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;


class OrderController extends Controller
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
        $title = 'Index orders';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $orders = Order::with(['order_statuses_id','order_client_id','order_distributor_id','order_type_id'])->get();

        if(Order::exists()) {
            $status = 1 ;
            $msg = 'Successful index!';
            $data = Datatables::of($orders)->toJson();
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
        $tittle = 'Store order';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'order_date' => 'required',// |date_format:Y-m-d H:i:s
            'order_date_of_delivery' => 'required', // |date_format:Y-m-d H:i:s
            'order_status_id' => 'required|exists:order_statuses,id',
            'order_client_id' => 'required|exists:users,id',
            'order_distributor_id' => 'required|exists:users,id',
            'order_type_id' => 'required|exists:order_types,id'
        ]);

        $response = Order::store(
            $request->order_date,
            $request->order_date_of_delivery,
            $request->order_status_id,
            $request->order_client_id,
            $request->order_distributor_id,
            $request->order_type_id
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
        $title = 'Show order';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $order = Order::where('id', $id)->first();

        if($order!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Order::with(['order_statuses_id','order_client_id','order_distributor_id','order_type_id'])->get()->find($id);
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
        $title = 'Update order';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'order_date' => 'required',// |date_format:Y-m-d H:i:s
            'order_date_of_delivery' => 'required', // |date_format:Y-m-d H:i:s
            'order_status_id' => 'required|exists:order_statuses,id',
            'order_client_id' => 'required|exists:users,id',
            'order_distributor_id' => 'required|exists:users,id',
            'order_type_id' => 'required|exists:order_types,id'
        ]);

        $order = Order::where('id', $id)->first();

        if(empty($order)) {
            $msg = 'Order cannot be null';
        } else {
            $response = Order::updateModel(
                $request->order_date,
                $request->order_date_of_delivery,
                $request->order_status_id,
                $request->order_client_id,
                $request->order_distributor_id,
                $request->order_type_id,
                $order
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
        $title = 'Destroy order';
        $code = 200;

        $order = Order::find($id);

        // if not exists
        if (!isset($order)) {
            $msg = 'Task cannot be null';
        } else {
            $order->delete();
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
