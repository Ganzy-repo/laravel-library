<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryServiceController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return response([
            'message' => 'List categories found!',
            'data' => $this->category->all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|min:3|max:255|unique:categories,category_name',
        ]);

        $this->category->create([
            'category_name' => $request->category_name,
        ]);

        return response([
            'message' => 'Category has been created!',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->category->find($id);

        if (!$data) {
            return response([
                'message' => 'Category not found!',
                'data' => $data,
            ], 404);
        }

        return response([
            'message' => 'Category found!',
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->category->find($id);

        if (!$data) {
            return response([
                'message' => 'Category not found!',
            ], 404);
        }

        $request->validate([
            'category_name' => 'required|string|min:3|max:255|unique:categories,category_name,' . $id,
        ]);

        $data->update([
            'category_name' => $request->category_name,
        ]);

        return response([
            'message' => 'Category has been updated!',
            'data' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->category->find($id);

        if (!$data) {
            return response([
                'message' => 'Category not found!',
            ], 404);
        }

        $data->delete();

        return response([
            'message' => 'Category has been deleted!',
        ]);
    }
}