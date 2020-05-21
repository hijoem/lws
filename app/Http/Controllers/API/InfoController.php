<?php

namespace App\Http\Controllers\API;

use App\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfoController extends Controller
{
    public function all()
    {
        $posts = Info::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Info',
            'data' => $posts
        ], 200);
    }

    public function index(Request $request)
    {
        $product = Info::where('user_id', $request->user()->id)->get();
        return response([
            'success' => true,
            'total' => count($product),
            'message' => 'List Product dari '.$shop->name,
            'data' => $product
        ], 200);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'detail'   => 'required',
        ],
            [
                'name.required' => 'Masukkan name!',
                'detail.required' => 'Masukkan detail!',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {
            $input = $request->all();
            $input['user_id'] = $request->user()->id;
            $info = Info::create($input);
            if ($info) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Disimpan!',
                    'data' => Info::latest()->first()
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function publish($id)
    {
        $open = Info::whereid( $id, 1)->update([
            'is_published'     => $request->is_published,
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


    public function show($id)
    {
        $info = Info::whereId($id)->first();
        if ($info) {
            return response()->json([
                'success' => true,
                'message' => 'Detail!',
                'data'    => $info
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Info Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function update(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'detail'   => 'required',
        ],
            [
                'name.required' => 'Masukkan name!',
                'detail.required' => 'Masukkan detail!',
            ]
        );
        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);
        } else {
            $post = Info::whereId($request->input('id'))->update([
                'name'     => $request->input('name'),
                'detail'   => $request->input('detail'),
                'cat_info'   => $request->input('cat_info'),
            ]);
            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Diupdate!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal Diupdate!',
                ], 500);
            }
        }

    }

    public function destroy($id)
    {
        $post = Info::findOrFail($id);
        $post->delete();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Dihapus!',
            ], 500);
        }
    }

    public function uploadFile(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:pdf,docx,xlsx|max:5048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_file_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/info';
        $file->move($tujuan_upload,$nama_file);
        $detail = Info::where('user_id', $request->user()->id)->update([
            'url_file' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }

    public function uploadImage1(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_img_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/info';
        $file->move($tujuan_upload,$nama_file);
        $detail = Info::where('user_id', $request->user()->id)->update([
            'url_img1' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }

    public function uploadImage2(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_img_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/info';
        $file->move($tujuan_upload,$nama_file);
        $detail = Info::where('user_id', $request->user()->id)->update([
            'url_img2' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }

    public function uploadImage3(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_img_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/info';
        $file->move($tujuan_upload,$nama_file);
        $detail = Info::where('user_id', $request->user()->id)->update([
            'url_img3' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }
}
