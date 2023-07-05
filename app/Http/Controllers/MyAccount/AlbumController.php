<?php

namespace App\Http\Controllers\MyAccount;

use App\Enums\AlbumType;
use App\Http\Controllers\Controller;
use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Album::class, 'album');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:255', 'min:2'],
            'sort' => ['nullable', Rule::in(['name', 'released_at', 'type', 'created_at']), 'required_unless:direction,null'],
            'direction' => ['nullable', Rule::in(['asc', 'desc']), 'required_unless:sort,null'],
            'filters' => ['nullable', 'array:artist,type'],
            'filters.artist' => ['nullable', Rule::exists(Album::class, 'artist_id')],
            'filters.type' => ['nullable', Rule::enum(AlbumType::class)],
        ]);

        return view('myaccount.albums.index', [
            'artists' => Artist::orderBy('name')->get(['id', 'name']),
            'albums' => $request->user()->library->albums()
                                                 ->with(['artist', 'genres'])
                                                 ->filtered($request)
                                                 ->paginate()
                                                 ->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('myaccount.albums.create', [
            'artists' => Artist::orderBy('name')->get(['name', 'id']),
            'genres' => Genre::orderBy('name')->get(),
            'album' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AlbumRequest $request): RedirectResponse
    {
        $album = $request->user()->library->albums()->create(
            $request
                ->merge(['artist_id' => $this->createArtistAndRetrieveId($request)])
                ->only(['name', 'type', 'released_at', 'artist_id'])
        );

        if (!is_null($genres = $request->input('genres'))) {
            $album->genres()->sync($genres);
        }

        return redirect()->route('myaccount.albums.edit', $album)->with('status', 'album-updated');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album): View
    {
        return view('myaccount.albums.edit', [
            'artists' => Artist::orderBy('name')->get(['name', 'id']),
            'genres' => Genre::orderBy('name')->get(),
            'album' => $album,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AlbumRequest $request, Album $album): RedirectResponse
    {
        $album->update(
            $request
                ->merge(['artist_id' => $this->createArtistAndRetrieveId($request)])
                ->only(['name', 'type', 'released_at', 'artist_id'])
        );

        if (!is_null($genres = $request->input('genres'))) {
            $album->genres()->sync($genres);
        }

        return redirect()->route('myaccount.albums.edit', $album)->with('status', 'album-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Album $album): RedirectResponse
    {
        $request->user()->library->albums()->detach($album);

        return redirect()->route('myaccount.albums.index');
    }

    public function addToLibrary(Request $request, Album $album): RedirectResponse
    {
        $this->authorize('create', Album::class);

        $request->user()->library->albums()->attach($album->id);

        return redirect()->to(route('myaccount.albums.edit', $album));
    }

    protected function createArtistAndRetrieveId(AlbumRequest $request): int
    {
        if (!empty($name = $request->input('artist_name'))) {
            return Artist::firstOrCreate(['name' => $name])->id;
        }

        return $request->integer('artist_id');
    }
}
