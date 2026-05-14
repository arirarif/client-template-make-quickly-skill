/* ==========  BIZJUMP WIZARD — Front-end JS  ==========
   Source data (STATES, PLANS, ADDONS, DESIGNATORS, SECTIONS) is injected by
   PHP via wp_localize_script() as window.BJW_DATA. This file falls back to
   empty defaults if BJW_DATA is missing (e.g. file loaded standalone for testing).
============================================================================ */
const BJWD          = (typeof window !== 'undefined' && window.BJW_DATA) || {};
const STATES        = BJWD.states       || {};
const PLANS         = BJWD.plans        || {};
const DESIGNATORS   = BJWD.designators  || {};
const SECTIONS      = BJWD.sections     || {};
const ADDONS        = BJWD.addons       || [];
const STATE_PROCESSING = {"Florida":"3 weeks","Texas":"4 weeks","California":"3-4 weeks","Delaware":"2 weeks","Wyoming":"1-2 weeks","New York":"4-6 weeks","Nevada":"3 weeks","Connecticut":"3 weeks"};

/* ==========  WIZARD STATE  ========== */
const state = {
  entity:'LLC',
  stateName:'Florida',
  stateFee:125,             // computed via getStateFee(stateName, entity)
  expeditedFee:135,         // computed via getExpeditedFee(stateName)
  plan:null,
  inlineAddons:{},
  filingTime:null,
  business:{name:'',designator:'LLC',purpose:'',naics:''},
  // NEW — contact-person captured at Step 3b (reused on Step 5 via sameAsContact)
  contact:{firstName:'',lastName:'',email:'',phone:'',street1:'',street2:'',city:'',state:'',county:'',country:'US',zip:''},
  address:{useVirtualAddress:true,sameAsContact:true,firstName:'',lastName:'',email:'',phone:'',street1:'',street2:'',city:'',state:'',country:'US',zip:''},
  premiumBundle:null,
  members:[{type:'individual',firstName:'',lastName:'',useAssignedAddress:true,ownership:100}],
  registeredAgent:'bizjump',
  ein:{isForeign:false,idType:'ssn',idNumber:'',irsAddress:'company'},
  banking:null,
  taxConsultation:null,
  licenseResearch:null,
  consent:{legal:false,marketing:false,sms:false},
  currentStep:1,
  totalSteps:14             // bumped from 13 for new Contact step (3b)
};

/* ==========  HELPERS  ========== */
function $(sel){return document.querySelector(sel)}
function $$(sel){return document.querySelectorAll(sel)}
function fmt(n){return '$'+n.toFixed(2).replace(/\.00$/,'')}

/* ==========  PER-ENTITY FEE LOOKUPS  ========== */
function getStateFee(stateName, entity){
  const r = STATES[stateName]; if(!r) return 0;
  if(entity === 'LLC')        return r.llc;
  if(entity === 'Nonprofit')  return r.nonprofit;
  return r.corp; // C-Corp + S-Corp both use Corporation filing fee
}
function getExpeditedFee(stateName){
  return STATES[stateName]?.expedited ?? 50;
}
function refreshStateFee(){
  state.stateFee     = getStateFee(state.stateName, state.entity);
  state.expeditedFee = getExpeditedFee(state.stateName);
}
function applyDesignators(){
  const list = DESIGNATORS[state.entity] || ['LLC'];
  const sel  = document.querySelector('#biz-designator');
  if(!sel) return;
  const prev = sel.value;
  sel.innerHTML = list.map(d => `<option value="${d}"${d===prev?' selected':''}>${d}</option>`).join('');
  if(!list.includes(prev)) { sel.value = list[0]; state.business.designator = list[0]; }
}
function isAddonVisible(addon){
  if(addon.entities === 'all') return true;
  return Array.isArray(addon.entities) && addon.entities.includes(state.entity);
}

/* ==========  STEP 4 — Contact (new in v2)  ========== */
function initContactStep(){
  // populate state dropdown if empty; default to formation state
  const sel = document.querySelector('#ct-state');
  if(sel && !sel.options.length){
    sel.innerHTML = '<option value="">Select state</option>' +
      Object.keys(STATES).map(s => `<option value="${s}">${s}</option>`).join('');
  }
  if(sel && !state.contact.state){
    state.contact.state = state.stateName;
    sel.value = state.stateName;
  }
  validateContact();
}
function validateContact(){
  const c = state.contact;
  const ok =
    c.firstName.trim() && c.lastName.trim() &&
    /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(c.email.trim()) &&
    c.phone.trim().length >= 7 &&
    c.street1.trim() && c.city.trim() && c.state.trim() &&
    /^\d{5}(-\d{4})?$/.test(c.zip.trim());
  const btn = document.querySelector('#contact-next');
  if(btn) btn.disabled = !ok;
  return !!ok;
}

/* ==========  STEP 5 — Address: "Same as Contact" prefill  ========== */
function syncAddressFieldsFromState(){
  document.querySelectorAll('#company-addr-fields .addr-input').forEach(el => {
    const key = el.dataset.key;
    if(key && key in state.address) el.value = state.address[key] ?? '';
  });
}
function toggleSameAsContact(checked){
  state.address.sameAsContact = checked;
  const root = document.querySelector('#company-addr-fields');
  if(!root) return;
  if(checked){
    // copy from state.contact into state.address
    ['firstName','lastName','email','phone','street1','street2','city','state','country','zip'].forEach(k => {
      state.address[k] = state.contact[k] || '';
    });
    syncAddressFieldsFromState();
  }
  root.querySelectorAll('.addr-input').forEach(el => { el.disabled = checked; });
}
function initAddressStep(){
  // Make sure state-dropdown is populated before prefilling
  populateStateSelects();
  const cb = document.querySelector('#same-as-contact');
  const checked = state.address.sameAsContact !== false;
  if(cb) cb.checked = checked;
  toggleSameAsContact(checked);
}

/* ==========  STEP 1 — render addon table from ADDONS data  ========== */
function renderPackageCell(addon, tierKey, isRecommended){
  const val = addon.price[tierKey];
  const rec = isRecommended ? ' recommended' : '';
  let inner;
  if(val === 'included')        inner = '<span class="pkg-check">✓</span>';
  else if(val === 'free+29mo')  inner = '<span class="pkg-info">Free setup<br>+ $29/mo</span>';
  else if(val === '99/year')    inner = '<span class="pkg-info">+$99/year</span>';
  else                          inner = `<button class="pkg-add" onclick="toggleInlineAddon(this,'${addon.id}',${val})">+$${val}</button>`;
  return `<div class="pkg-cell${rec}">${inner}</div>`;
}
function renderPackageRows(){
  refreshStateFee();
  const fee = fmt(state.stateFee);

  // Always-included filing row — title + bullet list (left cell) + state fee/speed/✓ per tier
  const filing = document.querySelector('#pkg-row-filing');
  if(filing){
    filing.className = 'pkg-row';
    filing.innerHTML = `
      <div class="pkg-cell pkg-cell-filing">
        <div class="pkg-filing-title"><strong>Prepare &amp; File Articles of Organization/Incorporation</strong> <span class="addon-info-icon" aria-hidden="true">🅘</span></div>
        <p class="pkg-filing-sub">The official document filed with the state to legally create your business entity.</p>
        <p class="pkg-filing-receive"><strong>What you receive:</strong></p>
        <ul class="pkg-filing-list">
          <li>Digital Document Delivery of your approved state formation documents.</li>
          <li>Statement of Organizer/Incorporator</li>
          <li>Business Name Availability Search and Verification</li>
          <li>Email Support During Formation Process</li>
          <li>Filing Status Updates</li>
          <li>Secure Online Client Portal Access</li>
        </ul>
      </div>
      <div class="pkg-cell pkg-cell-stack"><span class="state-fee-display">${fee}</span> state fees<small>7 days</small><span class="pkg-check">✓</span></div>
      <div class="pkg-cell pkg-cell-stack"><span class="state-fee-display">${fee}</span> state fees<small>2 days</small><span class="pkg-check">✓</span></div>
      <div class="pkg-cell pkg-cell-stack recommended"><span class="state-fee-display">${fee}</span> state fees<small>24 hours</small><span class="pkg-check">✓</span></div>`;
  }

  // Dynamic addon rows, grouped by section
  const container = document.querySelector('#pkg-rows');
  if(!container) return;
  let html = '';
  ['corporate','taxes','web'].forEach(sec => {
    const rows = ADDONS.filter(a => a.section === sec && isAddonVisible(a));
    if(!rows.length) return;
    html += `<div class="pkg-row pkg-section">${SECTIONS[sec]}</div>`;
    rows.forEach(addon => {
      const descSafe = addon.desc.replace(/"/g,'&quot;');
      html += `<div class="pkg-row">
        <div class="pkg-cell">
          <div class="addon-head">
            <span class="addon-label-text">${addon.label}</span>
            <button type="button" class="addon-info-btn" onclick="toggleAddonInfo(this)" aria-expanded="false" aria-label="More info">🅘</button>
          </div>
          <div class="addon-info-popover" hidden>${addon.desc}</div>
        </div>
        ${renderPackageCell(addon,'basic',false)}
        ${renderPackageCell(addon,'pro',false)}
        ${renderPackageCell(addon,'premium',true)}
      </div>`;
    });
  });
  container.innerHTML = html;

  // Sidebar uses state.stateFee directly — also refresh fee-display chips in header
  document.querySelectorAll('.state-fee-display').forEach(el => el.textContent = fee);
}

/* Toggle the 🅘 popover next to an addon label */
function toggleAddonInfo(btn){
  const pop = btn.closest('.pkg-cell').querySelector('.addon-info-popover');
  if(!pop) return;
  const isHidden = pop.hasAttribute('hidden');
  if(isHidden){ pop.removeAttribute('hidden'); btn.setAttribute('aria-expanded','true'); }
  else        { pop.setAttribute('hidden',''); btn.setAttribute('aria-expanded','false'); }
}

/* ==========  STATE DROPDOWN INIT  ========== */
function initStates(){
  const sel = $('#hero-state');
  Object.keys(STATES).forEach(s=>{
    const opt=document.createElement('option');
    opt.value=s;opt.textContent=s;
    if(s==='Florida')opt.selected=true;
    sel.appendChild(opt);
  });
}

/* ==========  HOMEPAGE → WIZARD  ========== */
function updateHeroFee(){
  const s = $('#hero-state').value;
  const e = $('#hero-entity').value;
  const feeBox = $('#hero-fee');
  if(s && STATES[s]){
    const fee = getStateFee(s, e);
    feeBox.innerHTML = `${s} state filing fee: <strong>${fmt(fee)}</strong> <span style="color:var(--bz-g400);font-size:12px">· Paid directly to the state. Non-refundable once submitted.</span>`;
    feeBox.style.display='block';
  } else {
    feeBox.style.display='none';
  }
}

function startWizard(){
  const entity    = ($('#hero-entity') && $('#hero-entity').value) || 'LLC';
  const stateName = ($('#hero-state')  && $('#hero-state').value)  || 'Florida';

  // Hero-only page (no #screen-wizard in DOM): redirect to the wizard URL,
  // passing entity + state as query params so the wizard page can preselect.
  if(!document.querySelector('#screen-wizard')){
    const base = (BJWD && BJWD.wizard_url) ? BJWD.wizard_url : '/incorporation/';
    const sep  = base.indexOf('?') === -1 ? '?' : '&';
    window.location.href = base + sep + 'entity=' + encodeURIComponent(entity) + '&state=' + encodeURIComponent(stateName);
    return;
  }

  // Same-page mode (view="auto"): toggle from hero to wizard inline.
  state.entity = entity;
  state.stateName = stateName;
  refreshStateFee();
  $$('.state-fee-display').forEach(el=>el.textContent=fmt(state.stateFee));
  if($('#banner-entity')) $('#banner-entity').textContent = state.entity;
  if($('#banner-state'))  $('#banner-state').textContent  = state.stateName;
  if($('#screen-home'))   $('#screen-home').style.display='none';
  $('#screen-wizard').classList.add('active');
  setStep(1);
  window.scrollTo(0,0);
}

function goHome(){
  // If hero exists on the page, toggle back to it. Otherwise (wizard-only
  // page), navigate to the site root.
  if($('#screen-home')){
    $('#screen-home').style.display='block';
    $('#screen-wizard').classList.remove('active');
    window.scrollTo(0,0);
  } else {
    window.location.href = '/';
  }
}

/* ==========  STEP NAVIGATION  ========== */
function setStep(n){
  state.currentStep = n;
  $$('.step').forEach(el=>el.classList.remove('active'));
  const target = $('#step-'+n);
  if(target)target.classList.add('active');
  // progress
  const pct = Math.min(100,(n/state.totalSteps)*100);
  $('#progress-fill').style.width = pct+'%';
  window.scrollTo(0,0);
  renderSidebar();
  populateStateSelects();
  if(n===1) renderPackageRows();
  if(n===2) applyDesignators();
  if(n===3) setupFilingDates();
  if(n===4) initContactStep();
  if(n===5) initAddressStep();
  if(n===6){
    // skip premium bundle if Premium plan already includes it
    if(state.plan && state.plan.id==='premium'){
      setTimeout(()=>nextStep(),50);
    }
  }
  if(n===7) renderMembers();
  if(n===12){
    const ls=$('#license-state'); if(ls) ls.textContent=state.stateName;
  }
  if(n===13) renderReview();
}

function nextStep(){ setStep(state.currentStep+1); }
function prevStep(){ if(state.currentStep>1) setStep(state.currentStep-1); }

/* ==========  STEP 1 — package + inline addons  ========== */
function selectPlan(planId){
  state.plan = {id:planId,...PLANS[planId]};
  // visual selected state
  $$('.pkg-select').forEach(b=>b.classList.remove('selected'));
  event.target.classList.add('selected');
  renderSidebar();
  // auto-advance after a short pause
  setTimeout(()=>nextStep(),500);
}

function toggleInlineAddon(btn,id,price){
  event.stopPropagation();
  if(state.inlineAddons[id]){
    delete state.inlineAddons[id];
    btn.classList.remove('added');
    btn.textContent = '+$'+price;
  } else {
    state.inlineAddons[id] = {id,price,label:labelFor(id)};
    btn.classList.add('added');
    btn.textContent = '✓ Added';
  }
  renderSidebar();
}
function labelFor(id){
  return {form2553:'IRS Form 2553',expedited:'Expedited Filing',contracts:'Compliance Templates'}[id]||id;
}

/* ==========  STEP 3 — filing time  ========== */
function selectFilingTime(card,type,price){
  $$('#step-3 .radio-card').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  state.filingTime = {type,price};
  $('#filing-next').disabled = false;
  renderSidebar();
}

/* ==========  STEP 4 — virtual address  ========== */
function selectVirtualAddress(card,useVirtual){
  $$('#step-5 .radio-card').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  state.address.useVirtualAddress = useVirtual;
  renderSidebar();
}

/* ==========  STEP 5 — bundle  ========== */
function acceptBundle(){state.premiumBundle={price:99};renderSidebar();nextStep();}
function declineBundle(){state.premiumBundle=null;renderSidebar();nextStep();}

/* ==========  STEP 6 — members  ========== */
function changeMemberCount(n){
  const c = parseInt(n);
  state.members = [];
  const pct = Math.floor(100/c);
  for(let i=0;i<c;i++){
    state.members.push({type:'individual',firstName:'',lastName:'',useAssignedAddress:true,ownership: i===c-1 ? 100-pct*(c-1) : pct});
  }
  renderMembers();
}
function renderMembers(){
  const list = $('#members-list'); if(!list) return;
  // populate title with biz name
  const t = $('#members-title');
  if(t) t.textContent = 'Please provide Members Information for '+(state.business.name||'Your Business')+' '+state.business.designator;

  list.innerHTML = state.members.map((m,i)=>`
    <div style="background:var(--bz-g100);padding:6px 14px;border-radius:var(--radius-pill);display:inline-block;font-size:13px;font-weight:600;color:var(--bz-blue-text);background:var(--bz-blue-pill);margin:24px 0 16px">Member ${i+1}</div>
    <div class="radio-cards">
      <div class="radio-card ${m.type==='individual'?'selected':''}" onclick="setMemberType(${i},'individual')">
        <div class="radio-card-dot"></div>
        <div class="radio-card-body"><div class="radio-card-title">Individual</div><div class="radio-card-sub">Select if Member is a person.</div></div>
      </div>
      <div class="radio-card ${m.type==='company'?'selected':''}" onclick="setMemberType(${i},'company')">
        <div class="radio-card-dot"></div>
        <div class="radio-card-body"><div class="radio-card-title">Company</div><div class="radio-card-sub">Select if Member is a company.</div></div>
      </div>
    </div>
    ${state.address.useVirtualAddress?`
    <label style="display:flex;gap:10px;align-items:center;padding:14px 16px;border:1px solid var(--bz-g200);border-radius:var(--radius-md);background:#fff;font-size:14px;cursor:pointer;margin-bottom:16px">
      <input type="checkbox" ${m.useAssignedAddress?'checked':''} onchange="state.members[${i}].useAssignedAddress=this.checked;renderMembers()">
      <span>Use the assigned company address provided by BizJump</span>
    </label>`:''}
    <div class="field-row">
      <div class="field"><label class="field-label">First Name</label><input class="input" value="${m.firstName}" oninput="state.members[${i}].firstName=this.value"></div>
      <div class="field"><label class="field-label">Last Name</label><input class="input" value="${m.lastName}" oninput="state.members[${i}].lastName=this.value"></div>
    </div>
    <div class="field" style="max-width:200px"><label class="field-label">Ownership %</label><input class="input" type="number" value="${m.ownership}" min="0" max="100" oninput="state.members[${i}].ownership=parseInt(this.value)||0"></div>
    ${m.useAssignedAddress && state.address.useVirtualAddress ? `<div class="info info-teal"><span class="info-icon">ⓘ</span><div>You have selected for BizJump to provide you with a company address. We will use the company address for the member information in order to shield your personal information from being publicly available.</div></div>`:''}
  `).join('');
}
function setMemberType(i,type){state.members[i].type=type;renderMembers();}

/* ==========  STEP 7 — RA  ========== */
function selectRA(card,which){
  $$('#step-8 .radio-card').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  state.registeredAgent = which;
  // set state name in copy
  const rn = $('#ra-state-name'); if(rn) rn.textContent=state.stateName;
  const re = $('#ra-entity-name'); if(re) re.textContent=state.entity;
  renderSidebar();
}

/* ==========  STEP 8 — EIN  ========== */
function setEINForeign(card,yes){
  $$('#step-9 .radio-cards').forEach((rcs,idx)=>{if(idx===0){rcs.querySelectorAll('.radio-card').forEach(c=>c.classList.remove('selected'));}});
  card.classList.add('selected');
  state.ein.isForeign=yes;
}
function setEINIdType(card,type){
  $$('#step-9 .radio-cards')[1].querySelectorAll('.radio-card').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  state.ein.idType=type;
}
function setEINAddr(card,which){
  $$('#step-9 .radio-cards')[2].querySelectorAll('.radio-card').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  state.ein.irsAddress=which;
}

/* ==========  STEP 9 — banking  ========== */
function setBanking(choice){state.banking=choice;renderSidebar();nextStep();}

/* ==========  STEP 10 — tax consult  ========== */
function setTaxConsult(card,choice){
  $$('#step-11 .radio-card').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  state.taxConsultation=choice;
  $('#tax-next').disabled=false;
  renderSidebar();
}

/* ==========  STEP 11 — license research  ========== */
function setLicense(card,choice){
  $$('#step-12 .radio-card').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  state.licenseResearch=choice;
  // populate state name in title
  const ls=$('#license-state'); if(ls) ls.textContent=state.stateName;
  renderSidebar();
}

/* ==========  STEP 12 — review render  ========== */
function renderReview(){
  refreshStateFee();
  const root = $('#review-sections'); if(!root) return;
  const c = state.contact;
  const m = state.members;
  const bizPill = $('#review-biz-pill');
  if(bizPill) bizPill.textContent = (state.business.name||'Your Business')+' '+state.business.designator;

  const sections = [
    {title:'Formation Info', edit:1, rows:[
      ['State of Formation', state.stateName],
      ['Entity Type', state.entity]
    ]},
    {title:'Contact Info', edit:4, rows:[
      ['Full Name', (c.firstName+' '+c.lastName).trim()||'—'],
      ['Address', [c.street1,c.city,c.state,c.zip].filter(Boolean).join(', ')||'—'],
      ['Phone Number', c.phone||'—'],
      ['Email Address', c.email||'—']
    ]},
    {title:'Agent Info', edit:8, rows:[
      [state.registeredAgent==='bizjump'?'You have selected BizJump to provide you with a Registered Agent.':'You are your own Registered Agent.', state.registeredAgent==='bizjump'?'First Year Free':'']
    ]},
    {title:'Company Info', edit:2, rows:[
      ['Company Name', (state.business.name||'—')+' '+state.business.designator],
      ['Business Purpose', state.business.purpose||'—'],
      ['NAICS', state.business.naics||'—']
    ]},
    {title:'Member Info', edit:7, members: m},
  ];
  if(state.licenseResearch==='yes'){
    sections.push({title:'Business Licenses and Permits', edit:12, rows:[['Research this location', state.stateName]]});
  }
  if(state.plan && state.plan.id!=='basic'){
    sections.push({title:'EIN / Tax Info', edit:9, rows:[
      ['Name', (state.ein.firstName||'')+' '+(state.ein.lastName||'')||(c.firstName+' '+c.lastName)],
      ['ID Type', state.ein.idType?.toUpperCase()||'SSN'],
      ['ID Number', state.ein.idNumber||'—']
    ]});
  }

  root.innerHTML = sections.map(s=>`
    <div style="padding:18px 0;border-bottom:1px solid var(--bz-g200)">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
        <h3 style="font-size:15px;font-weight:700;color:var(--bz-black)">${s.title}</h3>
        <a href="#" onclick="setStep(${s.edit});return false" style="font-size:13px;color:var(--bz-orange);font-weight:600">Edit</a>
      </div>
      ${s.rows?s.rows.map(r=>`<div style="display:flex;justify-content:space-between;font-size:14px;padding:4px 0"><span style="color:var(--bz-g600)">${r[0]}</span><span style="color:var(--bz-g900);font-weight:500;text-align:right">${r[1]}</span></div>`).join(''):''}
      ${s.members?s.members.map((mem,i)=>`<div style="background:var(--bz-blue-pill);color:var(--bz-blue-text);padding:5px 12px;border-radius:var(--radius-pill);display:inline-block;font-size:12px;font-weight:600;margin:8px 0 4px">Member ${i+1}</div><div style="display:flex;justify-content:space-between;font-size:14px;padding:4px 0"><span style="color:var(--bz-g600)">Name</span><span style="color:var(--bz-g900);font-weight:500">${(mem.firstName+' '+mem.lastName).trim()||'—'}</span></div><div style="display:flex;justify-content:space-between;font-size:14px;padding:4px 0"><span style="color:var(--bz-g600)">Ownership</span><span style="color:var(--bz-g900);font-weight:500">${mem.ownership}%</span></div>`).join(''):''}
    </div>
  `).join('');
}

/* ==========  STEP 14 — confirmation populate  ========== */
function populateConfirmation(){
  refreshStateFee();
  const c = state.contact;
  $('#confirm-name').textContent = c.firstName||'friend';
  $('#confirm-biz-name').textContent = (state.business.name||'Your Business')+' '+state.business.designator;
  $('#confirm-state').textContent = state.stateName;
  $('#confirm-plan').textContent = state.plan?.label||'—';
  $('#confirm-order-num').textContent = 'BJ-'+Math.floor(100000+Math.random()*900000);

  // compute total
  let total = (state.plan?.price||0) + state.stateFee;
  Object.values(state.inlineAddons).forEach(a=>total+=a.price);
  if(state.filingTime) total += state.filingTime.price;
  if(state.premiumBundle) total += state.premiumBundle.price;
  if(state.licenseResearch==='yes') total += 99;
  $('#confirm-total').textContent = fmt(total);
}

/* ==========  SIDEBAR RENDER  ========== */
function renderSidebar(){
  refreshStateFee();
  const sidebars = $$('.sidebar-root');
  if(!sidebars.length) return;
  let lines=[];
  lines.push(`<div class="sidebar-line"><span class="label">Entity Type</span><span class="val">${state.entity}</span></div>`);
  if(state.plan){
    lines.push(`<div class="sidebar-line"><span class="label">${state.plan.label} Package</span><span class="val">${fmt(state.plan.price)}</span></div>`);
  }
  lines.push(`<div class="sidebar-line"><span class="label">${state.stateName} State Filing Fee</span><span class="val">${fmt(state.stateFee)}</span></div>`);

  Object.values(state.inlineAddons).forEach(a=>{
    lines.push(`<div class="sidebar-line"><span class="label">${a.label}</span><span class="val">${fmt(a.price)}</span></div>`);
  });

  // filing time
  if(state.filingTime){
    if(state.filingTime.price>0){
      lines.push(`<div class="sidebar-line"><span class="label">Expedited Filing</span><span class="val">${fmt(state.filingTime.price)}</span></div>`);
    }
  }
  // virtual address (shown once user has reached the address step)
  if(state.address.useVirtualAddress && state.currentStep>=5){
    lines.push(`<div class="sidebar-line"><span class="label">Business Address (1st Month)</span><span class="val free">Free</span></div>`);
  }
  // premium bundle
  if(state.premiumBundle){
    lines.push(`<div class="sidebar-line"><span class="label">Premium Upgrade</span><span class="val">${fmt(state.premiumBundle.price)}</span></div>`);
    lines.push(`<div class="sidebar-line"><span class="label">Compliance Templates</span><span class="val free">Free</span></div>`);
    lines.push(`<div class="sidebar-line"><span class="label">Business Phone Service</span><span class="val free">Free</span></div>`);
  }
  // included service indicators based on plan
  const planId = state.plan?.id;
  const inclEIN = planId && planId!=='basic';
  const inclOA = planId && planId!=='basic';
  if(inclOA){
    const passed = state.currentStep>4;
    lines.push(`<div class="sidebar-line"><span class="label">Operating Agreement</span><span class="sidebar-icon ${passed?'check':'empty'}"></span></div>`);
  }
  if(inclEIN){
    const passed = state.currentStep>9;
    lines.push(`<div class="sidebar-line"><span class="label">EIN / Tax ID #</span><span class="sidebar-icon ${passed?'check':'empty'}"></span></div>`);
  }
  // banking
  if(state.banking==='yes'){
    lines.push(`<div class="sidebar-line"><span class="label">Business Banking</span><span class="sidebar-icon check"></span></div>`);
  }
  // RA
  if(state.currentStep>=7 && state.registeredAgent==='bizjump'){
    lines.push(`<div class="sidebar-line"><span class="label">Registered Agent (1st Year)</span><span class="val free">Free</span></div>`);
  }
  // license
  if(state.licenseResearch==='yes'){
    lines.push(`<div class="sidebar-line"><span class="label">License Research</span><span class="val">$99</span></div>`);
  }
  // tax consultation (free)
  if(state.taxConsultation==='yes'){
    lines.push(`<div class="sidebar-line"><span class="label">Tax Consultation</span><span class="val free">Free</span></div>`);
  }

  // phone support always-on
  lines.push(`<div class="sidebar-phone-support">Phone Support<span class="hours">Available Monday – Friday<br>9 A.M. – 6 P.M. CST</span></div>`);

  // total
  let total = 0;
  if(state.plan) total += state.plan.price;
  total += state.stateFee;
  Object.values(state.inlineAddons).forEach(a=>total+=a.price);
  if(state.filingTime) total += state.filingTime.price;
  if(state.premiumBundle) total += state.premiumBundle.price;
  if(state.licenseResearch==='yes') total += 99;

  // business name pill at top of sidebar at step 13
  const pill = (state.currentStep>=12 && state.business.name)
    ? `<div class="sidebar-biz-pill">${state.business.name} ${state.business.designator}</div>` : '';

  const showAction = state.currentStep===13;

  const html = `
    ${pill}
    <div class="sidebar-title">Order Summary</div>
    ${lines.join('')}
    <div class="sidebar-total"><span class="label">Total:</span><span class="val">${fmt(total)}</span></div>
    ${state.registeredAgent==='bizjump'&&state.currentStep>=7?'<div class="sidebar-recurring">Year 2+: $99/yr (manual renewal). Never auto-charged.</div>':''}
    ${showAction?`
      <div class="sidebar-action">
        <label class="sidebar-terms"><input type="checkbox" id="terms-cb" onchange="state.consent.legal=this.checked"> <span>I agree to the <a href="#">Legal Statement</a> and <a href="#">Cancellation Policy</a></span></label>
        <button class="btn btn-primary btn-full" onclick="completePay()">Complete & Pay</button>
        <div class="sidebar-reviews">
          <div class="stars">★★★★½ 4.7</div>
          <div>Based on 500+ reviews</div>
          <div class="sidebar-reviews-row"><span class="badge">Trustpilot</span><span class="badge">ShopperApproved</span></div>
        </div>
      </div>
    `:''}
  `;
  sidebars.forEach(sb=>sb.innerHTML=html);
}

/* ==========  STATE DROPDOWN HELPER FOR FORMS  ========== */
function populateStateSelects(){
  $$('select.state-dropdown, #contact-state, #irs-state, #license-state, #billing-state').forEach(sel=>{
    if(!sel || sel.options.length>1)return;
    sel.innerHTML='<option value="">Select State</option>';
    Object.keys(STATES).forEach(s=>{
      const o=document.createElement('option');o.value=s;o.textContent=s;
      if(s===state.stateName)o.selected=true;
      sel.appendChild(o);
    });
  });
}

/* ==========  FILING TIME DATE COMPUTE  ========== */
function setupFilingDates(){
  refreshStateFee();
  const fsn = $('#filing-state-name'); const fsn2 = $('#filing-state-name-2'); const fst = $('#filing-state-time');
  if(fsn) fsn.textContent = state.stateName;
  if(fsn2) fsn2.textContent = state.stateName;
  const proc = STATE_PROCESSING[state.stateName] || '3 weeks';
  if(fst) fst.textContent = proc;
  // expedited fee per state
  const expedited = state.expeditedFee;
  const rushCard = $('#filing-rush-card');
  const rushPrice = $('#filing-rush-price');
  if(rushCard) rushCard.dataset.price = expedited; // inline onclick reads +this.dataset.price
  if(rushPrice) rushPrice.textContent = '$'+expedited;
  // compute dates
  const today = new Date();
  const fmtDate = d => d.toLocaleDateString('en-US',{weekday:'long',month:'long',day:'numeric'});
  function addBizDays(d,n){const r=new Date(d);let added=0;while(added<n){r.setDate(r.getDate()+1);if(r.getDay()!==0 && r.getDay()!==6)added++;}return r}
  const rushD = $('#rush-date'); const stdD = $('#std-date');
  if(rushD) rushD.textContent = fmtDate(addBizDays(today,3))+'*';
  // standard: parse "N weeks" or "N-N weeks"
  const m = proc.match(/(\d+)(?:-\d+)?\s*weeks?/);
  const weeks = m?parseInt(m[1]):3;
  const stdDate = new Date(today); stdDate.setDate(stdDate.getDate()+weeks*7);
  if(stdD) stdD.textContent = fmtDate(stdDate)+'*';
}

function completePay(){
  if(!state.consent.legal){
    alert('Please agree to the Legal Statement and Cancellation Policy to continue.');
    return;
  }

  // If running under WordPress (BJW_DATA.ajax_url is set), submit to the
  // server. The server validates, persists, builds the WC cart and returns
  // the checkout URL. Otherwise (standalone HTML demo) just show the
  // confirmation screen with computed totals.
  if(BJWD && BJWD.ajax_url){
    const fd = new FormData();
    fd.append('action', 'bjw_submit');
    fd.append('nonce',  BJWD.nonce || '');
    fd.append('state',  JSON.stringify(state));
    fetch(BJWD.ajax_url, { method:'POST', credentials:'same-origin', body:fd })
      .then(r => r.json())
      .then(res => {
        if(res && res.success && res.data && res.data.redirect){
          window.location.href = res.data.redirect;
        } else {
          const msg = (res && res.data && res.data.message) || 'Submission failed. Please review the form.';
          alert(msg);
        }
      })
      .catch(() => alert('Network error submitting wizard. Please try again.'));
    return;
  }

  populateConfirmation();
  setStep(15); // confirmation
}

/* ==========  BOOTSTRAP  ========== */
window.addEventListener('load',()=>{
  // Read entity/state from URL params first (e.g. /incorporation/?entity=LLC&state=Florida)
  // — set as defaults so wizard-only pages preselect what the user picked on the hero.
  try {
    const p = new URLSearchParams(window.location.search);
    const e = p.get('entity'); const s = p.get('state');
    if(e) state.entity    = e;
    if(s) state.stateName = s;
  } catch(_) { /* older browsers: ignore */ }

  if(document.querySelector('#hero-entity')){
    // Hero is on this page — wire its controls.
    initStates();
    $('#hero-entity').addEventListener('change',updateHeroFee);
    $('#hero-state').addEventListener('change',updateHeroFee);
    $('#hero-start').addEventListener('click',startWizard);
    // Reflect URL-supplied defaults into the hero dropdowns if they were provided.
    if($('#hero-entity') && state.entity)    $('#hero-entity').value = state.entity;
    if($('#hero-state')  && state.stateName) $('#hero-state').value  = state.stateName;
    updateHeroFee();
  } else if(document.querySelector('#screen-wizard')){
    // Wizard-only page: jump straight into the wizard, preselected.
    refreshStateFee();
    document.querySelector('#screen-wizard').classList.add('active');
    if($('#banner-entity')) $('#banner-entity').textContent = state.entity;
    if($('#banner-state'))  $('#banner-state').textContent  = state.stateName;
    $$('.state-fee-display').forEach(el=>el.textContent=fmt(state.stateFee));
    setStep(1);
  }
});
