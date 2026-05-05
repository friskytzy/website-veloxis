<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SparePart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SparePartController extends Controller
{
    public function index(Request $request): View
    {
        $spareParts = SparePart::query()
            ->when($request->query('search'), function ($query, string $search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('part_brand', 'like', "%{$search}%");
                });
            })
            ->when($request->query('status'), fn ($query, string $status) => $query->where('status', $status))
            ->orderBy('stock')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.spareparts.index', compact('spareParts'));
    }

    public function create(): View
    {
        return view('admin.spareparts.create', [
            'sparePart' => new SparePart(),
            'statuses' => $this->statuses(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['compatible_models'] = $this->linesToArray($validated['compatible_models']);
        $validated['specifications'] = $this->linesToArray($validated['specifications'] ?? '');
        $validated['is_featured'] = $request->boolean('is_featured');

        SparePart::create($validated);

        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil ditambahkan.');
    }

    public function edit(SparePart $sparePart): View
    {
        return view('admin.spareparts.edit', [
            'sparePart' => $sparePart,
            'statuses' => $this->statuses(),
        ]);
    }

    public function update(Request $request, SparePart $sparePart): RedirectResponse
    {
        $validated = $this->validated($request, $sparePart);
        $validated['slug'] = $sparePart->slug;
        $validated['compatible_models'] = $this->linesToArray($validated['compatible_models']);
        $validated['specifications'] = $this->linesToArray($validated['specifications'] ?? '');
        $validated['is_featured'] = $request->boolean('is_featured');

        $sparePart->update($validated);

        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil diperbarui.');
    }

    public function destroy(SparePart $sparePart): RedirectResponse
    {
        $sparePart->delete();

        return redirect()->route('admin.spareparts.index')->with('success', 'Sparepart berhasil dihapus.');
    }

    private function validated(Request $request, ?SparePart $sparePart = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'sku' => [
                'required',
                'string',
                'max:80',
                Rule::unique('spare_parts', 'sku')->ignore($sparePart),
            ],
            'category' => ['required', 'string', 'max:80'],
            'part_brand' => ['required', 'string', 'max:80'],
            'motor_brand' => ['required', 'string', 'max:80'],
            'compatible_models' => ['required', 'string', 'max:500'],
            'compatible_years' => ['required', 'string', 'max:80'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'review_count' => ['required', 'integer', 'min:0'],
            'image_url' => ['required', 'url', 'max:500'],
            'description' => ['required', 'string', 'max:2000'],
            'specifications' => ['nullable', 'string', 'max:1000'],
            'badge' => ['required', 'string', 'max:80'],
            'status' => ['required', 'in:active,draft,archived'],
        ]);
    }

    private function linesToArray(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n|,/', $value))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $base = $slug;
        $counter = 2;

        while (SparePart::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function statuses(): array
    {
        return ['active' => 'Active', 'draft' => 'Draft', 'archived' => 'Archived'];
    }
}
