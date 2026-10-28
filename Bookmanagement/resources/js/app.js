
import './bootstrap';

import 'bootstrap';

import '../css/app.css';

document.addEventListener('DOMContentLoaded', () => {
    const titleInput = document.getElementById('title');
    const authorInput = document.getElementById('author');
    const isbnInput = document.getElementById('isbn');
    const categoryInput = document.getElementById('category');

    const coverImage = document.getElementById('book-cover');
    const coverInput = document.getElementById('cover');

    const message = document.getElementById('book-message');

    const description = document.getElementById('description');
    const descriptionInput = document.getElementById('description-input');

    if (!titleInput || !authorInput || !isbnInput || !categoryInput || !description || !coverInput || !descriptionInput) {
        return;
    }

    let typingTimer;

    function searchBook() {
        const title = titleInput.value.trim();
        const author = authorInput.value.trim();

        if (title.length < 2 || author.length < 2) {
            return;
        }

        const url = `/google-books/search?title=${encodeURIComponent(title)}&author=${encodeURIComponent(author)}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (!data.found) {
                    if (coverImage) {
                        coverImage.style.display = 'none';
                        coverImage.src = '';
                    }

                    isbnInput.value = '';
                    categoryInput.value = '';
                    coverInput.value = '';
                    description.innerText = '';
                    descriptionInput.value = '';

                    if (message) {
                        message.innerText = data.message ?? 'Entweder Title oder Autor falsch eingetippt oder Cover nicht vorhanden.';
                    }
                    return;
                }

                if (data.cover && coverImage) {
                    coverImage.src = data.cover;
                    coverImage.style.display = 'block';
                    coverInput.value = data.cover;
                } else if (coverImage) {
                    coverImage.src = '';
                    coverImage.style.display = 'none';
                    coverInput.value = '';
                }

                isbnInput.value = data.isbn ?? 'nicht vorhanden';

                categoryInput.value = data.category ?? 'nicht vorhanden';

                description.innerText = data.description ?? 'Keine Beschreibung vorhanden';
                descriptionInput.value = data.description ?? '';

                if (message) {
                    message.innerText = '';
                }

            })
            .catch(error => {
                console.error(error);

                if(coverImage) {
                    coverImage.style.display = 'none';
                    coverImage.src = '';
                }

                isbnInput.value = '';
                categoryInput.value = '';
                coverInput.value = '';
                description.innerText = '';
                descriptionInput.value = '';

                if (message) {
                    message.innerText = 'Fehler beim Laden der Buchdaten.';
                }

            });
    }
    function debounceSearch() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(searchBook, 700);
    }
    titleInput.addEventListener('input', debounceSearch);
    authorInput.addEventListener('input', debounceSearch);
});
