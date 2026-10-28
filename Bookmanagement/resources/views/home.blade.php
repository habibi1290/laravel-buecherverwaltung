@extends('layout/layout')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-12 d-flex align-items-center top-nav">Buchverwaltung</div>
    </div>

    <div class="row">
        <div class="col-4 col-md-3 col-lg-2 menu-padding">
            <div class="menu">
                <i class="fa-solid fa-desktop desktop-symbol"></i>
                <a href="" class="dashboard-btn">Dashboard</a>
            </div>
        </div>
        <div class="col-sm-12 col-md-9 col-lg-10">
            <h1 class="h1-bücher-vewalten">Bücher verwalten</h1>

            <div class="search-add-categorie">
                <form action="{{route('home')}}" method="GET" class="form">
                    <div class="search-wrapper">
                        <input class="search-box"
                               type="search"
                               name="search"
                               value="{{request('search')}}"
                               placeholder="Titel oder Autor suchen...">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </form>

                <div class="add-export-btn">
                    <a href="{{route('addBook')}}" class="add-book-btn">Neues Buch hinzufügen</a>
                    <a href="{{ route('books.export')}}" class="export-excel-btn">Excel exportieren</a>
                </div>

                <div class="dropdown">
                    <button
                        class="btn btn-outline-secondary dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    >
                        {{ request('category') ? $categoryMap[request('category')] ?? request('category') : 'Alle Kategorien' }}
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}">
                                Alle Kategorien
                            </a>
                        </li>

                        @foreach ($categoryMap as $englishCategory => $germanCategory)

                            <li><a class="dropdown-item" href="{{ route('home', ['category' => $germanCategory]) }}">
                                    {{ $germanCategory }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <br><br>
            @if($books->count() > 0)
                @foreach($books as $book)
                    <div class="container container-book-info">
                        <div class="row">
                            <div class="col book-property">
                                <label class="label-Image label">
                                    Title <span class="autor-label">Autor</span>
                                </label>

                                <div class="book-header">
                                    <img
                                        class="home-img"
                                        src="{{ $book->cover }}"
                                        alt="{{ $book->title }}"
                                    >

                                    <div class="book-info">
                                        <div class="title">{{ $book->title }}</div>
                                        <div class="autor">{{ $book->author }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col book-property">
                                <label class="label">Category</label>
                                <div>{{ $book->category }}</div>
                            </div>

                            <div class="col book-property">
                                <label class="label">ISBN</label>
                                <div>{{ $book->isbn }}</div>
                            </div>

                            <div class="col book-property">
                                <label class="label">Aktionen</label>

                                <button
                                    type="button"
                                    class="edit-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editBookModal{{ $book->id }}"
                                >
                                    Bearbeiten
                                </button>

                                <form
                                    action="{{ route('books.destroy', $book->id) }}"
                                    method="POST"
                                    style="display:inline-block;"
                                    onsubmit="return confirm('Möchtest du dieses Buch wirklich löschen?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="delete-btn">
                                        Löschen
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="container container-book-info">
                        <div class="row">
                            <div class="col book-property description">
                                <label class="label">Description</label>
                                <div class="description-text">{{ $book->description }}</div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="editBookModal{{ $book->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!--HTML-Formulare unterstützen nur GET/POST
                                aber laravel-Routen können auch verwenden PUT,Patch,Delete
                                Browser sendet technisch POST.
                                Laravel sieht method('PUT').
                                Laravel behandelt die Anfrage als PUT
                                -->
                                <form action="{{ route('books.update', $book->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Book bearbeiten</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input
                                                type="text"
                                                name="title"
                                                class="form-control"
                                                value="{{ $book->title }}"
                                                required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Author</label>
                                            <input
                                                type="text"
                                                name="author"
                                                class="form-control"
                                                value="{{ $book->author }}"
                                                required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <input
                                                type="text"
                                                name="category"
                                                class="form-control"
                                                value="{{ $book->category }}"
                                                required
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">ISBN</label>
                                            <input type="text"
                                                name="isbn"
                                                class="form-control"
                                                value="{{ $book->isbn }}"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Cover URL</label>
                                            <input
                                                type="text"
                                                name="cover"
                                                class="form-control"
                                                value="{{ $book->cover }}"
                                            >
                                            <img
                                                src="{{ $book->cover ?: asset('images/img.png') }}"
                                                alt="{{ $book->title }}"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea
                                                name="description"
                                                class="form-control"
                                                rows="4"
                                            >{{ $book->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Abbrechen
                                        </button>

                                        <button type="submit" class="btn btn-primary">
                                            Speichern
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>keine Bücher gefunden.</p>
            @endif
        </div>
    </div>
</div>

@endsection
