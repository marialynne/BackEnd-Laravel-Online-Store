<?php

namespace App\Http\Controllers;

use App\Shipment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class ShipmentController extends Controller
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
        $title = 'Index shipments';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $shipment = Shipment::with(['service_id','ordered_product_id'])->get();

        if(Shipment::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($shipment)->toJson();
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
        $tittle = 'Store shipment';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'ordered_product_id' => 'required|exists:ordered_products,id'
        ]);

        $response = Shipment::store(
            $request->service_id,
            $request->ordered_product_id
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
        $title = 'Show shipment';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $shipment = Shipment::where('id', $id)->first();

        if($shipment!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Shipment::with(['service_id','ordered_product_id'])->get()->find($id);
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
        $title = 'Update shipment';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'service_id' => 'required|exists:services,id',
            'ordered_product_id' => 'required|exists:ordered_products,id'
        ]);

        $shipment = Shipment::where('id', $id)->first();

        if(empty($shipment)) {
            $msg = 'Shipment cannot be null';
        } else {
            $response = Shipment::updateModel(
                $request->service_id,
                $request->ordered_product_id,
                $shipment
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
        $title = 'Destroy shipment';
        $code = 200;

        $shipment = Shipment::find($id);

        // if not exists
        if (!isset($shipment)) {
            $msg = 'Task cannot be null';
        } else {
            $shipment->delete();
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
