<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class UserController extends Controller
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
        $title = 'Index users';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $users = User::with('type_of_user_id')->get();

        if(User::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($users)->ToJSON();
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
        $tittle = 'Store user';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'user_name' => 'required|string',
            'user_surnames' => 'nullable|string',
            'user_email' => 'required|string',
            'user_profile_picture' => 'nullable|string',
            'user_receive_notifications' => 'nullable|boolean',
            'user_receive_recommendation' => 'nullable|boolean',
            'type_of_user_id' => 'required|exists:type_of_users,id'
        ]);

        $response = User::store(
            $request->user_name,
            !empty($request->user_surnames) ? $request->user_surnames : null,
            $request->user_email,
            !empty($request->user_profile_picture) ? $request->user_profile_picture : null,
            $request->user_receive_notifications,
            $request->user_receive_recommendation,
            $request->type_of_user_id
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
        $title = 'Show user';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $user = User::where('id', $id)->first();

        if($user!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = User::with('type_of_user_id')->get()->find($id);
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
        $title = 'Update user';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'user_name' => 'required|string',
            'user_surnames' => 'nullable|string',
            'user_email' => 'required|string',
            'user_profile_picture' => 'nullable|string',
            'user_receive_notifications' => 'nullable|boolean',
            'user_receive_recommendation' => 'nullable|boolean',
            'type_of_user_id' => 'required|exists:type_of_users,id'
        ]);

        $user = User::where('id', $id)->first();

        if(empty($user)) {
            $msg = 'User cannot be null';
        } else {
            $response = User::updateModel(
                $request->user_name,
                !empty($request->user_surnames) ? $request->user_surnames : null,
                $request->user_email,
                !empty($request->user_profile_picture) ? $request->user_profile_picture : null,
                $request->user_receive_notifications,
                $request->user_receive_recommendation,
                $request->type_of_user_id,
                $user
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
        $title = 'Destroy user';
        $code = 200;

        $user = User::find($id);

        // if not exists
        if (!isset($user)) {
            $msg = 'Task cannot be null';
        } else {
            $user->delete();
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
        $title = 'Select2 user';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = User::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && User::exists()) {
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
