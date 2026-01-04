# Game List (Laravel 11/12) — SQLite

Deze webapplicatie is een game-lijst waarmee bezoekers games kunnen zoeken en filteren. Ingelogde gebruikers kunnen games favouriten en (na een extra validatie) zelf games toevoegen/beheren. Admins kunnen alle games beheren en de status (actief/inactief) togglen via een POST-action.

---

## Wat kan je met de app?

### Publiek
- Games overzicht:
    - Vrije tekst zoeken (zoekt in **title** én **synopsis**)
    - Filter op publisher (dropdown)
    - (Als ingelogd) filter “Alleen mijn favourites”
- Game detailpagina:
    - Voorbeeld cover image (geen upload nodig)
    - Favourite ster (opslaan in DB, blijft dus “aan” als je terugkomt)

### Ingelogde gebruiker (role=user)
- Favourites toevoegen/verwijderen (ster)
- “My Games”:
    - Eigen games bewerken
    - Actief/inactief togglen via **POST** button
- **Diepere validatie**: een user mag pas een game toevoegen als hij minimaal **5 favourites** heeft  
  (controle via een losse Eloquent query, geen teller-veld)

### Admin (role=admin)
- Admin CRUD voor games
- Status togglen via POST naar aparte controller action
- Admin kan alles bewerken/verwijderen

---

# Installatie & opstarten (SQLite)

## 1) Vereisten
- PHP 8.2+ (aanrader voor Laravel 11/12)
- Composer
- Node.js + npm (voor Vite assets)

## 2) Project installeren
(EERSTE IS NIET NODIG ALS JE MIJN ZIP HEBT!!!!!!!)
```bash
git clone <repo-url>
cd game-list
composer install
npm install
```

## 3) Migrations configureren
```bash
php artisan migrate:fresh --seed
```

## 4) Credentialen voor testgebruikers
```bash
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 'admin',
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Normal User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

```
