<?php

namespace App\Http\Controllers;

use App\Type_of_user;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class TypeOfUserController extends Controller
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
        $title = 'Index type of users';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $type_of_user = Type_of_user::all();

        if(Type_of_user::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($type_of_user)->ToJSON();
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
        $tittle = 'Store type of user';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'type_of_user_name' => 'required|string',
            'type_of_user_description' => 'nullable|string'
        ]);

        $response = Type_of_user::store(
            $request->type_of_user_name,
            !empty($request->type_of_user_description) ? $request->type_of_user_description : null
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
        $title = 'Show type of user';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $type_of_user = Type_of_user::where('id', $id)->first();

        if($type_of_user!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Type_of_user::find($id);
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
        $title = 'Update type of user';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'type_of_user_name' => 'required|string',
            'type_of_user_description' => 'nullable|string'
        ]);

        $type_of_user = Type_of_user::where('id', $id)->first();

        if(empty($type_of_user)) {
            $msg = 'Type of user cannot be null';
        } else {
            $response = Type_of_user::updateModel(
                $request->type_of_user_name,
                !empty($request->type_of_user_description) ? $request->type_of_user_description : null,
                $type_of_user
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
        $title = 'Destroy type of user';
        $code = 200;

        $type_of_user = Type_of_user::find($id);

        // if not exists
        if (!isset($type_of_user)) {
            $msg = 'Task cannot be null';
        } else {
            $type_of_user->delete();
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
        $title = 'Select2 type of user';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = Type_of_user::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Type_of_user::exists()) {
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
