<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerInsertRequest;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index(): JsonResponse
    {
        // Default load all bersama dengan addressnya
        try {
            //code...
            $data = Customer::with(['address'])->get();

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 500, 'message' => 'Failed when retrieving data' ], 500);
        }
    }

    public function detail($id): JsonResponse
    {
        // Sepertinya tidak masalah jika id tidak ada, karena hanya return empty data
        // UPDATE: Pakai middleware saja
        try {
            //code...
            $data = Customer::with(['address'])->find($id);

            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 500, 'message' => 'Failed when retrieving data' ], 500);
        }
    }

    public function create(CustomerInsertRequest $request): JsonResponse
    {
        // Hanya data customer valid saja yang boleh terinsert
        $create = Customer::create($request->validated());

        // Gagal insert
        if(!$create) {
            return response()->json(['status' => 500, 'message' => 'Failed to create new customer, check your request'], 500);
        }

        return response()->json(['status' => 200, 'message' => 'Successfully create new customer']);
    }

    // Karena requestnya sama, hanya nambah id
    public function update(CustomerInsertRequest $request, $id): JsonResponse
    {
        $update = Customer::where('id', $id)->update($request->validated());

        // Gagal update
        if(!$update) {
            return response()->json(['status' => 500, 'message' => 'Failed to update existing customer, check your request'], 500);
        }

        return response()->json(['status' => 200, 'message' => 'Successfully update existing customer']);
    }

    public function destroy($id): JsonResponse
    {
        // Sepertinya perlu cek dulu addressnya
        if(Address::where('customer_id', $id)->exists()) {
            return response()->json(['status' => 403, 'message' => 'Your request cannot be processed due to existing data being used somewhere'], 403);
        }

        $destroy = Customer::destroy($id);

        // Gagal Destroy
        if(!$destroy) {
            return response()->json(['status' => 500, 'message' => 'Failed to delete existing customer, check your request'], 500);
        }

        return response()->json(['status' => 200, 'message' => 'Successfully delete existing customer']);
    }
}
