Bücherverwaltung mit Laravel und DDEV

Laravel-Anwendung mit einem Buchbestand in einer Datenbank. Coverbilder und Beschreibungen werden über die Google Books API ergänzt. Ein Export-Button lädt Buchdaten als Excel-Datei herunter.

Die Anwendung verwendet die echte Google-Books-Anbindung. Für die lokale Nutzung werden eine eigene Datenbank und ein eigener Google-Books-API-Schlüssel eingerichtet.

Vorlage – vor dem Veröffentlichen anpassen: Ersetze GITHUB-NAME/REPOSITORY durch dein Repository. Prüfe, ob die API-Variable im Code tatsächlich GOOGLE_BOOKS_API_KEY heißt. Beschreibe gegebenenfalls die Anmeldung. Entscheide, ob du den vorhandenen Buchbestand als bereinigten SQL-Export mitlieferst. Die folgenden Schritte wurden nicht gegen die Projektdateien ausgeführt.

Voraussetzungen

Git oder ein als ZIP heruntergeladenes Repository.

Eine laufende, von DDEV unterstützte Docker-Umgebung.

Installiertes DDEV.

Internetzugang für Abhängigkeiten und Google Books.

Ein eigener API-Schlüssel für die Google Books API.

PHP, Composer und Node.js werden über DDEV verwendet. Die benötigten Versionen und Dienste werden durch .ddev/config.yaml, composer.json und gegebenenfalls package.json festgelegt.

Docker für DDEV einrichten

DDEV installieren

1. Projekt herunterladen

Ersetze den Repository-Link:

git clone https://github.com/GITHUB-NAME/REPOSITORY.git buecherverwaltung
cd buecherverwaltung

Alternativ auf GitHub Code → Download ZIP wählen, das Archiv entpacken und im Terminal in den entpackten Projektordner wechseln.

Alle folgenden Befehle werden in dem Ordner ausgeführt, in dem artisan und composer.json liegen.

2. Lokale Konfiguration erstellen

Kopiere bei einer neuen Installation .env.example nach .env. Eine bereits eingerichtete .env nicht überschreiben.

Linux, macOS oder WSL:

cp .env.example .env

Windows PowerShell:

Copy-Item .env.example .env

Die Datei .env enthält deine lokale Konfiguration und bleibt außerhalb von Git.

3. DDEV starten und PHP-Abhängigkeiten installieren

Docker muss laufen. Verwende die mitgelieferte DDEV-Konfiguration:

ddev start
ddev composer install

composer install installiert die im Repository festgelegten Abhängigkeiten, einschließlich des verwendeten Excel-Pakets. Installiere nicht erneut ein anderes Excel-Paket und verwende für die Ersteinrichtung nicht composer update.

Prüfe bei einer MySQL-/MariaDB-Konfiguration in DDEV die Datenbankwerte deiner .env:

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=db
DB_USERNAME=db
DB_PASSWORD=db

Diese Werte sind die üblichen lokalen DDEV-Zugangsdaten. Falls die Projektkonfiguration davon abweicht, gelten die projektspezifischen Werte.

4. Anwendungsschlüssel und Google Books einrichten

Erzeuge bei der neuen Installation einen eigenen Laravel-Anwendungsschlüssel:

ddev artisan key:generate

Der APP_KEY ist der Laravel-Anwendungsschlüssel; der Google-Books-API-Schlüssel wird separat eingerichtet.

Erstelle in deinem Google-Cloud-Projekt einen API-Schlüssel für die aktivierte Books API. Die Einrichtung ist in der Google-Books-Dokumentation beschrieben.

Trage deinen Schlüssel in .env unter der vom Projekt verwendeten Variable ein. In dieser Vorlage lautet sie:

GOOGLE_BOOKS_API_KEY=HIER_DEINEN_EIGENEN_SCHLUESSEL_EINTRAGEN

Der Variablenname muss mit dem bestehenden API-Code bzw. dessen Eintrag in config/services.php übereinstimmen.

Prüfe außerdem, dass APP_URL die lokale URL der Anwendung enthält. Die URL zeigt:

ddev describe

Lade anschließend die aktuelle Konfiguration:

ddev artisan config:clear

5. Datenbank einrichten

Mit vorhandenem Buchbestand

Falls das Repository die Datei database/catalog.sql.gz enthält, importiere sie in die neue lokale Projektinstallation:

ddev import-db --file=database/catalog.sql.gz
ddev artisan migrate

Der Import ersetzt die Datenbank dieses DDEV-Projekts. Führe ihn nur in der neuen Installation oder nach einer passenden Sicherung aus.

Der mitgelieferte Export muss die Tabellenstruktur, den Migrationsstand und den freigegebenen Buchbestand enthalten. Nutzerkonten, Sessions, Tokens und private Inhalte werden nicht als öffentlicher Datenbestand mitgeliefert.

Ohne mitgelieferten Datenbankexport

Erstelle die Tabellen aus den vorhandenen Migrationen:

ddev artisan migrate

Die Datenbank enthält dadurch nicht automatisch den Buchbestand des ursprünglichen Entwicklers. Falls Bücher zum Start benötigt werden, muss der Repository-Autor einen Datenimport oder einen Seeder mit freigegebenen tatsächlichen Buchdaten bereitstellen und dessen Aufruf hier dokumentieren.

Der Excel-Export der Anwendung erstellt eine Tabellen-Datei. Er richtet weder das Datenbankschema ein noch importiert er diese Daten zurück in die Anwendung.

6. Frontend-Dateien erstellen

Falls das Projekt package.json, package-lock.json und ein build-Script verwendet:

ddev npm ci
ddev npm run build

Wenn npm verwendet wird, aber noch keine package-lock.json existiert, wird bei der ersten Einrichtung statt ddev npm ci einmal ddev npm install benötigt. Für reproduzierbare Installationen sollte der Repository-Autor die passende Lockdatei mitliefern.

Bei einem anderen Paketmanager gelten dessen Lockdatei und Befehle. Wenn die Anwendung kein Frontend-Build benötigt, entfällt dieser Schritt.

Falls lokale öffentliche Uploads über Laravels Storage-Verzeichnis verwendet werden, erstelle zusätzlich den Link:

ddev artisan storage:link

Für direkt von Google geladene Coverbilder wird dieser Storage-Link nicht benötigt.

7. Anwendung öffnen

ddev launch

DDEV öffnet die Anwendung im Browser. Die genaue Adresse steht auch in der Ausgabe von ddev describe.

Anmeldung

Falls die Bücherverwaltung oder der Excel-Export eine Anmeldung erfordern, muss der Repository-Autor hier den tatsächlichen Ablauf ergänzen: beispielsweise die vorhandene Registrierungsseite oder einen projektspezifischen Befehl zur Erstellung eines lokalen Benutzers.

Persönliche Zugangsdaten des Entwicklers werden nicht mitgeliefert.

8. Funktion prüfen

Öffne die Bücherübersicht und prüfe, ob der importierte Buchbestand angezeigt wird.

Öffne ein Buch, zu dem Google Books Cover und Beschreibung bereitstellt.

Klicke auf den vorhandenen Excel-Export-Button.

Öffne die heruntergeladene Datei und prüfe Spalten, Umlaute und ISBNs.

Google Books liefert nicht zu jedem Buch sämtliche Felder. Ein fehlendes Cover bei einem einzelnen Buch bedeutet daher nicht automatisch, dass die gesamte API-Anbindung fehlerhaft ist.

Später erneut starten oder stoppen

ddev start
ddev launch

Zum Stoppen:

ddev stop

Häufige Probleme

Problem

Prüfung

DDEV startet nicht

Docker starten und anschließend ddev start erneut ausführen.

Datenbankverbindung schlägt fehl

ddev describe, DB_HOST=db und die übrigen Datenbankwerte prüfen; danach ddev artisan config:clear.

Tabellen fehlen

Prüfen, ob der SQL-Import bzw. ddev artisan migrate erfolgreich war.

Bücherübersicht ist leer

Migrationen erstellen Tabellen. Den vorgesehenen Buchbestand zusätzlich importieren.

Anwendungsschlüssel fehlt

Bei der neuen Installation ddev artisan key:generate ausführen.

Cover und Beschreibungen fehlen

API-Variablenname, eigenen Schlüssel, aktivierte Books API, Einschränkungen, Kontingent und Internetverbindung prüfen.

Vite-Manifest fehlt

Bei Verwendung von Vite die npm-Abhängigkeiten installieren und ddev npm run build ausführen.

Excel-Export schlägt fehl

ddev composer install ausführen und die Fehlermeldung in storage/logs/laravel.log prüfen.

Technische Dokumentation

Laravel-Konfiguration

Laravel-Migrationen

DDEV für Laravel

DDEV-Datenbankverwaltung

Google Books API
