// Bulk-translate the site chrome into Arabic through TranslatePress's own
// editor AJAX endpoints. Run in the browser console on the TranslatePress
// editor page (https://niswahboutique.com/?trp-edit-translation=true), where
// window.trp_editor_data carries the nonces.
//
// Flow, per TranslatePress 3.x:
//   1. POST admin-ajax action=trp_get_translations_regular with the original
//      strings -> returns dictionary rows (ids) for language ar, inserting any
//      that do not exist yet.
//   2. POST action=trp_save_translations with {ar: [{id, original, translated,
//      status: 2}]} -> status 2 = human translated.
//
// STRINGS is filled in from ar-strings.json before running.

(async () => {
  const STRINGS = window.NB_AR_STRINGS; // { "English": "Arabic", ... }
  const ed = window.trp_editor_data;
  if (!ed) { return 'no trp_editor_data on this page'; }
  const ajax = ed.ajax_url || '/wp-admin/admin-ajax.php';
  const lang = 'ar';
  const post = async (data) => {
    const body = new URLSearchParams();
    Object.entries(data).forEach(([k, v]) => body.append(k, v));
    const r = await fetch(ajax, { method: 'POST', credentials: 'same-origin', body });
    const t = await r.text();
    try { return JSON.parse(t); } catch (e) { return { raw: t.slice(0, 300) }; }
  };

  const originals = Object.keys(STRINGS);
  // Step 1: ids.
  const got = await post({
    action: 'trp_get_translations_regular',
    security: ed.nonces.gettranslationsnonceregular,
    language: lang,
    all_languages: 'false',
    strings: JSON.stringify(originals.map((s) => ({ original: s }))),
  });
  // Response shape: { ar: { "<index>": { id, original, translated, status } }, ... }
  const rows = got && got[lang] ? Object.values(got[lang]) : [];
  const byOriginal = {};
  rows.forEach((r) => { byOriginal[r.original] = r; });

  const payload = [];
  const missing = [];
  originals.forEach((o) => {
    const r = byOriginal[o];
    if (r && r.id) {
      payload.push({ id: r.id, original: o, translated: STRINGS[o], status: 2 });
    } else {
      missing.push(o);
    }
  });

  // Step 2: save.
  let saved = null;
  if (payload.length) {
    saved = await post({
      action: 'trp_save_translations',
      security: ed.nonces.savetranslationsnonceregular,
      strings: JSON.stringify({ [lang]: payload }),
    });
  }
  return JSON.stringify({ requested: originals.length, found: payload.length, missing, savedType: typeof saved, savedPreview: JSON.stringify(saved).slice(0, 200) });
})();
