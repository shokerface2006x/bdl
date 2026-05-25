<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Список всех товаров
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // Форма создания
    public function create()
    {
        return view('admin.products.create');
    }

    // Сохранение нового товара
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'title' => $request->title,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $path,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Товар добавлен в дроп!');
    }

    // Удаление товара
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Товар удален из каталога');
    }
}
