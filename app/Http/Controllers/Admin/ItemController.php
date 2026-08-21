<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('category')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $items = $query->paginate(15);
        return view('admin.items', compact('items'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.item-form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['available_stock'] = $data['stock'];
        $data['status'] = $data['stock'] > 0 ? 'available' : 'unavailable';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        Item::create($data);

        return redirect()->route('admin.items.index')
            ->with('success', __('messages.item_created'));
    }

    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.item-form', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $data = $this->validated($request, $item);

        $borrowed = max(0, $item->stock - $item->available_stock);
        if ($data['stock'] < $borrowed) {
            return back()->withInput()->withErrors([
                'stock' => "Stok tidak boleh lebih kecil dari jumlah yang sedang dipinjam ({$borrowed}).",
            ]);
        }

        $data['available_stock'] = $data['stock'] - $borrowed;
        $data['status'] = $data['available_stock'] > 0 ? 'available' : 'unavailable';

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($data);

        return redirect()->route('admin.items.index')
            ->with('success', __('messages.item_updated'));
    }

    public function destroy(Item $item)
    {
        if ($item->loanDetails()->exists()) {
            return back()->with('error', __('messages.item_has_loans'));
        }

        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return back()->with('success', __('messages.item_deleted'));
    }

    private function validated(Request $request, ?Item $item = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'code' => ['required', 'string', 'max:50', Rule::unique('items', 'code')->ignore($item?->id)],
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'condition' => ['required', Rule::in(['baik', 'rusak_ringan', 'rusak_berat'])],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
