<?php

namespace App\Http\Controllers;

use App\Product;
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

    public function index()
    {
        $posts = Product::where('shop_id', 1)->get();
        return response([
            'success' => true,
            'message' => 'List Semua Products',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'shop_id'     => 'required',
            'detail'   => 'required',
            'price'   => 'required',
        ],
            [
                'name.required' => 'Tidak boleh kosong!',
                'shop_id.required' => 'Tidak boleh kosong!',
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

            $post = Product::create([
                'name'     => $request->input('name'),
                'detail'   => $request->input('detail'),
                'price'   => $request->input('price'),
                'shop_id'   => $request->input('shop_id'),
                'quantity'   => $request->input('quantity'),
                'discount'   => $request->input('discount'),
                'url_img1'   => $request->input('url_img1'),
                'url_img2'   => $request->input('url_img2'),
                'url_img3'   => $request->input('url_img3')
            ]);


            if ($post) {
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


    public function show($id)
    {
        $post = Product::whereId($id)->first();

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Product!',
                'data'    => $post
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
        //validate data
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'shop_id'     => 'required',
            'detail'   => 'required',
            'price'   => 'required',
        ],
            [
                'name.required' => 'Tidak boleh kosong!',
                'shop_id.required' => 'Tidak boleh kosong!',
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
                'shop_id'   => $request->input('shop_id'),
                'quantity'   => $request->input('quantity'),
                'discount'   => $request->input('discount'),
                'url_img1'   => $request->input('url_img1'),
                'url_img2'   => $request->input('url_img2'),
                'url_img3'   => $request->input('url_img3')
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
}
