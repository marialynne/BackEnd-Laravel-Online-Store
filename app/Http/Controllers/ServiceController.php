<?php

namespace App\Http\Controllers;

use App\Service;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class ServiceController extends Controller
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
        $title = 'Index services';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $service = Service::all();

        if(Service::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($service)->toJson();
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
        $tittle = 'Store service';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'service_name' => 'required|string',
            'service_description' => 'required|string'
        ]);

        $response = Service::store(
            $request->service_name,
            $request->service_description
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
        $title = 'Show service';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $service = Service::where('id', $id)->first();

        if($service!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Service::find($id);
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
        $title = 'Update service';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'service_name' => 'required|string',
            'service_description' => 'required|string'
        ]);

        $service = Service::where('id', $id)->first();

        if(empty($service)) {
            $msg = 'Service cannot be null';
        } else {
            $response = Service::updateModel(
                $request->service_name,
                $request->service_description,
                $service
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
     * @param ineteger $id
     * @return JsonResponse
     */
    public function destroy(ineteger $id): JsonResponse
    {
        $status = 0;
        $title = 'Destroy service';
        $code = 200;

        $service = Service::find($id);

        // if not exists
        if (!isset($service)) {
            $msg = 'Task cannot be null';
        } else {
            $service->delete();
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
        $title = 'Select2 service';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = Service::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Service::exists()) {
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
