<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * @method get()
     * @desc get all articles
     * @return array[object]
     */
    public function get() {
        try {
            $data = Articles::get();
            return response()->json($data, 200);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }

     /**
     * @method getOne()
     * @desc get an article with id
     * @param int $id
     * @return object
     */
    public function getOne($id) {
        try {
            $data = Articles::findOrFail($id);
            return response()->json($data, 200);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @method create()
     * @desc create an article
     * @param Request $request -> variable which carry the body
     * @return object
     */
    public function create(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'wordcount' => 'required|integer',
                'status' => 'required|string|in:pending,published',
            ]);

            $data = Articles::create([
                'name' => $request->input('name'),
                'wordcount' => $request->input('wordcount'),
                'status' => $request->input('status'),
            ]);

            return response()->json($data, 201);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @method update()
     * @desc update an article with it's id
     * @param Request $request -> variable which carry the body
     * @param int $id
     * @return object
     */
    public function update(Request $request, $id) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'wordcount' => 'required|integer',
                'status' => 'required|string|in:pending,published',
            ]);

            $data = Articles::findOrFail($id);

            $data->update([
                'name' => $request->input('name'),
                'wordcount' => $request->input('wordcount'),
                'status' => $request->input('status'),
            ]);

            return response()->json($data, 200);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @method delete()
     * @desc delete an article with id
     * @param int $id
     * @return void
     */
    public function delete($id) {
        try {
            $data = Articles::findOrFail($id)->delete();
            return response()->json($data, 204);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }

}
