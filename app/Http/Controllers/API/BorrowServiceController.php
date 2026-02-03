<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class BorrowServiceController extends Controller
{
    private $book;

    private $user;

    private $borrow;

    public function __construct(
        Book $book,
        User $user,
        Borrow $borrow,

    ) {
        $this->book = $book;
        $this->user = $user;
        $this->borrow = $borrow;
    }

    public function index(Request $request)
    {
        $user = $request->user()->load('role');
        if ($user->role[0]->role_name == 'admin') {
            $borrows = $this->borrow->with('user', 'book')->get();

            return response([
                'data' => $borrows,
                'message' => 'data Found!',
            ], 201);
            
            return response([
                'message' => 'Only Admin Access!',
            ], 401);

            $books = Book::all();
            $users = User::whereHas('role', function ($query) {
                $query->where('role_name', '=', 'member');
            })->get();
            $borrows = Borrow::with('user', 'book')->get();

            return view('borrow.index', compact('books', 'users', 'borrows'));
        }
    }
}
