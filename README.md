# RSS Reader

RSS Reader alkalmazás Laravel keretrendszer segítségével

## Funkciók

### Regisztráció
A felhasználóknak lehetőségük van regisztrálni az alkalmazásba.
Regisztrációkor a felhasználók megadhatják a nevüket, e-mail címüket és jelszavukat.
A regisztráció során a rendszer ellenőrzi az e-mail cím egyediségét és a jelszó
megfelelő hosszúságát.

### Belépés
A regisztrált felhasználóknak lehetőségük van belépni az alkalmazásba az e-mail címükkel és jelszavukkal.

### RSS csatornák felvétele
A bejelentkezett felhasználóknak lehetőségük van felvenni RSS csatornákat.
A felhasználók megadhatják a csatorna nevét és URL-jét.
Az alkalmazás ellenőrzi a megadott URL érvényességét.

### RSS hírek mentése
Egy adott csatorna hírei menthetők. 

## Technikai információk
Az adatok tárolására MySQL adatbázist használ az alkalmazás.
Az RSS feedek feldolgozására a SimpleXMLElement metódussal történik.

