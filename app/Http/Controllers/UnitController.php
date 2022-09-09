<?php

namespace App\Http\Controllers;

use App\Unit;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class UnitController extends Controller
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
        $title = 'Index units';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $unit = Unit::all();

        if(unit::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($unit)->toJson();
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
        $tittle = 'Store unit';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'unit_name' => 'required|string',
            'unit_description' => 'nullable|string'
        ]);

        $response = Unit::store(
            $request->unit_name,
            !empty($request->unit_description) ? $request->unit_description : null
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
        $title = 'Show unit';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $unit = Unit::where('id', $id)->first();

        if($unit!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Unit::find($id);
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
        $title = 'Update unit';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'unit_name' => 'required|string',
            'unit_description' => 'nullable|string'
        ]);

        $unit = Unit::where('id', $id)->first();

        if(empty($unit)) {
            $msg = 'Unit cannot be null';
        } else {
            $response = Unit::updateModel(
                $request->unit_name,
                !empty($request->unit_description) ? $request->unit_description : null,
                $unit
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
        $title = 'Destroy unit';
        $code = 200;

        $unit = Unit::find($id);

        // if not exists
        if (!isset($unit)) {
            $msg = 'Task cannot be null';
        } else {
            $unit->delete();
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
        $title = 'Select2 unit';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = Unit::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Unit::exists()) {
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
