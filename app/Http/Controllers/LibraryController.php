<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Library::class);

        $request->validate([
            'q' => ['nullable', 'string', 'max:255', 'min:2'],
            'sort' => ['nullable', Rule::in(['name', 'created_at']), 'required_unless:direction,null'],
            'direction' => ['nullable', Rule::in(['asc', 'desc']), 'required_unless:sort,null'],
            'filters' => ['nullable', 'array:status'],
            'filters.status' => ['nullable', Rule::in('all', 'except-followed', 'only-followed')],
        ]);

        return view('libraries.index', [
            'libraries' => Library::with(['user:id,name'])
                                  ->whereKeyNot($request->user()->library->getKey())
                                  ->withCount('albums')
                                  ->filtered($request)
                                  ->paginate()
                                  ->withQueryString(),
            'followedLibraries' => $request->user()->following,
        ]);
    }

    public function show(Request $request, Library $library): View
    {
        $this->authorize('view', $library);

        $library->loadMissing(['albums', 'albums.artist']);

        return view('libraries.show', [
            'library' => $library,
            'albums' => $library->albums()
                                ->with(['artist', 'genres'])
                                ->filtered($request)
                                ->paginate()
                                ->withQueryString(),
            'followedLibraries' => $request->user()->following,
        ]);
    }

    public function follow(Request $request, Library $library): RedirectResponse
    {
        $this->authorize('follow', $library);

        $request->user()->follow($library);

        return back()->with('status', __('Vous suivez à présent la bibliothèque :name.', ['name' => $library->name]));
    }

    public function unfollow(Request $request, Library $library): RedirectResponse
    {
        $this->authorize('follow', $library);

        $request->user()->unfollow($library);

        return back()->with('status', __('Vous ne suivez plus la bibliothèque :name.', ['name' => $library->name]));
    }
}
