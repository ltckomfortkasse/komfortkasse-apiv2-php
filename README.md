# Komfortkasse API v2: Beispiel in PHP

Dieses Repository enthält ein kleines PHP-Beispiel für die Komfortkasse API v2. Mit der API verbinden Sie ein selbst entwickeltes Shopsystem oder eine eigene Plattform mit Komfortkasse; Komfortkasse automatisiert dann den Zahlungsabgleich für **Vorkasse, Rechnung und Nachnahme**. Komfortkasse ordnet eingehende Überweisungen automatisch den offenen Bestellungen Ihres Shops zu und meldet den Zahlungsstatus über die API zurück.

[Komfortkasse API](https://komfortkasse.eu/shopsysteme/api/) · [API-Dokumentation](https://apidoc.komfortkasse.eu/) · [Kostenlos registrieren](https://ssl.komfortkasse.eu/public/register.jsf) · [Hilfe & Dokumentation](https://komfortkasse.freshdesk.com/support/solutions/14000075022)

## Eckdaten

| Merkmal | Angabe |
|---|---|
| Schnittstelle | Komfortkasse API v2, REST mit JSON unter `https://ssl.komfortkasse.eu/api/v2`, beschrieben als OpenAPI in der [API-Dokumentation](https://apidoc.komfortkasse.eu/) |
| Anmeldung | API-Key im HTTP-Header `X-Komfortkasse-API-Key`, nur über HTTPS |
| Zahlungsarten | Vorkasse (Vorauskasse, Banküberweisung), Rechnung (Kauf auf Rechnung), Nachnahme; Bestelltyp `PREPAYMENT`, `INVOICE` oder `COD` |
| Inhalt des Repositorys | Beispielskripte, die eine Testbestellung an Komfortkasse senden und den Zahlungsstatus wieder auslesen |
| Für wen | Entwickler und Agenturen, die ein eigenes Shopsystem oder eine eigene Plattform an Komfortkasse anbinden |
| Kosten | Die API und das Beispiel sind kostenlos. Für Komfortkasse gelten die [Preise](https://komfortkasse.eu/preise/) auf komfortkasse.eu. |
| Anbieter | LTC Information Services GmbH, [komfortkasse.eu](https://komfortkasse.eu/) |

## Was ist Komfortkasse?

Komfortkasse ist ein Online-Dienst der LTC Information Services GmbH, der Zahlungen per Banküberweisung für Onlineshops automatisiert. Komfortkasse ruft die Zahlungseingänge vom Bankkonto ab, ordnet sie den offenen Bestellungen zu und meldet den Zahlungsstatus an den Shop zurück. Der Dienst richtet sich an Online-Händler in Deutschland, Österreich und der Schweiz.

Komfortkasse unterstützt die Zahlungsarten, bei denen das Geld per Überweisung kommt:

- [Vorkasse](https://komfortkasse.eu/loesungen/vorkasse/): Der Käufer überweist vor dem Versand. Komfortkasse prüft den Zahlungseingang und setzt den Bestellstatus im Shop automatisch.
- [Rechnung](https://komfortkasse.eu/loesungen/rechnung/): Die Ware wird sofort geliefert, der Käufer überweist danach. Komfortkasse überwacht die Zahlung und sendet bei Bedarf Zahlungserinnerungen und Mahnungen.
- [Nachnahme](https://komfortkasse.eu/loesungen/nachnahme/): Der Versanddienstleister kassiert bei der Zustellung und überweist den Betrag. Komfortkasse überwacht diese Überweisung.

### So funktioniert Komfortkasse mit der API

1. Ihr System sendet jede Bestellung mit Vorkasse, Rechnung oder Nachnahme an Komfortkasse (`POST /order/{orderNumber}`, mehrere auf einmal mit `POST /orders`).
2. Komfortkasse ist mit Ihrem Bankkonto verbunden ([unterstützte Banken](https://komfortkasse.eu/banken/)) und ordnet eingehende Zahlungen den Bestellungen zu.
3. Ihr System liest den Zahlungsstatus regelmäßig aus (z. B. `GET /orders?paymentStatus=PAID`) oder erhält ihn per Callback, sobald er sich ändert, und setzt die Bestellung auf „bezahlt“ oder „storniert“.

Komfortkasse versendet außerdem Zahlungserinnerungen an Käufer, behandelt Teil- und Überzahlungen und wickelt Rückerstattungen ab. Alle Funktionen sind auf [komfortkasse.eu](https://komfortkasse.eu/) beschrieben.

## Was das Beispiel tut

- `komfortkasse_settings.php`: API-Key und Basis-URL der API.
- `komfortkasse_buildorder.php`: eine Beispielbestellung im Format der API v2 (Bestelldatum, E-Mail-Adresse, Bestelltyp, Betrag, Währung, Sprache, Artikel, Rechnungs- und Lieferadresse).
- `komfortkasse_api.php`: Aufruf der API mit cURL. Der API-Key steht in jedem Aufruf, deshalb nur über HTTPS mit Prüfung des Zertifikats und ohne Weiterleitungen.
- `komfortkasse_send.php`: sendet die Beispielbestellung (`POST /order/{orderNumber}`) und merkt sich die Bestellnummer in `order_numbers.txt`, wenn die API sie angenommen hat.
- `komfortkasse_read.php`: liest jede gemerkte Bestellung aus (`GET /order/{orderNumber}`) und zeigt Zahlungsstatus (`paymentStatus`) und bezahlten Betrag.

Weitere Aufrufe, etwa zum Hochladen einer Rechnung als PDF, zum Stornieren, für Rückerstattungen und für den Callback bei Statusänderungen, beschreibt die [API-Dokumentation](https://apidoc.komfortkasse.eu/).

## Voraussetzungen

- Ein Komfortkasse-Account mit „Komfortkasse API“ als Shopsystem ([kostenlos registrieren](https://ssl.komfortkasse.eu/public/register.jsf))
- Der API-Key des Shops aus dem Komfortkasse-Händlerbereich
- Ein Webserver mit PHP und der Erweiterung cURL; eine Datenbank ist nicht nötig
- Ein Bankkonto, das Sie mit Komfortkasse verbinden ([unterstützte Banken](https://komfortkasse.eu/banken/)), oder ein integriertes Bankkonto von Komfortkasse

## Beispiel ausprobieren

Das Beispiel besteht aus vier Schritten: Dateien kopieren, API-Key eintragen, eine Testbestellung senden und ihren Zahlungsstatus auslesen.

1. **Dateien kopieren:** Die Dateien dieses Repositorys in einen Ordner des Webservers kopieren. PHP muss dort `order_numbers.txt` anlegen dürfen.
2. **API-Key eintragen:** In `komfortkasse_settings.php` den API-Key des Shops eintragen. Den API-Key nicht in ein öffentliches Repository übernehmen.
3. **Bestellung senden:** `komfortkasse_send.php` im Browser öffnen. Das Skript sendet eine Beispielbestellung an Ihren Komfortkasse-Account. Achtung: Das ist eine echte Bestellung. Sie können sie im Händlerbereich stornieren; zum endgültigen Löschen wenden Sie sich an den Support.
4. **Status auslesen:** `komfortkasse_read.php` im Browser öffnen. Die Bestellung erscheint mit dem Zahlungsstatus `UNPAID`. Markieren Sie die Bestellung im Händlerbereich als bezahlt und öffnen Sie `komfortkasse_read.php` erneut: Der Zahlungsstatus ist jetzt `PAID`.

Funktionieren diese Schritte, können Sie die Aufrufe in Ihr eigenes System übernehmen.

## Häufige Fragen

### Was kostet die Komfortkasse API?

Die API und dieses Beispiel sind kostenlos. Für Komfortkasse selbst fällt eine prozentuale Gebühr pro Zahlungseingang an, ohne Grundgebühr und ohne Einrichtungsgebühr. Die aktuellen Sätze stehen auf der [Preisseite](https://komfortkasse.eu/preise/). Neue Accounts können Komfortkasse kostenlos testen.

### Was passiert, wenn die Bestellnummer fehlt oder der Betrag abweicht?

Komfortkasse ordnet Zahlungen fehlertolerant zu. Die Zuordnung funktioniert auch, wenn die Bestellnummer im Verwendungszweck fehlt, der Name des Zahlers nicht zum Besteller passt oder der Betrag abweicht. Auch Teil- und Überzahlungen behandelt Komfortkasse.

### Was passiert, wenn ein Käufer nicht zahlt?

Komfortkasse sendet automatisch Zahlungserinnerungen an den Käufer. Bleibt die Zahlung aus, setzt Komfortkasse den Zahlungsstatus der Bestellung auf `CANCELLED`; bei Rechnung und Nachnahme bedeutet das „überfällig“. Ihr System liest diesen Status über die API aus und setzt die Bestellung entsprechend.

### Welche Banken unterstützt Komfortkasse?

Komfortkasse arbeitet mit Ihrem eigenen Bankkonto oder mit einem integrierten Bankkonto von Komfortkasse. Welche Banken sich anbinden lassen, zeigt die Liste der [unterstützten Banken](https://komfortkasse.eu/banken/).

### Wie erfährt mein System, dass eine Bestellung bezahlt ist?

Auf zwei Wegen: Ihr System fragt den Zahlungsstatus regelmäßig ab, z. B. mit `GET /orders?paymentStatus=PAID`, oder Sie hinterlegen im Komfortkasse-Händlerbereich eine Callback-URL. Komfortkasse ruft sie dann bei jeder Änderung des Zahlungsstatus auf und sendet den Callback-Zugriffscode im HTTP-Header `X-Komfortkasse-Access-Code` mit, den Ihr System prüfen sollte. Einzelheiten stehen in der [API-Dokumentation](https://apidoc.komfortkasse.eu/).

### Was ist mit der API v1?

Die API v1 ist veraltet. Ihr Beispiel liegt im Repository [komfortkasse-apiv1-php](https://github.com/ltckomfortkasse/komfortkasse-apiv1-php); für neue Anbindungen nutzen Sie die API v2.

### Gibt es Komfortkasse auch für fertige Shopsysteme?

Ja. Komfortkasse gibt es unter anderem für Shopify, Shopware, WooCommerce, PrestaShop, Gambio und xt:Commerce. Alle Systeme stehen in der [Übersicht der Shopsysteme](https://komfortkasse.eu/shopsysteme/), weitere Plugin-Repositories unter [github.com/ltckomfortkasse](https://github.com/ltckomfortkasse).

## Support

Fragen zur Einrichtung beantworten die [Hilfe-Seiten](https://komfortkasse.freshdesk.com/support/solutions/14000075022) und der [Komfortkasse-Support](https://komfortkasse.eu/kontakt/).

## English

**Komfortkasse API v2: PHP example.** Komfortkasse automatically matches incoming bank transfers to open orders in your shop and reports the payment status back. It supports prepayment by bank transfer (Vorkasse), invoice and cash on delivery. Komfortkasse is a service of LTC Information Services GmbH for online merchants in Germany, Austria and Switzerland.

This repository contains a small PHP example for the Komfortkasse API v2 (REST/JSON at `https://ssl.komfortkasse.eu/api/v2`, API key in the header `X-Komfortkasse-API-Key`, HTTPS only): `komfortkasse_send.php` submits an example order (`POST /order/{orderNumber}`), `komfortkasse_read.php` reads its payment status (`GET /order/{orderNumber}`). Enter your API key in `komfortkasse_settings.php` and keep it out of public repositories. The API and the example are free of charge; Komfortkasse itself is a paid service ([pricing](https://komfortkasse.eu/preise/)). More information: [Komfortkasse API](https://komfortkasse.eu/shopsysteme/api/) · [API documentation](https://apidoc.komfortkasse.eu/)
