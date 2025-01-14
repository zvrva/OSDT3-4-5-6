<?php

namespace App\Http\Controllers;

use App\Models\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; 



class BookController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему.');
        }

        $books = auth()->user()->books()->whereNull('deleted_at')->paginate(10);

        $trashedBooks = auth()->user()->books()->onlyTrashed()->get();

        return view('books.index', compact('books', 'trashedBooks'));
    }


    // public function showBooks(Request $request, string $name) 
    // {
    //     $user = User::where('name', $name)->first();
    //     if (!$user) {
    //         abort(404); 
    //     }
    //     $books = $user->books; 

    //     if (Gate::denies('viewBooksForUser', $user)) {
    //         abort(403, 'Unauthorized'); 
    //     }

    //     return view('books', compact('books', 'user'));
    // }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('books.create', []);
        return view('books.create');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id); 
        return view('books.show', compact('book')); 
    }

    // public function showUserBooks($name)
    // {
    //     $user = User::where('name', $name)->firstOrFail();

    //     $books = $user->books;

    //     return view('books.show', compact('user', 'books'));
    // }

    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'author' => 'required|string|max:255',
            'book_title' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1000|max:2024', //Improved validation
            // 'information' => 'nullable|string',
            // 'additional_information' => 'nullable|string',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'information' => 'required|string',
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'additional_information' => 'nullable|string',
        ]);

        
        $imagePath = null;
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $fileName = time() . '.' . $image->getClientOriginalExtension(); 
            $filePath = public_path('img/' . $fileName); 
            $image->move(public_path('img'), $fileName);
            $imagePath = 'img/' . $fileName; 
        }

        $book = new Book();
        $book->fill($validatedData);
        $book->user_id = auth()->id(); 
        $book->cover_photo = $imagePath; 
        $book->save();

        return redirect()->route('books.index')
                        ->with('message', 'Книга успешно создана!');
    }
    // public function store(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'author' => 'required|string|max:255',
    //         'book_title' => 'required|string|max:255',
    //         'publication_year' => 'required|integer|min:1000|max:2024', //Improved validation
    //         // 'information' => 'nullable|string',
    //         // 'additional_information' => 'nullable|string',
    //         // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
    //         'information' => 'required|string',
    //         'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
    //         'additional_information' => 'nullable|string',
    //     ]);

        
    //     $imagePath = null;
    //     if ($request->hasFile('cover_photo')) {
    //         $image = $request->file('cover_photo');
    //         $fileName = time() . '.' . $image->getClientOriginalExtension(); 
    //         $filePath = public_path('img/' . $fileName); 
    //         $image->move(public_path('img'), $fileName);
    //         $imagePath = 'img/' . $fileName; 
    //     }

    //     $book = Book::create([
    //         'author' => $request->input('author'),
    //         'book_title' => $request->input('book_title'),
    //         'publication_year' => $request->input('publication_year'),
    //         'information' => $request->input('information'),
    //         'cover_photo' => $imagePath, 
    //         // 'cover_photo' => 'img/6.jpg',
    //         'additional_information' => $request->input('additional_information'),
    //         'user_id' => auth()->id(), 
    //     ]);

    //     if ($book) {
    //         return redirect()->route('books.index')->with('success', 'Книга добавлена!');
    //     } else {
    //         return back()->withErrors(['error' => 'Ошибка создания книги. Пожалуйста, попробуйте еще раз.']);
    //     }
    // }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        if ($book->user_id != auth()->id()) {
            abort(403, 'Доступ запрещен.');
        }
        // $book = Book::findOrFail($id); 
        return view('books.edit', compact('book')); 
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function update(Request $request, Book $book)
     {
         if ($book->user_id != auth()->id()) {
             abort(403, 'Доступ запрещен.');
         }
     
         $validatedData = $request->validate([
             'author' => 'required|string|max:255',
             'book_title' => 'required|string|max:255',
             'publication_year' => 'required|integer|min:1000|max:2024', 
             'information' => 'required|string',
             'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
             'additional_information' => 'nullable|string',
         ]);
     
         $imagePath = $book->cover_photo; 
         if ($request->hasFile('cover_photo')) {
             $image = $request->file('cover_photo');
             $fileName = time() . '.' . $image->getClientOriginalExtension(); 
             $filePath = public_path('img/' . $fileName); 
             $image->move(public_path('img'), $fileName);
             $imagePath = 'img/' . $fileName; 
         }
     
         $book->update([
             'author' => $request->input('author'),
             'book_title' => $request->input('book_title'),
             'publication_year' => $request->input('publication_year'),
             'information' => $request->input('information'),
             'cover_photo' => $imagePath, 
             'additional_information' => $request->input('additional_information'),
         ]);
     
         if ($book) {
             return redirect()->route('books.index')->with('success', 'Книга обновлена!');
         } else {
             return back()->withErrors(['error' => 'Ошибка обновления книги. Пожалуйста, попробуйте еще раз.']);
         }
     }
    // public function update(Request $request,Book $book)
    // {
    //     if ($book->user_id != auth()->id()) {
    //         abort(403, 'Доступ запрещен.');
    //     }
    //     $request->validate([
    //         'author' => 'required|string|max:255',
    //         'book_title' => 'required|string|max:255',
    //         'publication_year' => 'required|integer|min:1000|max:2024', 
    //         // 'information' => 'nullable|string',
    //         // 'additional_information' => 'nullable|string',
    //         // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
    //         'information' => 'required|string',
    //         'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
    //         'additional_information' => 'nullable|string',
    //     ]);

    //     $book = Book::findOrFail($id);
    //     $path = $book->cover_photo;

    //     if ($request->hasFile('cover_photo')) {
    //         // if ($book->image_path) {
    //         //     Storage::disk('public')->delete(str_replace('/img/', '', $book->image_path));
    //         // }

    //         $image = $request->file('cover_photo');
    //         $fileName = time() . '.' . $image->getClientOriginalExtension(); 
    //         $filePath = public_path('img/' . $fileName);
    //         $image->move(public_path('img'), $fileName);
    //         $path = 'img/' . $fileName; 
    //     }

    //     $book->update([
    //         'author' => $request->input('author'),
    //         'book_title' => $request->input('book_title'),
    //         'publication_year' => $request->input('publication_year'),
    //         'information' => $request->input('information'),
    //         'cover_photo' => $path,
    //         'additional_information' => $request->input('additional_information'),
    //     ]);

    //     return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        if ($book->user_id != auth()->id()) {
            abort(403, 'Доступ запрещен.');
        }

        // $book = Book::findOrFail($id);
 
        //  if ($book->image_path) {
        //      Storage::disk('public')->delete($book->image_path);
        //  }
 
         $book->delete();
 
         return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }



    // Метод для восстановления мягкой удаленной книги
    public function restore($id)
        {
            $book = Book::onlyTrashed()->findOrFail($id);

            if (!auth()->user()->is_admin) {
                abort(403, 'Доступ запрещён.');
            }

            $book->restore(); // Восстанавливает книгу, сбрасывая флаг deleted_at

            return redirect()->route('books.index')
                            ->with('message', 'Книга успешно восстановлена!');
        }
    // public function restore($id)
    // {
    //     $book = Book::onlyTrashed()->findOrFail($id);
        
    //     if (!Gate::allows('restore', $book)) {
    //         abort(403, 'Доступ запрещен.');
    //     }
        
    //     $book->restore();
        
    //     return redirect()->route('books.index')
    //                     ->with('message', 'Книга восстановлена!');
    // }


    public function forceDelete($id)
    {
        $book = Book::onlyTrashed()->findOrFail($id);

        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещён.');
        }

        $book->forceDelete(); // Полностью удаляет книгу из базы данных

        return redirect()->route('books.index')
                        ->with('message', 'Книга полностью удалена!');
    }
    // Метод для окончательного удаления книги
    // public function forceDelete($id)
    // {
    //     $book = Book::onlyTrashed()->findOrFail($id);
        
    //     if (!Gate::allows('forceDelete', $book)) {
    //         abort(403, 'Доступ запрещен.');
    //     }
        
    //     $book->forceDelete();
        
    //     return redirect()->route('books.index')
    //                     ->with('message', 'Книга окончательно удалена!');
    // }



    private function resizeImage($sourcePath, $destinationPath, $width, $height)
    {
        // Определяем тип изображения
        [$sourceWidth, $sourceHeight, $imageType] = getimagesize($sourcePath);

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        // Создаем пустое изображение с заданными размерами
        $resizedImage = imagecreatetruecolor($width, $height);

        // Обрезаем и изменяем размер
        imagecopyresampled(
            $resizedImage, $sourceImage,
            0, 0, 0, 0,
            $width, $height,
            $sourceWidth, $sourceHeight
        );

        // Сохраняем изображение в указанное место
        if (!is_dir(storage_path('app/public'))) {
            mkdir(storage_path('app/public'), 0755, true);
        }

        switch ($imageType) {
            case IMAGETYPE_JPEG:
                imagejpeg($resizedImage, storage_path('app/' . $destinationPath));
                break;
            case IMAGETYPE_PNG:
                imagepng($resizedImage, storage_path('app/' . $destinationPath));
                break;
            case IMAGETYPE_GIF:
                imagegif($resizedImage, storage_path('app/' . $destinationPath));
                break;
        }

        // Удаляем ресурсы
        imagedestroy($sourceImage);
        imagedestroy($resizedImage);
    }
}
