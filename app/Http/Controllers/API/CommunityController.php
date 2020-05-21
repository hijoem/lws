<?php

namespace App\Http\Controllers;

use App\Community;
use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Suppocommunity\Facades\Auth;
use Illuminate\Suppocommunity\Facades\Validator;

class CommunityController extends Controller
{
    public function all()
    {
        $posts = Community::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Community',
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
        $check = Community::where('user_id', $request->user()->id)->first();
        if(!$check){
            $community = Community::create($input);
            $detail = UserDetail::where('user_id', $request->user()->id)->update([
                'community' => $community->id,
            ]);
            return response()->json([
                'success' => true], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You only can make 1 Community!',
            ], 500);
        }
    }

    public function show(Request $request) {
        $community = Community::where('user_id', $request->user()->id)->first();
        if ($community) {
            return response()->json($community, 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You have not join Community yet!',
            ], 500);
        }
    }

    public function view($id) {
        $community = Community::whereId($id, 1)->first();
        if ($community) {
            return response()->json($community, 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Community not found',
            ], 500);
        }
    }

    public function join($id) {
        $user = Auth::user();
        $community = UserDetail::where('user_id', $user->id)->first();
        if (!$community) {
            $update = UserDetail::where('user_id', $request->user()->id)->update([
                'community' => $id,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'You have join Community!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'You already joined another Community!',
            ], 500);
        }
    }

    public function updateDetails(Request $request)
    {
        $detail = Community::where('user_id', $request->user()->id)->update([
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
        $open = Community::whereId($id, 1)->update([
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
        $tujuan_upload = 'image/community';
        $file->move($tujuan_upload,$nama_file);
        $detail = Community::where('user_id', $request->user()->id)->update([
            'url_img' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }
}
