<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        // secara default dibatasi 6, tapi bisa diubah dengan memanggil limit tsb
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $types = $request->input('types');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        $rate_from = $request->input('rate_from');
        $rate_to = $request->input('rate_to');

        if ($id) {
            $food = Food::find($id);

            if ($food) {
                return ResponseFormatter::success(
                    $food,
                    'Data produk berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                );
            }
        }

        $food = Food::query();

        if ($name) {
            $food->where('name', 'like', '%' . $name . '%');
        }
        if ($types) {
            $food->where('types', 'like', '%' . $types . '%');
        }
        if ($price_from) {
            $food->where('types', '>=', $price_from);
        }
        if ($price_to) {
            $food->where('types', '<=', $price_to);
        }
        if ($rate_from) {
            $food->where('types', '>=', $rate_from);
        }
        if ($rate_to) {
            $food->where('types', '<=', $rate_to);
        }

        return ResponseFormatter::success(
            $food->paginate($limit),
            'Data list produk berhasi diambil'
        );
    }
}
