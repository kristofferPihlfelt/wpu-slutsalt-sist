# WPU Slutsålt sist

Gratis plugin från [wordpressutveckling.se](https://wordpressutveckling.se/). Koden förklaras rad för rad i guiden: **[https://wordpressutveckling.se/sortera-slutsalda-produkter-sist-woocommerce/](https://wordpressutveckling.se/sortera-slutsalda-produkter-sist-woocommerce/)**

Byggt av [Kristoffer Pihlfelt](https://pihlfelt.se) på [Pihlfelt & Vänner](https://pihlfelt.se). Licens: GPL-2.0-or-later.

- **Bidragsgivare:** Pihlfelt & Vänner
- **Kräver WordPress:** 6.7
- **Kräver PHP:** 8.2
- **Kräver:** WooCommerce
- **Version:** 1.1.0
- **Licens:** GPL-2.0-or-later

## Vad det gör

Lägger slutsålda produkter sist i butiken, på kategorisidor, i produktsökningen, i kortkoden [products] och i Product Collection-blocket. Det gäller även teman som saknar WooCommerce-stöd, där butiken visas via kortkoden. Produkterna döljs inte och sorteringen kunden valt (pris, popularitet, namn) gäller fortfarande inom de köpbara och inom de slutsålda. Sorteringen läser WooCommerce uppslagstabell wc_product_meta_lookup i stället för postmeta, så den är snabb även i stora butiker. Produkter som kan restnoteras räknas som köpbara.

## Installation

1. Kontrollera att WooCommerce är aktiverat.
2. Gå till Tillägg > Lägg till nytt > Ladda upp tillägg och välj zip-filen. Aktivera.
3. Det finns inga inställningar. Töm sidcachen så att kategorisidorna byggs om.

## Källa

Koden förklaras rad för rad i guiden "Sortera slutsålda produkter sist i WooCommerce":
https://wordpressutveckling.se/sortera-slutsalda-produkter-sist-woocommerce/

Den senaste versionen finns alltid på samma adress:
https://wordpressutveckling.se/ladda-ner/wpu-slutsalt-sist/

## Ändringslogg

### 1.1.0
* Sorterar även kortkoden [products] och butiken i teman utan WooCommerce-stöd. Kortkoder med ids och orderby="post__in" behåller din ordning.

### 1.0.0
* Första versionen, samma kod som i guiden.
