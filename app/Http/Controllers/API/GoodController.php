<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class GoodController extends Controller
{
	private $goods_path;

	public function __construct()
	{
		$this->goods_path = public_path('/images/goods');
		$this->makeDirectories();
	}

	public function index()
	{
		$goods = Good::all();
		return response()->json([
			'error' => false,
			'goods' => $goods
		], 200);
	}

	public function show($good)
	{
		$good = Good::find($good);
		return response()->json([
			'error' => false,
			'good' => $good
		], 200);
	}


	public function store(Request $request)
	{
		$name = $request->get('name');
		$type_id = $request->get('type_id');
		$room_id = $request->get('room_id');
		$property_number = $request->get('property_number');
		$kind = $request->get('kind');
		$old_property_number = $request->get('old_property_number');
		$old_kind = $request->get('old_kind');
		$description = $request->get('description');
		$model = $request->get('model');
		$serial = $request->get('serial');
		$barcode = $request->get('barcode');
		$status = $request->get('status');
		$unit = $request->get('unit');

		$good = new Good();
		$good->name = $name;
		$good->type_id = $type_id;
		$good->room_id = $room_id;
		$good->property_number = $property_number;
		$good->kind = $kind;
		$good->old_property_number = $old_property_number;
		$good->old_kind = $old_kind;
		$good->description = $description;
		$good->model = $model;
		$good->serial = $serial;
		$good->barcode = $barcode;
		$good->status = $status;
		$good->unit = $unit;
		$good->save();

		if (Input::hasFile('image')) {
			$image = $request->file('image');
			$input['imagename'] = 'G_' . $good->id . '.' . $image->getClientOriginalExtension();
			$image->move($this->goods_path, $input['imagename']);
			$good->picture = $input['imagename'];
			$good->save();
		}

		if ($good)
			return response()->json([
				'error' => false

			], 200);
		else
			return response()->json([
				'error' => true,
				'error_msg' => 'خطا بوجود آمده است'
			], 200);
	}

	public function update(Request $request, $good)
	{
		$good = Good::find($good);
		$good->update($request->all());

		return response()->json([
			'error' => false
		], 200);
	}

	public function destroy($good)
	{
		$good = Good::find($good);
		$good->delete();

		return response()->json([
			'error' => false
		], 200);
	}

	private function makeDirectories()
	{
		if (!is_dir($this->goods_path))
			mkdir($this->goods_path, 0777, true);
		chmod($this->goods_path, 0777);
	}
}
