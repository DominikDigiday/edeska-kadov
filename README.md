# Úřední deska — modul pro iframe

Statický modul, který načítá RSS feed úřední desky obce Kadov
(`https://kadov.imunis.cz/edeska/feed/rss`) a zobrazuje záznamy
v podobě karet s kategorií, datem, titulkem a odkazem na detail.

## Použití

Hostováno přes GitHub Pages. Vlož do stránky:

```html
<iframe src="https://dominikdigiday.github.io/edeska-kadov/"
        width="100%" height="900" frameborder="0"
        style="border:0"></iframe>
```

## Soubory

- `index.html` — modul (HTML + CSS + vanilla JS, bez závislostí)
- `proxy.php` — záložní PHP proxy pro případ, že by imunis vypnul CORS

## Konfigurace

V `index.html`:
- `FEED_URL` — zdroj RSS (default přímo na imunis)
- `PER_PAGE` — počet položek na stránku (default 5)
