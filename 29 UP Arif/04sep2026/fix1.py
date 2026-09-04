import re
g=open('build/theme-builder.build.mjs',encoding='utf8').read()
def within(name_start, name_end, old, new):
    global g
    a=g.index(name_start); b=g.index(name_end,a)
    seg=g[a:b]; assert seg.count(old)==1,(name_start,old,seg.count(old))
    g=g[:a]+seg.replace(old,new)+g[b:]
for s,e in [('const editorialSection','const featuredTrioSection'),('const featuredTrioSection','const newArrivalsSection'),('const newArrivalsSection','const tile ='),('const bestSellersSection','const newsletterSection'),('const collectionsSection','const COLLECTIONS_SC')]:
    within(s,e,'background_color: C.white,','background_color: C.cream,')
within('const trustSection','const bestSellersSection','background_color: C.ivory,','background_color: C.white,')
within('const newsletterSection','const collectionsSection','background_color: C.brand,','background_color: C.espresso,')
open('build/theme-builder.build.mjs','w',encoding='utf8').write(g)

s=open('style.css',encoding='utf8').read()
def rep(old,new):
    global s
    assert s.count(old)==1,(old[:50],s.count(old)); s=s.replace(old,new)
rep("""  border-radius: 4px;
  background-color: var(--nb-burgundy);
  border: 0;
  color: var(--nb-white);
}

.nb-cart .wc-proceed-to-checkout a.checkout-button:hover {
  background-color: var(--nb-terracotta);
  color: var(--nb-white);
}""","""  border-radius: 4px;
  background-color: var(--nb-brand);
  border: 0;
  color: var(--nb-cream);
}

.nb-cart .wc-proceed-to-checkout a.checkout-button:hover {
  background-color: var(--nb-brand-dark);
  color: var(--nb-cream);
}""")
rep("""  border-radius: 4px;
  border: 0;
  background-color: var(--nb-burgundy);
  color: var(--nb-white);
}

.nb-checkout #payment #place_order:hover {
  background-color: var(--nb-terracotta);
}""","""  border-radius: 4px;
  border: 0;
  background-color: var(--nb-brand);
  color: var(--nb-cream);
}

.nb-checkout #payment #place_order:hover {
  background-color: var(--nb-brand-dark);
}""")
rep(' Version:        0.11.0',' Version:        0.11.1')
open('style.css','w',encoding='utf8').write(s)
f=open('functions.php',encoding='utf8').read().replace("NB_THEME_VERSION', '0.11.0'","NB_THEME_VERSION', '0.11.1'")
open('functions.php','w',encoding='utf8').write(f)
print('ok')
