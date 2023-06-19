# Návrh informačního systému
**Název projektu:**
Systém **Prevence Reakce Detekce Evidence a Logistiky**

## Úložiště dat:

Tabulka **Uživatelů**

> - uživatelské jméno
> - heslo
> - role uživatele
>   - zaměstnanec jídelny
>   - dovozce
>   - odvozce
>   - první respondent
>   - administrátor
> - telefonní číslo
> - email

Tabulka **Příjmu**

> - datum
> - hmotnost/množství
> - cena

Tabulka **Výdaje**

> - datum
> - hmotnost/množství
> - cena

Tabulka **Odvozu**

> - datum
> - hmotnost/množství
> - cena

---

Role **Zaměstnance jídelny**

> Zadává hmotnost/množství příjmu\
> Zadává hmotnost/množství výdeje\
> Zadává hmotnost/množství odvozu

Role **Dovozce**

> Zadává hmotnost/množství dovozu

Role **Odvozce**

> Zadává hmotnost/množství odvozu

Role **Prvního respondenta**

> Přístup k statistikám\
> V případě potřeby je informován

Role **Administrátora**

> Přístup k statistikám\
> Správa uživatelů\
> Správa dat

---

## Popis

Systém umožňuje sledovat náklady i výdělky jídelen nebo dlouhodobě ukládat záznamy. Může automaticky vystavovat potřebné administrativní dokumenty a informovat jednotlivé strany pro hladký běh instituce. Dokonce lze monitorovat i mrhání jídlem.

## Příklad využití

Tento systém se týká jídelen. Pro svoje fungování vyžaduje spolupráci jak jídelny samotné, tak i dodavatelů, služeb svozu odpadu a především vedení/správy jídelny (třeba škola). Systém je speciálně navržen i pro zabraňování pojišťovacích podvodů 😉.

Dejme tomu, že kuchařka si řekne, že si nabere plnou tašku jídla sebou domů. Ještě, než se však dostane z pracoviště, tak si může zpřetrhat vazy, zranit páteř (posun obratle). Je pak takové zranění úrazem na pracovišti?

Přesně tohle může řešit náš systém. Dosáhne toho měřením nezvyklých rozdílů v evidovaných hodnotách. Pokud systém vyhodnotí nadměrný rozdíl, bude informovat prvního respondenta (např. nadřízeného/ředitele školy) pro případ, že bude nezbytná i první pomoc.
