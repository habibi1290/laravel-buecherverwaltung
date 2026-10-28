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

            <div class="back-btn">
                <a class="back-To-Home-Btn" href="{{route('home')}}">Zurück zur Startseite</a>
            </div>


            @if(session('success'))
                <p class="success-message">
                    {{ session('success') }}
                </p>
            @endif

            @if($errors->any())
                <ul style="color: red;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1>Neues Buch hinzufügen</h1>
                        <form action="{{ route('books.store') }}" method="POST" class="form-save" autocomplete="off">
                            @csrf

                            <label for="Title">Title <span class="required-field">*</span></label>
                            <br>
                            <input class="input-save-page" id="title" type="text" name="title" placeholder="Title" >
                            <br><br>

                            <label for="Autor">Autor <span class="required-field">*</span></label>
                            <br>
                            <input class="input-save-page" type="text" id="author" name="author" placeholder="Vorname Nachname" >
                            <br><br>

                            <label for="categorie">Kategorie</label>
                            <br>
                            <input class="input-save-page" type="text" id="category" name="category" placeholder="Kategorie">
                            <br><br>

                            <label for="isbn">ISBN</label>
                            <br>
                            <input class="input-save-page" type="text" id="isbn" name="isbn" placeholder="ISBN">
                            <br><br>

                            <input type="hidden" id="cover" name="cover">
                            <input type="hidden" id="description-input" name="description">

                            <button class="btn-save-page" type="submit">Buch speichern</button>
                        </form>
                    </div>

                    <div class="col">
                        <h1>Cover Bild</h1>
                        <img class="img-cover" src="" alt="Buchcover" id="book-cover" >

                        <p id="book-message"></p>

                        <p id="description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



