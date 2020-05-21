<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function all()
    {
        $posts = Product::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Products',
            'data' => $posts
        ], 200);
    }

    public function index(Request $request)
    {
        $shop = Shop::where('user_id', $request->user()->id)->first();
        $product = Product::where('shop_id', $shop->id)->get();
        return response([
            'success' => true,
            'total' => count($product),
            'message' => 'List Product dari '.$shop->name,
            'data' => $product
        ], 200);
    }

    public function create(Request $request)
    {
        $shop = Shop::where('user_id', $request->user()->id)->first();
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'detail'   => 'required',
            'price'   => 'required',
        ],
            [
                'name.required' => 'Tidak boleh kosong!',
                'detail.required' => 'Tidak boleh kosong!',
                'price.required' => 'Tidak boleh kosong!',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {

            $product = Product::create([
                'shop_id'   => $shop->id,
                'name'     => $request->input('name'),
                'detail'   => $request->input('detail'),
                'price'   => $request->input('price'),
                'quantity'   => $request->input('quantity'),
                'discount'   => $request->input('discount')
            ]);


            if ($product) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product Berhasil Disimpan!',
                    'data' => Product::latest()->first()
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product Gagal Disimpan!',
                ], 400);
            }
        }
    }

    public function publish($id)
    {
        $open = Product::whereid( $id, 1)->update([
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
        $product = Product::whereId($id)->first();

        if ($product) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Product!',
                'data'    => $product
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'detail'   => 'required',
            'price'   => 'required',
        ],
            [
                'name.required' => 'Tidak boleh kosong!',
                'detail.required' => 'Tidak boleh kosong!',
                'price.required' => 'Tidak boleh kosong!',
            ]
        );
        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],400);

        } else {
            $post = Product::whereId($request->input('id'))->update([
                'name'     => $request->input('name'),
                'detail'   => $request->input('detail'),
                'price'   => $request->input('price'),
                'quantity'   => $request->input('quantity'),
                'discount'   => $request->input('discount')
            ]);
            if ($post) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product Berhasil Diupdate!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product Gagal Diupdate!',
                ], 500);
            }
        }
    }

    public function destroy($id)
    {
        $post = Product::findOrFail($id);
        $post->delete();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Product Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Gagal Dihapus!',
            ], 500);
        }
    }

    public function upload1(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/product';
        $file->move($tujuan_upload,$nama_file);
        $img = Product::whereId($id, 1)->update([
            'url_img1' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }

    public function upload2(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/product';
        $file->move($tujuan_upload,$nama_file);
        $img = Product::whereId($id, 1)->update([
            'url_img2' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }

    public function upload3(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $file = $request->file('file');
        $nama_file = substr($request->user()->email,0,(stripos($request->user()->email, "@")))."_".time().".".$file->getClientOriginalExtension();
        $tujuan_upload = 'image/product';
        $file->move($tujuan_upload,$nama_file);
        $img = Product::whereId($id, 1)->update([
            'url_img3' => $_ENV['APP_URL'].$tujuan_upload."/".$nama_file,
        ]);
        return redirect()->back();
    }
}
