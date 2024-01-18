<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    /**
     * @method get()
     * @desc get all books
     * @return array[object]
     */
    public function get() {
        try {
            $data = Books::with(['write' => function($query) {
                $query->select('id', 'name');
            }])->get();
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
     * @desc get an books with id
     * @param int $id
     * @return object
     */
    public function getOne($id) {
        try {
            $data = Books::with(['write' => function($query) {
                $query->select('id', 'name');
            }])->findOrFail($id);
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
     * @desc create a books
     * @param Request $request -> variable which carry the body
     * @return object
     */
    public function create(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'writer_id' => 'required|exists:writer,id',
                'description' => 'string|min:20|max:2000',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = time() . '_' . $imageFile->getClientOriginalName();
                $imagePath = $imageFile->storeAs('book_images', $imageName, 'public');
            }

            $data = Books::create([
                'name' => $request->input('name'),
                'writer_id' => $request->input('writer_id'),
                'description' => $request->input('description'),
                'image' => $imagePath,
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
     * @desc update a books with it's id
     * @param Request $request -> variable which carry the body
     * @param int $id
     * @return object
     */
    public function update(Request $request, $id) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'writer_id' => 'required|exists:writer,id',
                'description' => 'string|min:20|max:2000',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = Books::findOrFail($id);

            $imagePath = null;

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = time() . '_' . $imageFile->getClientOriginalName();
                $imagePath = $imageFile->storeAs('book_images', $imageName, 'public');
            } else {
                $imagePath = $data->image;
            }

            $data->update([
                'name' => $request->input('name'),
                'writer_id' => $request->input('writer_id'),
                'description' => $request->input('description'),
                'image' => $imagePath,
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
     * @desc delete a books with id
     * @param int $id
     * @return void
     */
    public function delete($id) {
        try {
            $data = Books::findOrFail($id)->delete();
            return response()->json($data, 204);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
