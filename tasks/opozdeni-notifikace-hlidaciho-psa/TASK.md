Opoždění notifikace hlídacího psa
=================================

Dva úkoly pro úpravu hlídacího psa (model WatchedProduct), který notifikuje naskladnění produktu.

1. Opozdit notifikaci hlídacího psa

Opozdit notifikaci hlídacího psa o předem stanovený čas. Např. 2h. Defaultně by byla nastavena nula. Stává se, že obchodník přesunuje zboží ze skladu na sklad a zpět. Stane se, že se do skladu pro eshop na chvilku dostane produkt, který je momentálně pro eshop nedostupný. Opožděná notifikace by měla zamezit falešně pozitivním oznámením.

Tím pádem může dojít k tomu, že opožděná notifikace se už nebude odesílat, protože produkt již není skladem.

2. Notifikovat naskladnění produktu v pořadí, v jakém vznikla

Chceme zajistit, aby první zájemce o produkt dostal notifikaci jako první. A až po nějaké době (např. 10 minut) bude notifikován další zájemce. Od např. 10. zájemce by se už nečekalo a notifikovalo by se najednou.

Zase může se stát, že produkt bude vyprodán hned po první odeslané notifikaci, takže pro všechny ostatní zájemce zůstane hlídání zapnuto.
