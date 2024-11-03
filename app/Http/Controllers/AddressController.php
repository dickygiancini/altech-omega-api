<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressInsertRequest;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function create(AddressInsertRequest $request): JsonResponse
    {
        // Hanya data address valid saja yang boleh terinsert
        $create = Address::create($request->validated());

        // Gagal insert
        if(!$create) {
            return response()->json(['status' => 500, 'message' => 'Failed to add new address, check your request'], 500);
        }

        return response()->json(['status' => 200, 'message' => 'Successfully added new address']);
    }

    // Request kurleb sama, hanya nambah id
    public function update(AddressInsertRequest $request, $id): JsonResponse
    {
        $update = Address::where('id', $id)->update($request->validated());

        // Gagal update
        if(!$update) {
            return response()->json(['status' => 500, 'message' => 'Failed to update address, check your request'], 500);
        }

        return response()->json(['status' => 200, 'message' => 'Successfully update existing address']);
    }

    public function destroy($id): JsonResponse
    {
        $destroy = Address::destroy($id);

        // Gagal Destroy
        if(!$destroy) {
            return response()->json(['status' => 500, 'message' => 'Failed to delete existing address, check your request'], 500);
        }

        return response()->json(['status' => 200, 'message' => 'Successfully delete existing address']);
    }
}
