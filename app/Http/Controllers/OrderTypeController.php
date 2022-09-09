<?php

namespace App\Http\Controllers;

use App\Order_type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class OrderTypeController extends Controller
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
        $title = 'Index order types';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $order_type = Order_type::all();

        if(Order_type::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($order_type)->toJson();
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
        $tittle = 'Store order type';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'order_type_name' => 'required|string',
            'order_type_description' => 'nullable|string'
        ]);

        $response = Order_type::store(
            $request->order_type_name,
            !empty($request->order_type_description) ? $request->order_type_description : null
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
        $title = 'Show order type';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $order_type = Order_type::where('id', $id)->first();

        if($order_type!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Order_type::find($id);
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
        $title = 'Update order type';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'order_type_name' => 'required|string',
            'order_type_description' => 'nullable|string'
        ]);

        $order_status = Order_type::where('id', $id)->first();

        if(empty($order_status)) {
            $msg = 'Order type cannot be null';
        } else {
            $response = Order_type::updateModel(
                $request->order_type_name,
            !empty($request->order_type_description) ? $request->order_type_description : null,
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
        $title = 'Destroy order type';
        $code = 200;

        $order_type = Order_type::find($id);

        // if not exists
        if (!isset($order_type)) {
            $msg = 'Task cannot be null';
        } else {
            $order_type->delete();
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
        $title = 'Select2 order type';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = Order_type::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Order_type::exists()) {
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
