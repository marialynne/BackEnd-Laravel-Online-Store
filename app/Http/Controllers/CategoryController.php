<?php

namespace App\Http\Controllers;

use App\Category;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class CategoryController extends Controller
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

        $categories = Category::all();

        if(Category::exists()) {
            $status = 1 ;
            $msg = 'Successful index!';
            $data = Datatables::of($categories)->toJson();
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
        $tittle = 'Store category';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'category_name' => 'required|string',
            'category_tax' => 'nullable|numeric'
        ]);

        $response = Category::store(
            $request->category_name,
            !empty($request->category_tax) ? $request->category_tax : null
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
    public function show(int $id): JsonResponse
    {
        $status = 0;
        $title = 'Show category';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $category = Category::where('id', $id)->first();

        if($category!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Category::find($id);
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
        $title = 'Update category';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'category_name' => 'required|string',
            'category_tax' => 'nullable|numeric'
        ]);

        $category = Category::where('id', $id)->first();

        if(empty($category)) {
            $msg = 'Category cannot be null';
        } else {
            $response = Category::updateModel(
                $request->category_name,
                !empty($request->category_tax) ? $request-> category_tax : null,
                $category
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
        $title = 'Destroy category';
        $code = 200;

        $category = Category::find($id);

        // if not exists
        if (!isset($category)) {
            $msg = 'Task cannot be null';
        } else {
            $category->delete();
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

        $response = Category::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Category::exists()) {
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
