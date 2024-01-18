<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    /**
     * @method get()
     * @desc get all witers
     * @return array[object]
     */
    public function get() {
        try {
            $data = Writer::with(['books' => function($query) {
                $query->select('id', 'writer_id', 'name');
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
     * @desc get an writer with id
     * @param int $id
     * @return object
     */
    public function getOne($id) {
        try {
            $data = Writer::with(['books' => function($query) {
                $query->select('id', 'writer_id', 'name');
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
     * @desc create a writer
     * @param Request $request -> variable which carry the body
     * @return object
     */
    public function create(Request $request) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'brief' => 'required|string|min:20|max:2000',
            ]);

            $data = Writer::create([
                'name' => $request->input('name'),
                'brief' => $request->input('brief'),
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
     * @desc update a writer with it's id
     * @param Request $request -> variable which carry the body
     * @param int $id
     * @return object
     */
    public function update(Request $request, $id) {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'brief' => 'required|string|min:20|max:2000',
            ]);

            $data = Writer::findOrFail($id);

            $data->update([
                'name' => $request->input('name'),
                'brief' => $request->input('brief'),
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
     * @desc delete a writer with id
     * @param int $id
     * @return void
     */
    public function delete($id) {
        try {
            $data = Writer::findOrFail($id)->delete();
            return response()->json($data, 204);

        } catch(\Exception $e) {
            return response()->json([
                "message" => "An unexpected error is occured",
                "error" => $e->getMessage()
            ], 500);
        }
    }
}
