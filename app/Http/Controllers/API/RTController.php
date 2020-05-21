<?php

namespace App\Http\Controllers\API;

use App\RT;
use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RTController extends Controller
{
    public function all()
    {
        $posts = RT::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua RT',
            'data' => $posts
        ], 200);
    }

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
        $check = RT::where('user_id', $request->user()->id)->first();
        if(!$check){
            $rt = RT::create($input);
            $detail = UserDetail::where('user_id', $request->user()->id)->update([
                'rt' => $rt->id,
            ]);
            return response()->json([
                'success' => true], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You only can make 1 RT!',
            ], 500);
        }
    }

    public function show(Request $request) {
        $rt = RT::where('user_id', $request->user()->id)->first();
        if ($rt) {
            return response()->json($rt, 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You have not join RT yet!',
            ], 500);
        }
    }

    public function view($id) {
        $rt = RT::whereId($id, 1)->first();
        if ($rt) {
            return response()->json($rt, 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'RT not found',
            ], 500);
        }
    }

    public function join($id) {
        $user = Auth::user();
        $rt = UserDetail::where('user_id', $user->id)->first();
        if (!$rt) {
            $update = UserDetail::where('user_id', $request->user()->id)->update([
                'rt' => $id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'You have join RT!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You already joined another RT!',
            ], 500);
        }
    }

    public function updateDetails(Request $request)
    {
        $detail = RT::where('user_id', $request->user()->id)->update([
            'name'     => $request->input('name'),
            'detail'    => $request->input('detail'),
            'lang'   => $request->input('lang'),
            'lat'  => $request->input('lat'),
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
        $open = RT::whereId($id,1)->update([
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

    public function uploadImage(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_img_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/rt';
        $file->move($tujuan_upload,$nama_file);
        $detail = RT::where('user_id', $request->user()->id)->update([
            'url_img' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }

    public function uploadSk(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_sk_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/rt';
        $file->move($tujuan_upload,$nama_file);
        $detail = RT::where('user_id', $request->user()->id)->update([
            'url_img' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }
}
