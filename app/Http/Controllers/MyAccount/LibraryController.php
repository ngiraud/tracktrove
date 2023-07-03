<?php

namespace App\Http\Controllers\MyAccount;

use App\Http\Controllers\Controller;
use App\Http\Requests\LibraryRequest;
use App\Models\Library;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Library::class);

        return view('myaccount.library.edit', [
            'user' => $request->user(),
            'library' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LibraryRequest $request): RedirectResponse
    {
        $this->authorize('create', Library::class);

        $request->user()->library()->create($request->safe(['name', 'description']));

        return redirect()->route('myaccount.library.edit')->with('status', 'library-updated');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): View
    {
        $this->authorize('update', $request->user()->library);

        return view('myaccount.library.edit', [
            'user' => $request->user(),
            'library' => $request->user()->library,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LibraryRequest $request): RedirectResponse
    {
        $this->authorize('update', $request->user()->library);

        $request->user()->library()->update($request->safe(['name', 'description']));

        return redirect()->route('myaccount.library.edit')->with('status', 'library-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('libraryDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $this->authorize('delete', $request->user()->library);

        $request->user()->library->delete();

        return redirect()->route('dashboard');
    }
}
