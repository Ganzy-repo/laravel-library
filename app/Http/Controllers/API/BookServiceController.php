<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookServiceController extends Controller
{
    private $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function index(Request $request)
    {

    if(isset($request->search)){
        $data  = $this->book->search($request->search);

        return response([
            'message' => count($data) > 0 ?'list book found!' : 'list book not found',
            'data' => $data,
        ], count($data) > 0 ? 200 : 404);

        return response([
            'message' => 'list book found!',
            'data' => $this->book->withCategory(),
        ]);
        
    }
        // // Get query parameters
        // $search = $request->query('search');
        // $categoryId = $request->query('category');
        // $year = $request->query('year');
        
        // // Start with base query
        // $query = $this->book->join('categories', 'books.category_id', '=', 'categories.id')
        //     ->select(
        //         'books.id',
        //         'books.category_id',
        //         'categories.category_name',
        //         'books.title',
        //         'books.author',
        //         'books.qty',
        //         'books.year',
        //         'books.cover'
        //     );

        // // Apply search filter if exists
        // if ($search) {
        //     $query->where(function ($q) use ($search) {
        //         $q->where('books.title', 'like', "%{$search}%")
        //           ->orWhere('books.author', 'like', "%{$search}%")
        //           ->orWhere('categories.category_name', 'like', "%{$search}%");
        //     })->get();
        // }

        // // Apply category filter if exists
        // if ($categoryId) {
        //     $query->where('books.category_id', $categoryId);
        // }

        // // Apply year filter if exists
        // if ($year) {
        //     $query->where('books.year', $year);
        // }

        // // Get results
        // $books = $query->get();

        // return response([
        //     'message' => $search ? 'Search results found!' : 'list book found!',
        //     'search_term' => $search,
        //     'category_filter' => $categoryId,
        //     'year_filter' => $year,
        //     'data' => $books
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|int|exists:categories,id',
            'title' => 'required|string|min:4|max:255',
            'author' => 'required|string|min:4|max:255',
            'qty' => 'required|int',
            'year' => 'required|digits:4',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp',
        ]);

        $filename = '';

        if ($request->file('cover')) {
            // $filename = Carbon::now().'.'.$request->file('cover')->extension();
            // $request->file('cover')->storeAs('upload', $filename, 'public');
            $filename = now()->format('Ymd_His').'.'.$request->file('cover')->extension();
            $request->file('cover')->move(public_path('/storage/upload'), $filename);
        }

        $this->book->create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author' => $request->author,
            'qty' => $request->qty,
            'year' => $request->year,
            'cover' => $request->file('cover') ? url('storage/upload/'.$filename) : null,
        ]);

        return response([
            'message' => 'book has been created!',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->book->withCategory()->find($id);

        if (! $data) {
            return response([
                'message' => 'list book not found!',
                'data' => $data,
            ], 404);

        }

        return response([
            'message' => 'book found!',
            'data' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $this->book->find($id);

        if (! $data) {
            return response([
                'message' => 'book not found!',
            ], 404);
        }

        $request->validate([
            'category_id' => 'required|int|exists:categories,id',
            'title' => 'required|string|min:4|max:255|unique:books,title,'.$id,
            'author' => 'required|string|min:4|max:255',
            'qty' => 'required|int',
            'year' => 'required|digits:4',
        ]);

        $data->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author' => $request->author,
            'qty' => $request->qty,
            'year' => $request->year,
        ]);

        return response([
            'message' => 'book has been updated!',
            'data' => $data->withCategory()->find($id),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = $this->book->find($id);

        if (! $data) {
            return response([
                'message' => 'book not found!',
            ], 404);
        }

        $data->delete();

        return response([
            'message' => 'book has been deleted!',
        ]);
    }
}
