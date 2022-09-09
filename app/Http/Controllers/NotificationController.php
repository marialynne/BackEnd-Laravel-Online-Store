<?php

namespace App\Http\Controllers;

use App\Notification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class NotificationController extends Controller
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
        $title = 'Index notifications';
        $msg = 'Index failed!';
        $data = [];
        $code = 200;

        $notifications = Notification::with('notification_type_id')->get();

        if(Notification::exists()) {
            $status = 1;
            $msg = 'Successful index!';
            $data = Datatables::of($notifications)->toJson();
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
        $tittle = 'Store notification';
        $msg = 'Store failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'notification_name' => 'required|string',
            'notification_description' => 'required|string',
            'notification_type_id' => 'required|exists:notification_types,id'
        ]);

        $response = Notification::store(
            $request->notification_name,
            $request->notification_description,
            $request->notification_type_id
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
        $title = 'Show notification';
        $msg = 'Show failed!';
        $data = [];
        $code = 200;

        $notification = Notification::where('id', $id)->first();

        if($notification!=null) {
            $status = 1;
            $msg = 'Successful Show!';
            $data = Notification::with(['notification_type_id'])->get()->find($id);
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
        $title = 'Update notification';
        $msg = 'Update failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'notification_name' => 'required|string',
            'notification_description' => 'required|string',
            'notification_type_id' => 'required|exists:notification_types,id'
        ]);

        $brand = Notification::where('id', $id)->first();

        if(empty($brand)) {
            $msg = 'Notification cannot be null';
        } else {
            $response = Notification::updateModel(
                $request->notification_name,
                $request->notification_description,
                $request->notification_type_id,
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
     * Remove the specified resource from storage.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $status = 0;
        $title = 'Destroy notification';
        $code = 200;

        $brand = Notification::find($id);

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
        $title = 'Select2 notification';
        $msg = 'Select2 failed!';
        $data = [];
        $code = 200;

        $request->validate([
            'page' => 'required|integer',
            'search' => 'nullable|string'
        ]);

        $response = Notification::select2(
            $request->page,
            !empty($request->search) ? $request->search : ''
        );

        if (!empty($response) && Notification::exists()) {
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
