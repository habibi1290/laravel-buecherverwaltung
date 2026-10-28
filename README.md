Bücherverwaltung mit Laravel und DDEV

Laravel-Anwendung zur Verwaltung eines Buchbestands in einer lokalen Datenbank. Die Google Books API ergänzt Coverbilder und Beschreibungen. Über den Excel-Export-Button lassen sich Buchdaten herunterladen.

Die Anwendung verwendet eine echte Google-Books-Anbindung. Für die Einrichtung werden ein eigener API-Schlüssel und eine lokale DDEV-Umgebung benötigt.

Voraussetzungen

Git zum Klonen des Repositorys; alternativ ist ein ZIP-Download möglich.

Eine laufende, von DDEV unterstützte Docker-Umgebung.

DDEV.

Internetzugang zum Installieren der Abhängigkeiten und zum Abrufen von Google-Books-Daten und Coverbildern.

Ein eigener API-Schlüssel für die Google Books API.

PHP, Composer und Node.js werden über DDEV ausgeführt. Die Projektkonfiguration und die Abhängigkeitsdateien legen die benötigten Versionen fest.

1. Projekt herunterladen

Ersetze DEIN-GITHUB-NAME durch den GitHub-Benutzernamen des Repository-Inhabers:

git clone https://github.com/DEIN-GITHUB-NAME/laravel-buecherverwaltung.git
cd Bookmanagement

Alternativ auf GitHub Code → Download ZIP wählen, das Archiv entpacken und im Terminal in den Unterordner Bookmanagement wechseln.

Alle folgenden Befehle werden im Laravel-Ordner ausgeführt, in dem artisan, composer.json und .ddev liegen. Falls das Repository anders aufgebaut ist, verwende diesen Ordner. Beachte die genaue Groß- und Kleinschreibung.

2. Lokale Konfiguration erstellen

Kopiere bei der ersten Einrichtung .env.example nach .env.

Linux, macOS, WSL oder Git Bash:

cp .env.example .env

Windows PowerShell:

Copy-Item .env.example .env

Verwende nur den zu deinem Terminal passenden Kopierbefehl. Eine bereits eingerichtete .env nicht überschreiben.

Die Datei .env enthält die lokale Konfiguration und bleibt außerhalb von Git. In .env.example bleiben APP_KEY und der Google-Books-API-Schlüssel leer.

3. DDEV starten und Abhängigkeiten installieren

Starte Docker und verwende die mitgelieferte DDEV-Konfiguration.

Wenn bereits eine andere Kopie dieses Projekts auf demselben Rechner eingerichtet ist: Vergib in der neuen Kopie vor dem ersten Start einen noch nicht verwendeten DDEV-Projektnamen, zum Beispiel:

ddev config --project-name=buecherverwaltung-test

Führe diesen Befehl nur im neuen Projektordner aus. Die Änderung des Projektnamens dient dem lokalen Installationstest und muss nicht ins Repository übernommen werden.

Starte anschließend DDEV und installiere die PHP-Abhängigkeiten:

ddev start
ddev composer install

Die benötigten PHP-Pakete werden aus composer.lock installiert. Ein zusätzliches Installieren eines Excel-Pakets ist für die Einrichtung nicht erforderlich.

4. Datenbank und Anwendungsschlüssel konfigurieren

Prüfe in .env die Datenbankverbindung für die lokale MySQL-/MariaDB-Datenbank von DDEV:

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=db
DB_USERNAME=db
DB_PASSWORD=db

Das sind die üblichen lokalen DDEV-Zugangsdaten. Behalte die übrigen Einträge aus .env.example bei.

Erzeuge für diese neue Installation einen Laravel-Anwendungsschlüssel:

ddev artisan key:generate

Der Befehl trägt APP_KEY automatisch in .env ein. Bei einer bereits eingerichteten Installation muss der Schlüssel nicht erneut erzeugt werden.

5. Google Books API einrichten

Öffne die Google Cloud Console und wähle ein eigenes Projekt oder erstelle eines.

Aktiviere für dieses Projekt die Books API.

Erstelle unter APIs und Dienste → Anmeldedaten einen API-Schlüssel.

Trage deinen eigenen Schlüssel in die lokale .env ein:

GOOGLE_BOOKS_API_KEY=DEIN_EIGENER_API_SCHLUESSEL

Ersetze den Platzhalter durch deinen tatsächlichen Schlüssel. Der hier verwendete Variablenname GOOGLE_BOOKS_API_KEY muss mit dem API-Code beziehungsweise dessen Konfiguration übereinstimmen.

Die Einrichtung ist auch in der Google-Books-Dokumentation beschrieben.

Zeige die lokale Projektadresse an:

ddev describe

Übernimm die angezeigte Web-URL als APP_URL in .env. Lade danach die geänderte Laravel-Konfiguration:

ddev artisan config:clear

6. Tabellen erstellen und Buchbestand importieren

Die Datei database/books.sql enthält die exportierten Datensätze der Tabelle books, einschließlich gespeicherter Cover-URLs und Beschreibungen. Die Tabellenstruktur wird durch die Laravel-Migrationen erstellt. Der Buchdatenexport enthält keine Benutzerkonten oder Sessions.

Dieser Schritt ist für eine neue Installation vorgesehen. Die Tabelle books muss vor dem Import leer sein.

Erstelle zuerst die Tabellen:

ddev artisan migrate

Prüfe anschließend, ob bereits Bücher vorhanden sind:

ddev mysql -e "SELECT COUNT(*) AS anzahl_buecher FROM books;"

Nur wenn die Anzahl 0 ist, importiere den Buchbestand einmalig:

ddev import-db --no-drop --file=database/books.sql

--no-drop verhindert, dass DDEV die Datenbank vor dem Import löscht. Die Option ist hier erforderlich, weil der Export nur Buchdaten enthält und die zuvor erstellten Tabellen benötigt.

Bei einer Anzahl größer als 0 den Import nicht ausführen. Für einen vollständigen Installationstest eine neue Projektkopie mit eigenem DDEV-Namen verwenden. Vorhandene Bücher müssen dafür nicht gelöscht werden.

Die Coverbilder selbst sind nicht in der SQL-Datei enthalten. Gespeichert werden ihre URLs; zum Laden der Bilder ist eine Internetverbindung erforderlich.

7. Frontend erstellen

Falls das Projekt npm mit package.json, package-lock.json und einem build-Script verwendet:

ddev npm ci
ddev npm run build

Wenn npm verwendet wird, aber keine package-lock.json vorhanden ist, verwende statt ddev npm ci den Befehl ddev npm install. Die passende Lockdatei sollte für weitere Installationen im Repository enthalten sein.

Falls kein Frontend-Build erforderlich ist, entfällt dieser Schritt.

Nur wenn die Anwendung zusätzlich lokale öffentliche Dateien aus storage/app/public verwendet:

ddev artisan storage:link

Für Coverbilder, die direkt über Google-Books-URLs geladen werden, wird dieser Link nicht benötigt.

8. Anwendung öffnen und prüfen

ddev launch

Prüfe anschließend:

Wird der importierte Buchbestand in der Bücherübersicht angezeigt?

Werden vorhandene Beschreibungen und Coverbilder dargestellt?

Lässt sich über den Excel-Export-Button eine Datei herunterladen?

Werden Titel, Umlaute und ISBNs in der exportierten Datei korrekt dargestellt?

Google Books stellt nicht zu jedem Buch ein Cover oder eine Beschreibung bereit. Bereits gespeicherte Buchdaten sind von neuen API-Abfragen zu unterscheiden; für neue Abfragen wird der eigene API-Schlüssel verwendet.

Anmeldung

Der Buchdatenimport legt keine Benutzerkonten an.

Vor Veröffentlichung ergänzen, falls eine Anmeldung erforderlich ist: Den tatsächlichen Weg zur Registrierung oder zur Erstellung eines lokalen Benutzerkontos dokumentieren. Persönliche Zugangsdaten werden nicht mitgeliefert. Falls die Anwendung ohne Anmeldung nutzbar ist, kann dieser Hinweis entfernt werden.

Später starten und stoppen

Zum erneuten Starten im Laravel-Projektordner:

ddev start
ddev launch

Zum Stoppen:

ddev stop

Der Buchdatenimport gehört zur Ersteinrichtung und wird nicht bei jedem Start wiederholt.

Häufige Probleme

Problem

Lösung oder Prüfung

Duplicate entry '15' for key 'PRIMARY' oder eine andere ID

Diese ID ist bereits vorhanden. Den Import nicht erneut ausführen. Für einen neuen Installationstest eine separate Projektkopie mit eigenem DDEV-Namen einrichten.

database/books.sql fehlt

Prüfen, ob Bookmanagement/database/books.sql im Repository enthalten ist und der Befehl im Laravel-Ordner ausgeführt wird.

Tabelle books fehlt

Prüfen, ob die Migration für books enthalten ist und ddev artisan migrate erfolgreich war.

Unknown column beim Import

Die Migrationen müssen alle Spalten des Buchdatenexports erstellen, insbesondere auch cover und description.

Bücherübersicht ist leer

Tabellen wurden möglicherweise erstellt, aber die Buchdaten noch nicht importiert. Zuerst die Anzahl der Bücher prüfen.

DDEV startet nicht

Prüfen, ob Docker läuft und der DDEV-Projektname nicht bereits für einen anderen Projektordner verwendet wird.

Datenbankverbindung schlägt fehl

Datenbankwerte in .env prüfen und anschließend ddev artisan config:clear ausführen.

Anwendungsschlüssel fehlt

Bei der neuen Installation ddev artisan key:generate ausführen.

Cover oder Beschreibungen fehlen

Verfügbarkeit bei Google Books, Internetverbindung, API-Variablenname, eigenen Schlüssel und dessen Berechtigungen prüfen.

Vite-Manifest fehlt

npm-Abhängigkeiten installieren und ddev npm run build ausführen, sofern das Projekt Vite verwendet.

Excel-Export schlägt fehl

PHP-Abhängigkeiten mit ddev composer install installieren und die konkrete Fehlermeldung in storage/logs/laravel.log prüfen.

Dokumentation

Laravel

DDEV für Laravel

DDEV-Datenbankverwaltung

DDEV-Befehle und Importoptionen

Google Books API
