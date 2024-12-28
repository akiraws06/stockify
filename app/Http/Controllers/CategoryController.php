<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{
    function tampil(){
        $categories = Category::paginate(20); 
        return view('product.category.tampil', compact('categories')); 
    }

    function tambah(){
        return view('product.category.tambah');
    }
    public function submit(Request $request)
    {
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah membuat category ' . $request->name, 
        ]);

        $validatedData = Validator::make($request->all(),[
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);


        Category::create([
            'name' => $request->name,
            'desc' => $request->input('description'),

        ]);

        return redirect()->route('product.category.tampil')->with('success', 'Category created successfully.'); 
    }

    public function edit($id){
        $categories = Category::find($id);
        return view('product.category.edit', compact('categories'));
    }
    public function update(Request$request, $id){
        $categories = Category::find($id);
        $changes = []; // Array untuk menyimpan pesan aktivitas
        if ($categories->name != $request->name) {
            $changes['name'] = $request->name;
        }
        if ($categories->desc != $request->desc) {
            $changes['desc'] = $request->desc;
        }
        $categories->name = $request->name;
        $categories->desc = $request->desc;
        $categories->update();
       

        $categories->save();

        // Gabungkan pesan aktivitas
        if (!empty($changes)) {
            $changeText = 'User telah mengubah ' . implode(', ', array_keys($changes)) . ' pada category ' . strtolower($categories->name);
            UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => $changeText, 
            ]);
        }

        return redirect()->route('product.category.tampil');
    }

    public function delete($id)
{
    // Find the category by ID
    $categories = Category::find($id);

    if ($categories) {
        // Log the activity with the category name
        UserActivity::create([
            'user_id' => Auth::id(),
            'activity' => 'User telah melakukan menghapus data category: ' . $categories->name, 
        ]);

        // Delete the category
        $categories->delete();
    }

    // Redirect back to the category display page
    return redirect()->route('product.category.tampil');
}

    }
