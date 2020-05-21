<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Shop;
use App\UserDetail;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'lang' => 'required',
            'lat' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $check = Shop::where('user_id', $request->user()->id)->first();
        if(!$check){
            $shop = Shop::create($input);
            $detail = UserDetail::where('user_id', $request->user()->id)->update([
                'shop' => $shop->id,
            ]);
            return response()->json([
                'success' => true], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You only can make 1 shop!',
            ], 500);
        }
    }

    public function show(Request $request) {
        $shop = Shop::where('user_id', $request->user()->id)->first();
        if ($shop) {
            return response()->json($shop, 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You have not open a store yet!',
            ], 500);
        }
    }

    public function updateDetails(Request $request)
    {
        $detail = Shop::where('user_id', $request->user()->id)->update([
            'name'     => $request->input('name'),
            'jenis'    => $request->input('jenis'),
            'detail'    => $request->input('detail'),
            'lang'   => $request->input('lang'),
            'lat'  => $request->input('lat'),
            'status' => $request->input('status'),
            'opr_hour' => $request->input('opr_hour'),
        ]);
        if ($detail) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal!',
            ], 500);
        }
    }

    public function activate($id)
    {
        $open = Shop::whereId($id, 1)->update([
            'is_active'     => $request->is_active,
        ]);
        if ($open) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal!',
            ], 500);
        }
    }

    public function open(Request $request)
    {
        $open = Shop::where('user_id', $request->user()->id)->update([
            'is_open'     => $request->is_open,
        ]);
        if ($open) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal!',
            ], 500);
        }
    }

    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_img_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/shop';
        $file->move($tujuan_upload,$nama_file);
        $detail = Shop::where('user_id', $request->user()->id)->update([
            'url_img' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }
}
