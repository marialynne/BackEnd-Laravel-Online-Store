<?php

namespace App\Http\Controllers;

use App\Notification_type;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class NotificationTypeController extends Controller
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
        $title = 'Index notification types';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $notification_type = Notification_type::all();

        if(Notification_type::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($notification_type)->toJson();
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
        $tittle = 'Store notification type';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'notification_type_name' => 'required|string',
        ]);

        $response = Notification_type::store(
            $request->notification_type_name
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
        $title = 'Show notification type';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $notification_type = Notification_type::where('id', $id)->first();

        if($notification_type!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Notification_type::find($id);
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
        $title = 'Update notification type';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'notification_type_name' => 'required|string'
        ]);

        $notification_type = Notification_type::where('id', $id)->first();

        if(empty($notification_type)) {
            $msg = 'Notification type cannot be null';
        } else {
            $response = notification_type::updateModel(
                $request->notification_type_name,
                $notification_type
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
        $title = 'Destroy notification type';
        $code = 200;

        $notification_type = Notification_type::find($id);

        // if not exists
        if (!isset($notification_type)) {
            $msg = 'Task cannot be null';
        } else {
            $notification_type->delete();
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
        $title = 'Select2 notification type';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);


        $response = Notification_type::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Notification_type::exists()) {
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
