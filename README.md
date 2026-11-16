# Eventpromoters — WordPress-thema

Klassiek (PHP) WordPress-thema voor eventpromoters.nl. Ontwerp: navy / indigo / mint palet, koppen in Futura PT, broodtekst in DM Sans (beide self-hosted).

## Installeren

1. Zip de map of kopieer hem naar `wp-content/themes/eventpromoters`.
2. Activeer via **Weergave → Thema's**.
3. **Instellingen → Lezen**: kies een statische pagina als homepage (de inhoud van die pagina verschijnt optioneel onder "Over ons"). Zonder statische pagina toont WordPress ook gewoon `front-page.php`.
4. **Weergave → Menu's**: koppel menu's aan *Hoofdmenu* en *Footermenu*. Zonder menu worden de ankerlinks van de landingspagina getoond.
5. **Weergave → Customizer → Eventpromoters**: hero-teksten, cijfers, over-ons, contactgegevens en social links.

## Structuur

| Bestand | Doel |
| --- | --- |
| `front-page.php` | Landingspagina (hero, cijfers, voor wie, diensten, aanpak, over ons, contact) |
| `index.php`, `single.php`, `page.php`, `404.php`, `comments.php`, `sidebar.php` | Standaard WordPress-templates |
| `template-parts/` | Contactsectie en berichtkaart |
| `inc/customizer.php` | Customizer-instellingen + standaardteksten |
| `inc/contact-form.php` | Contactformulier (nonce, honeypot, `wp_mail`) |
| `inc/template-tags.php` | Helpers (logo, iconen, menu-fallbacks) |
| `assets/css/theme.css` | Alle front-end stijlen (CSS custom properties) |
| `assets/css/editor.css` | Stijlen voor de blokeditor |

Diensten, doelgroepen en stappen zijn aan te passen met de filters `eventpromoters_services`, `eventpromoters_audiences` en `eventpromoters_steps`.

## Fonts

- Futura PT (Bold Oblique, Cond Bold Oblique, Demi) — controleer of de webfontlicentie het domein dekt.
- DM Sans — SIL Open Font License 1.1.
