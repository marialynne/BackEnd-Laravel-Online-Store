<?php

namespace App\Http\Controllers;

use App\Ordered_service;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;


class OrderedServiceController extends Controller
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
        $title = 'Index ordered services';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $ordered_service = Ordered_service::with(['service_id','order_id'])->get();

        if(Ordered_service::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($ordered_service)->toJson();
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
        $tittle = 'Store ordered service';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'order_id' => 'required|exists:orders,id',
            'service_order_cost' => 'required|numeric'
        ]);

        $response = Ordered_service::store(
            $request->service_id,
            $request->order_id,
            $request->service_order_cost
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
        $title = 'Show ordered service';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $ordered_service = Ordered_service::where('id', $id)->first();

        if($ordered_service!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Ordered_service::with(['service_id','order_id'])->get()->find($id);
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
        $title = 'Update ordered service';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'order_id' => 'required|exists:orders,id',
            'service_order_cost' => 'required|numeric'
        ]);

        $ordered_service = Ordered_service::where('id', $id)->first();

        if(empty($ordered_service)) {
            $msg = 'Ordered service cannot be null';
        } else {
            $response = Ordered_service::updateModel(
                $request->service_id,
                $request->order_id,
                $request->service_order_cost,
                $ordered_service
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
        $title = 'Destroy ordered service';
        $code = 200;

        $ordered_service = Ordered_service::find($id);

        // if not exists
        if (!isset($ordered_service)) {
            $msg = 'Task cannot be null';
        } else {
            $ordered_service->delete();
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
