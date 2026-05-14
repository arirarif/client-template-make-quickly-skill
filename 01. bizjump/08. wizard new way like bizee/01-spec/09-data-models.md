# 09 — Data models (new JS structures)

Every new structure that needs to land in the `<script>` block at the bottom of `index.html`.

## 1. `STATES` — per-entity fees + expedited

Replace flat `{ 'Florida': 87.50, ... }` with:

```js
const STATES = {
  'Alabama':       { llc:183, corp:183, nonprofit:183, expedited: 60 },
  'Alaska':        { llc:250, corp:250, nonprofit: 50, expedited: 85 },
  'Arizona':       { llc: 50, corp: 60, nonprofit: 40, expedited: 70 },
  'Arkansas':      { llc: 45, corp: 45, nonprofit: 50, expedited: 60 },
  'California':    { llc: 70, corp:115, nonprofit: 45, expedited:385 },
  'Colorado':      { llc: 50, corp: 50, nonprofit: 50, expedited: 60 },
  'Connecticut':   { llc:185, corp:315, nonprofit:165, expedited: 85 },
  'Delaware':      { llc: 90, corp: 89, nonprofit: 89, expedited: 85 },
  'Florida':       { llc:125, corp: 70, nonprofit: 70, expedited:135 },
  'Georgia':       { llc:100, corp:100, nonprofit:100, expedited:135 },
  'Hawaii':        { llc: 51, corp: 51, nonprofit: 26, expedited: 60 },
  'Idaho':         { llc:100, corp:100, nonprofit: 30, expedited: 75 },
  'Illinois':      { llc:150, corp:180, nonprofit: 55, expedited:135 },
  'Indiana':       { llc: 91, corp: 91, nonprofit: 30, expedited: 35 },
  'Iowa':          { llc: 50, corp: 50, nonprofit: 20, expedited: 85 },
  'Kansas':        { llc:165, corp: 90, nonprofit: 20, expedited: 35 },
  'Kentucky':      { llc: 90, corp:100, nonprofit: 58, expedited: 75 },
  'Louisiana':     { llc:105, corp:170, nonprofit:165, expedited: 65 },
  'Maine':         { llc:175, corp:145, nonprofit: 40, expedited: 85 },
  'Maryland':      { llc:125, corp:145, nonprofit:195, expedited: 85 },
  'Massachusetts': { llc:520, corp:290, nonprofit: 40, expedited: 55 },
  'Michigan':      { llc: 60, corp: 50, nonprofit: 20, expedited: 85 },
  'Minnesota':     { llc:155, corp:155, nonprofit: 90, expedited: 85 },
  'Mississippi':   { llc: 52, corp: 52, nonprofit: 52, expedited: 35 },
  'Missouri':      { llc: 52, corp: 60, nonprofit: 27, expedited: 85 },
  'Montana':       { llc: 70, corp: 70, nonprofit: 20, expedited: 55 },
  'Nebraska':      { llc:109, corp: 67, nonprofit: 22, expedited: 35 },
  'Nevada':        { llc: 75, corp: 75, nonprofit: 50, expedited:160 },
  'New Hampshire': { llc:100, corp:100, nonprofit: 25, expedited: 60 },
  'New Jersey':    { llc:130, corp:130, nonprofit: 75, expedited: 60 },
  'New Mexico':    { llc: 50, corp:100, nonprofit: 25, expedited: 35 },
  'New York':      { llc:200, corp:125, nonprofit: 75, expedited: 60 },
  'North Carolina':{ llc:127, corp:127, nonprofit: 62, expedited:135 },
  'North Dakota':  { llc:135, corp:100, nonprofit: 40, expedited: 85 },
  'Ohio':          { llc: 99, corp: 99, nonprofit: 99, expedited:135 },
  'Oklahoma':      { llc:104, corp: 50, nonprofit: 25, expedited: 60 },
  'Oregon':        { llc:100, corp:100, nonprofit: 50, expedited:135 },
  'Pennsylvania':  { llc:125, corp:125, nonprofit:125, expedited:135 },
  'Rhode Island':  { llc:156, corp:238, nonprofit:37.5,expedited: 85 },
  'South Carolina':{ llc:110, corp:235, nonprofit: 25, expedited: 35 },
  'South Dakota':  { llc:150, corp:150, nonprofit: 30, expedited: 35 },
  'Tennessee':     { llc:309, corp:105, nonprofit:100, expedited: 35 },
  'Texas':         { llc:300, corp:300, nonprofit: 25, expedited: 60 },
  'Utah':          { llc: 76, corp: 76, nonprofit: 36, expedited:110 },
  'Vermont':       { llc:125, corp:125, nonprofit:125, expedited: 85 },
  'Virginia':      { llc:103, corp: 77, nonprofit: 75, expedited:135 },
  'Washington':    { llc:180, corp:180, nonprofit: 30, expedited: 85 },
  'West Virginia': { llc:100, corp:100, nonprofit: 25, expedited: 60 },
  'Wisconsin':     { llc:130, corp:100, nonprofit: 35, expedited:135 },
  'Wyoming':       { llc:102, corp:102, nonprofit: 25, expedited: 35 },

  // PLACEHOLDER — client to confirm
  'District of Columbia': { llc:220, corp:220, nonprofit: 80, expedited: 50 }
};
```

## 2. `PLANS` — 3 tiers only

```js
const PLANS = {
  basic:   { label:'Basic',   price: 99,  speed:'7 days'   },
  pro:     { label:'Pro',     price:195,  speed:'2 days'   },
  premium: { label:'Premium', price:395,  speed:'24 hours' }
};
```

## 3. `DESIGNATORS` — per entity

```js
const DESIGNATORS = {
  'LLC':            ['LLC', 'LIMITED LIABILITY COMPANY'],
  'C-Corporation':  ['INC', 'CORPORATION', 'INCORPORATED', 'CORP'],
  'S-Corporation':  ['INC', 'CORPORATION', 'INCORPORATED', 'CORP'],
  'Nonprofit':      ['INC', 'CORPORATION', 'INCORPORATED', 'CORP']
};
```

## 4. `ADDONS` — Step 1 feature table rows

```js
const ADDONS = [
  // section A — Corporate Add-Ons + Compliance
  { id:'expedited_filing', section:'corporate', label:'Bizjump Expedited Filing',
    desc:'Priority processing and fast-track submission to the state for approval. Standard state filing may take 2–3 weeks, while most states offer fee-based expedited service that can reduce formation time to as little as 1–3 business days.',
    price:{ basic:25,  pro:'included', premium:'included' }, entities:'all' },
  { id:'ein',  section:'corporate', label:'EIN Business Tax Number',
    desc:'We obtain your IRS Employer Identification Number for banking, payroll, and taxes. Required for most business entities.',
    price:{ basic:75,  pro:'included', premium:'included' }, entities:'all' },
  { id:'ra',   section:'corporate', label:'Registered Agent Service',
    desc:'We receive legal notices and state correspondence on your behalf and forward them to you.',
    price:{ basic:'99/year', pro:'99/year', premium:'included' }, entities:'all' },
  { id:'compliance_alerts', section:'corporate', label:'Compliance Alerts',
    desc:'Ongoing Email reminders for Secretary of State compliance reports, deadlines, and required filings.',
    price:{ basic:75,  pro:'included', premium:'included' }, entities:'all' },
  { id:'corp_kit', section:'corporate', label:'Executive Corporate Kit',
    desc:'Physical binder with printed documents, stock certificates, and company seal.',
    price:{ basic:125, pro:125, premium:75 }, entities:'all' },
  { id:'bylaws', section:'corporate', label:'Corporate Bylaws',
    desc:'Governing rules for corporations including officers, meetings, and voting.',
    price:{ basic:75,  pro:75, premium:'included' },
    entities:['C-Corporation','S-Corporation'] },
  { id:'oa', section:'corporate', label:'Operating Agreement',
    desc:'Legal document defining ownership, roles, and management structure of your LLC. Often required by banks.',
    price:{ basic:75,  pro:75, premium:'included' },
    entities:['LLC'] },
  { id:'shareholder', section:'corporate', label:'Shareholder Agreement',
    desc:'Defines shareholder rights, ownership transfers, and dispute resolution.',
    price:{ basic:75,  pro:75, premium:'included' },
    entities:['C-Corporation','S-Corporation'] },
  { id:'bank_setup', section:'corporate', label:'Business Bank Account Setup',
    desc:'Assistance opening your business bank account with required documentation.',
    price:{ basic:150, pro:150, premium:150 }, entities:'all' },

  // section B — Business and Taxes
  { id:'form_2553', section:'taxes', label:'IRS Form 2553 (S-Corp Election)',
    desc:'File IRS election for S-Corporation taxation (pass-through taxation). Owners must be U.S. citizens or residents.',
    price:{ basic:75,  pro:75, premium:75 },
    entities:['S-Corporation'] },
  { id:'501c3', section:'taxes', label:'IRS EZ-501(c)(3) Tax-Exempt Filing',
    desc:'We prepare and file for federal tax-exempt status with the IRS.',
    price:{ basic:395, pro:395, premium:395 },
    entities:['Nonprofit'] },
  { id:'first_year_cpa', section:'taxes', label:'First Year Tax Filing (CPA)',
    desc:'CPA prepares and files first-year business tax return (70% discount). Personal taxes separate for C-Corp & S-Corp.',
    price:{ basic:200, pro:200, premium:200 }, entities:'all' },
  { id:'biz_plan', section:'taxes', label:'Business Plan Consultation',
    desc:'Professional guidance to help refine your business idea, research startup requirements including licensing, and overall business plan structure, including SWOT analysis. Deliverable includes a 3–5-page business plan summary document prepared after completion of a short questionnaire.',
    price:{ basic:175, pro:175, premium:175 }, entities:'all' },
  { id:'accounting', section:'taxes', label:'Accounting System Setup & Tax Planning',
    desc:'Setup accounting structure and provide basic tax planning guidance.',
    price:{ basic:125, pro:125, premium:'included' }, entities:'all' },

  // section C — Website and Marketing
  { id:'website', section:'web', label:'Basic Corporate Website',
    desc:'Professional 5-page website with hosting and ongoing maintenance.',
    price:{ basic:'free+29mo', pro:'free+29mo', premium:'free+29mo' }, entities:'all' },
  { id:'social', section:'web', label:'Social Media Marketing Setup',
    desc:'We create and configure your business social media accounts so your brand is professionally positioned online and ready to attract customers. Includes setup of Facebook, Instagram, LinkedIn, and YouTube business accounts.',
    price:{ basic:125, pro:125, premium:125 }, entities:'all' },
  { id:'gbp', section:'web', label:'Google Business Profile Setup',
    desc:'We set up and optimize your Google Business Profile to help customers find your business online through Google Search and Maps. Includes Google Business Profile configuration and basic Google Analytics setup.',
    price:{ basic:125, pro:125, premium:125 }, entities:'all' }
];

const SECTIONS = {
  corporate: 'Corporate Add-Ons + Compliance',
  taxes:     'Business and Taxes',
  web:       'Website & Marketing'
};
```

## 5. Updated `state` shape

```js
const state = {
  entity:       'LLC',
  stateName:    'Florida',
  stateFee:     0,           // computed from STATES[stateName][entity-key]
  expeditedFee: 0,           // computed from STATES[stateName].expedited

  plan:         null,        // {id,label,price,speed}
  inlineAddons: {},          // keyed by ADDON id
  filingTime:   null,        // {type:'rush'|'standard', price}

  business: { name:'', designator:'LLC', purpose:'', naics:'' },

  // NEW — contact-person (Step 3b)
  contact: {
    firstName:'', lastName:'', email:'', phone:'',
    street1:'', street2:'', city:'', state:'', county:'',
    country:'US', zip:''
  },

  // address (Step 5 — was Step 4)
  address: {
    useVirtualAddress: true,
    sameAsContact:     true,   // NEW
    firstName:'', lastName:'', email:'', phone:'',
    street1:'', street2:'', city:'', state:'',
    country:'US', zip:''
  },

  premiumBundle: null,
  members:       [],
  registeredAgent:'bizjump',
  ein:           { isForeign:false, idType:'ssn', idNumber:'', irsAddress:'company', firstName:'', lastName:'' },
  banking:       null,
  taxConsultation:null,
  licenseResearch:null,
  consent:       { legal:false, marketing:false, sms:false },

  currentStep:  1,
  totalSteps:   14   // was 13 — bumped for new Contact step
};
```

## 6. Helper functions to add

```js
function getStateFee(stateName, entity){
  const r = STATES[stateName]; if(!r) return 0;
  if(entity==='LLC')        return r.llc;
  if(entity==='Nonprofit')  return r.nonprofit;
  return r.corp;  // C-Corp and S-Corp both use corp filing fee
}
function getExpeditedFee(stateName){ return STATES[stateName]?.expedited ?? 50; }

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
```
