# 04 — Add-Ons (All 14 — with Conditional Logic)

> **Source:** Client doc Step 3.1 "Customize Your Order"
>
> Each add-on has specific show/hide rules based on which entity type and plan the user already chose. The wizard plugin must respect this.

---

## The Full Add-On List

| # | Add-On | Price | Description | Show When | Hide When | Auto-Select |
|---|---|---|---|---|---|---|
| 1 | **Operating Agreement** | +$35 | Legal document defining ownership, roles, and management structure of your LLC. Often required by banks. | Entity = LLC | Plan = Pro or Premium (already includes it) | — |
| 2 | **EIN Filing** | +$30 | We obtain your IRS Employer Identification Number for banking, payroll, and taxes. Required for most business entities. | All entities | — | Auto-select if Pro/Premium plan (allow uncheck) |
| 3 | **Registered Agent** | +$99/year | We receive legal notices and state correspondence on your behalf and forward them to you. | All entities | Plan = Enterprise | — |
| 4 | **Annual Compliance Alerts** | +$25 | Email reminders for annual reports, deadlines, and required filings. | All | Plan = Premium or Enterprise | — |
| 5 | **Corporate Bylaws** | +$45 | Governing rules for corporations including officers, meetings, and voting. | Entity = C-Corp or S-Corp | All other entities | — |
| 6 | **Corporate Shareholder Agreement** | +$95 | Defines shareholder rights, ownership transfers, and dispute resolution. | Entity = C-Corp or S-Corp | All other entities | — |
| 7 | **Bank Account Setup** | +$200 | Assistance opening your business bank account with required documentation. | Always visible | — | — |
| 8 | **IRS Form 2553 — S-Corp Election** | +$35 | File IRS election for S-Corporation taxation (pass-through). Owners must be U.S. citizens or residents. | Entity = LLC or C-Corp | Already included in plan | Auto-select if user chose S-Corp taxation |
| 9 | **Executive Corporate Kit** | +$99 | Professional binder with seal, stock certificates, and corporate documents. | Entity = LLC, C-Corp, or S-Corp | Entity = Non-Profit | — |
| 10 | **Accounting System Setup & Tax Planning** | +$25 | Setup accounting structure and provide basic tax planning guidance. | Always visible | — | — |
| 11 | **First Year Corporate Tax Filing (CPA)** | +$195 | CPA prepares and files first-year business tax return (60–70% discount). Personal taxes separate. | All entities | Entity = Non-Profit | — |
| 12 | **Corporate Website (5 pages)** | Free + **$29/month** | Professional 5-page website with hosting and management. | Always visible | Plan = Enterprise (already included) | — |
| 13 | **Digital Marketing Setup** | +$95 | Create and configure social media accounts and Google Business profile. Includes: Facebook, Instagram, LinkedIn, YouTube, Google Business, Analytics. | Always visible | — | — |
| 14 | **IRS EZ-501(c)(3) Filing** | +$395 | Preparation and submission of nonprofit tax-exempt application. | Entity = Non-Profit ONLY | All other entities | — |

---

## JavaScript Logic Map (for wizard)

```js
const addons = [
  { id: 'op_agreement', label: 'Operating Agreement', price: 35, recurring: false,
    showIf: (entity, plan) => entity === 'LLC' && !['Pro','Premium','Enterprise'].includes(plan) },

  { id: 'ein', label: 'EIN Filing', price: 30, recurring: false,
    showIf: () => true,
    autoSelect: (entity, plan) => ['Pro','Premium','Enterprise'].includes(plan) },

  { id: 'reg_agent', label: 'Registered Agent', price: 99, recurring: 'yearly',
    showIf: (entity, plan) => plan !== 'Enterprise' },

  { id: 'compliance_alerts', label: 'Annual Compliance Alerts', price: 25, recurring: false,
    showIf: (entity, plan) => !['Premium','Enterprise'].includes(plan) },

  { id: 'bylaws', label: 'Corporate Bylaws', price: 45, recurring: false,
    showIf: (entity) => ['C-Corp','S-Corp'].includes(entity) },

  { id: 'shareholder', label: 'Corporate Shareholder Agreement', price: 95, recurring: false,
    showIf: (entity) => ['C-Corp','S-Corp'].includes(entity) },

  { id: 'bank_setup', label: 'Bank Account Setup', price: 200, recurring: false,
    showIf: () => true },

  { id: 'form_2553', label: 'IRS Form 2553 (S-Corp Election)', price: 35, recurring: false,
    showIf: (entity) => ['LLC','C-Corp'].includes(entity) },

  { id: 'corp_kit', label: 'Executive Corporate Kit', price: 99, recurring: false,
    showIf: (entity) => ['LLC','C-Corp','S-Corp'].includes(entity) },

  { id: 'accounting', label: 'Accounting System Setup', price: 25, recurring: false,
    showIf: () => true },

  { id: 'cpa_filing', label: 'First Year Tax Filing (CPA)', price: 195, recurring: false,
    showIf: (entity) => entity !== 'Non-Profit' },

  { id: 'website', label: 'Corporate Website (5 pages)', price: 0, recurring: 'monthly', recurringPrice: 29,
    showIf: (entity, plan) => plan !== 'Enterprise' },

  { id: 'marketing', label: 'Digital Marketing Setup', price: 95, recurring: false,
    showIf: () => true },

  { id: 'irs_501c3', label: 'IRS EZ-501(c)(3) Filing', price: 395, recurring: false,
    showIf: (entity) => entity === 'Non-Profit' },
];
```

---

## Add-Ons Visible by Entity Type (Quick Reference)

### LLC
- Operating Agreement (if Basic plan)
- EIN Filing
- Registered Agent
- Annual Compliance Alerts
- Bank Account Setup
- IRS Form 2553
- Executive Corporate Kit
- Accounting System Setup
- First Year Tax Filing (CPA)
- Corporate Website
- Digital Marketing Setup

### C-Corp
- EIN Filing
- Registered Agent
- Annual Compliance Alerts
- **Corporate Bylaws**
- **Corporate Shareholder Agreement**
- Bank Account Setup
- IRS Form 2553
- Executive Corporate Kit
- Accounting System Setup
- First Year Tax Filing (CPA)
- Corporate Website
- Digital Marketing Setup

### S-Corp
- EIN Filing
- Registered Agent
- Annual Compliance Alerts
- **Corporate Bylaws**
- **Corporate Shareholder Agreement**
- Bank Account Setup
- Executive Corporate Kit
- Accounting System Setup
- First Year Tax Filing (CPA)
- Corporate Website
- Digital Marketing Setup

### Non-Profit
- EIN Filing
- Registered Agent
- Annual Compliance Alerts
- Bank Account Setup
- Accounting System Setup
- Corporate Website
- Digital Marketing Setup
- **IRS EZ-501(c)(3) Filing** (only here)
