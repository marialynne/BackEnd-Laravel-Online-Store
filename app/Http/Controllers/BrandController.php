<?php

namespace App\Http\Controllers;

use App\Brand;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class BrandController extends Controller
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
        $title = 'Index brands';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $brands = Brand::all();

        if(Brand::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($brands)->toJson();
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
        $tittle = 'Store brand';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'brand_name' => 'required|string',
            'brand_description' => 'nullable|string',
            'brand_details' => 'nullable|string'
        ]);

        $response = Brand::store(
            $request->brand_name,
            !empty($request->brand_description) ? $request->brand_description : null,
            !empty($request->brand_details) ? $request-> brand_details : null
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
    public static function show(int $id): JsonResponse
    {
        $status = 0;
        $title = 'Show brand';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $brand = Brand::where('id', $id)->first();

        if($brand!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Brand::find($id);
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
        $title = 'Update brand';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'brand_name' => 'required|string',
            'brand_description' => 'nullable|string',
            'brand_details' => 'nullable|string'
        ]);

        $brand = Brand::where('id', $id)->first();

        if(empty($brand)) {
            $msg = 'Brand cannot be null';
        } else {
            $response = Brand::updateModel(
                !empty($request->brand_name) ? $request-> brand_name : null,
                !empty($request->brand_description) ? $request-> brand_description : null,
                !empty($request->brand_details) ? $request-> brand_details : null,
                $brand
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
     * Remove the specified task from storage.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $status = 0;
        $title = 'Destroy brand';
        $code = 200;

        $brand = Brand::find($id);

        // if not exists
        if (!isset($brand)) {
            $msg = 'Task cannot be null';
        } else {
            $brand->delete();
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
        $title = 'Select2 brand';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = Brand::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Brand::exists()) {
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
