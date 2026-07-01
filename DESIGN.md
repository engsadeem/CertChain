---
name: CertChain
description: Professional academic certificate verification and issuance UI for universities.
colors:
  primary-action: "#2563EB"
  primary-hover: "#1D4ED8"
  primary-soft: "#EFF5FF"
  primary-border: "#DBE7FE"
  proof-success: "#059669"
  proof-success-soft: "#ECFDF5"
  review-warning: "#D97706"
  review-warning-soft: "#FFFBEB"
  risk-error: "#E11D48"
  risk-error-soft: "#FFF1F2"
  app-bg: "#F6F8FB"
  surface: "#FFFFFF"
  border: "#E6EBF2"
  border-strong: "#D6DEE9"
  ink: "#0F172A"
  text-secondary: "#475569"
  text-muted: "#64748B"
  text-placeholder: "#94A3B8"
  code-panel: "#0F172A"
typography:
  display:
    fontFamily: "Playfair Display, Georgia, serif"
    fontSize: "clamp(1.9rem, 3.5vw, 2.8rem)"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.025em"
  headline:
    fontFamily: "Inter, -apple-system, sans-serif"
    fontSize: "20px"
    fontWeight: 600
    lineHeight: 1.25
    letterSpacing: "-0.02em"
  title:
    fontFamily: "Inter, -apple-system, sans-serif"
    fontSize: "15px"
    fontWeight: 600
    lineHeight: 1.35
  body:
    fontFamily: "Inter, -apple-system, sans-serif"
    fontSize: "14px"
    fontWeight: 400
    lineHeight: 1.6
  label:
    fontFamily: "Inter, -apple-system, sans-serif"
    fontSize: "13px"
    fontWeight: 500
    lineHeight: 1.3
  mono:
    fontFamily: "JetBrains Mono, monospace"
    fontSize: "12px"
    fontWeight: 500
    lineHeight: 1.6
rounded:
  sm: "8px"
  md: "10px"
  lg: "12px"
  xl: "16px"
  pill: "99px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "12px"
  lg: "16px"
  xl: "24px"
  xxl: "32px"
components:
  button-primary:
    backgroundColor: "{colors.primary-action}"
    textColor: "{colors.surface}"
    rounded: "{rounded.lg}"
    padding: "0 14px"
    height: "38px"
    typography: "{typography.label}"
  button-secondary:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.lg}"
    padding: "0 14px"
    height: "38px"
    typography: "{typography.label}"
  input-default:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.lg}"
    height: "42px"
    padding: "0 14px"
    typography: "{typography.body}"
  card-default:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.xl}"
    padding: "24px"
  badge-success:
    backgroundColor: "{colors.proof-success-soft}"
    textColor: "{colors.proof-success}"
    rounded: "{rounded.pill}"
    height: "24px"
    padding: "0 10px"
---

# Design System: CertChain

## 1. Overview

**Creative North Star: "The Registrar Console"**

CertChain should feel like a trusted university operations console: quiet, structured, and exact. The existing system uses a restrained blue and slate product shell, white work surfaces, dense tables, compact controls, and proof-oriented details such as hashes, certificate IDs, status badges, and verification records.

The public landing page can use the same identity at a larger scale, but the default register is product-first. Dashboards, forms, approvals, settings, and verification flows must serve administrative clarity before brand drama. The system explicitly rejects flashy crypto style, neon colors, gaming style, too many animations, cluttered dashboards, and confusing blockchain terminology.

**Key Characteristics:**
- Restrained institutional palette: blue for primary action and selection, semantic colors for status, slate for structure.
- Dense but readable layout: tables, side navigation, top bars, cards, and forms are built for repeated daily use.
- Proof-forward details: mono text is reserved for hashes, transaction IDs, certificate IDs, and chain metadata.
- Bilingual readiness: English and Arabic/RTL layouts must preserve scan order, control clarity, and status comprehension.

## 2. Colors

The palette is a restrained academic trust system: blue establishes action and current location, green confirms verified proof, amber marks review, rose marks risk, and slate carries the working interface.

### Primary
- **Registrar Blue** (#2563EB): Use for primary actions, active navigation, focused controls, and trusted verification CTAs. It should stay rare enough to guide the eye.
- **Authority Blue Hover** (#1D4ED8): Use only for hover, active, and selected states on primary controls.
- **Blue Ledger Tint** (#EFF5FF): Use for active nav backgrounds, low-emphasis callouts, and icon wells tied to certificate or verification actions.

### Secondary
- **Proof Green** (#059669): Use for authentic, issued, connected, and successful states. Pair with text or an icon every time.
- **Review Amber** (#D97706): Use for pending, waiting, review, and caution states. Never use amber as a decorative brand color.
- **Risk Rose** (#E11D48): Use for rejected, invalid, destructive, or failed states. Keep it precise and text-labeled.

### Neutral
- **Console Canvas** (#F6F8FB): Main app background. It keeps the dashboard quiet without drifting into cream or decorative warmth.
- **Record Surface** (#FFFFFF): Cards, tables, modals, top bars, and content panels.
- **Quiet Border** (#E6EBF2): Default separators, table lines, and card borders.
- **Strong Border** (#D6DEE9): Inputs, secondary buttons, and surfaces that need more affordance.
- **Academic Ink** (#0F172A): Primary text and high-value data.
- **Operational Slate** (#475569): Secondary text, helper copy, and table metadata.
- **Muted Slate** (#64748B): Lower-emphasis copy. Verify contrast before using it on tinted surfaces.
- **Hash Panel Ink** (#0F172A): Dark mono panels for hashes or transaction proof.

### Named Rules

**The Proof Color Rule.** Status color is never color alone. Every success, warning, or error state must include text, an icon, or both.

**The Blue Is Direction Rule.** Registrar Blue is for action, focus, and location. It is not ambient decoration.

## 3. Typography

**Display Font:** Playfair Display, with Georgia fallback.
**Body Font:** Inter, with system sans fallback.
**Label/Mono Font:** JetBrains Mono for certificate IDs, hashes, and chain records.

**Character:** Inter carries the product because it is neutral, compact, and trustworthy. Playfair is already present and should remain limited to public or verification hero headings where an academic tone helps; it should not appear in labels, buttons, tables, or dense product controls.

### Hierarchy
- **Display** (700, clamp(1.9rem, 3.5vw, 2.8rem), 1.2): Public page section headings and verification hero headings only.
- **Headline** (600, 20px, 1.25): Dashboard page titles and major panel headings.
- **Title** (600, 15px, 1.35): Card titles, table titles, settings section titles, and modal titles.
- **Body** (400, 14px, 1.6): Form hints, descriptions, profile metadata, and dashboard explanatory copy. Cap prose at 65-75ch.
- **Label** (500, 13px, 1.3): Field labels, nav items, table labels, compact buttons, and tabs.
- **Mono** (500, 12px, 1.6): Certificate IDs, hashes, transaction addresses, chain timestamps, and proof snippets.

### Named Rules

**The Product Type Rule.** Product screens use Inter first. Playfair belongs to public or verification storytelling, never to operational labels or data.

**The Hash Is Mono Rule.** Mono type is a proof affordance. If the text is not an identifier, hash, block, or transaction value, use Inter.

## 4. Elevation

CertChain uses a hybrid of borders and restrained shadows. Most surfaces are defined by a 1px border and light tonal separation; shadows are small and structural, used for cards, top-level modals, active tabs, and hover feedback. Avoid wide ambient shadows that make the tool feel decorative.

### Shadow Vocabulary
- **Hairline Lift** (`box-shadow: 0 1px 2px rgba(15, 23, 42, .04)`): Secondary buttons and tiny active states.
- **Surface Lift** (`box-shadow: 0 1px 3px rgba(15, 23, 42, .06), 0 1px 2px rgba(15, 23, 42, .04)`): Cards, active tabs, and compact panels.
- **Dialog Lift** (`box-shadow: 0 4px 12px rgba(15, 23, 42, .08), 0 1px 2px rgba(15, 23, 42, .04)`): Modals, dropdown-like panels, and selected proof results.

### Named Rules

**The Structural Shadow Rule.** Shadows must explain layering or state. Never combine a decorative wide shadow with a decorative border on the same card.

## 5. Components

### Buttons
- **Shape:** Gently squared product controls (12px radius), with small buttons at 8px.
- **Primary:** Registrar Blue background with white text, 38px height, 13.5px semibold Inter, and compact horizontal padding.
- **Hover / Focus:** Hover deepens to Authority Blue Hover. Focus uses a visible blue ring (`0 0 0 3-4px rgba(59, 125, 247, .1)`) without layout shift.
- **Secondary / Ghost:** Secondary buttons are white with Strong Border and Hairline Lift. Ghost buttons are transparent and become slate-tinted on hover.

### Chips
- **Style:** Pills use semantic background tints and darker semantic text. They are compact, text-labeled, and often paired with 12-14px icons.
- **State:** Success, warning, and error badges must include visible labels such as Issued, Pending, Invalid, Authentic, or Not authentic.

### Cards / Containers
- **Corner Style:** Dashboard cards use 16px radius. Smaller panels and proof boxes use 10-12px.
- **Background:** Record Surface over Console Canvas.
- **Shadow Strategy:** Surface Lift at rest, Dialog Lift only for modal or result emphasis.
- **Border:** Quiet Border at rest; semantic borders only for status panels.
- **Internal Padding:** 20-28px for cards, 14-18px for compact callouts, 24px for table headers or card bodies.

### Inputs / Fields
- **Style:** 42px high, white background, 1.5px Strong Border, 12px radius, Inter 14px text.
- **Focus:** Registrar Blue border with a soft blue focus ring.
- **Error / Disabled:** Error uses Risk Rose border plus an explicit message. Disabled and read-only use Console Canvas or slate-tinted backgrounds with readable text.

### Navigation
- **Style:** Left sidebar at 248px with white background, Quiet Border, 14px Inter nav labels, and 10px item radius.
- **Default / Hover / Active:** Default nav uses Operational Slate, hover uses a slate tint and Academic Ink, active uses Blue Ledger Tint with Authority Blue text.
- **Mobile Treatment:** Collapse the sidebar into a top or drawer navigation before content becomes cramped. Preserve route labels and icons for RTL.

### Tables
- **Style:** Tables are the primary operational surface. Headers use slate-tinted rows and compact labels; rows use clear separators and stable action cells.
- **Data:** Certificate IDs and hashes use JetBrains Mono. Student names, roles, dates, and statuses use Inter.
- **Empty States:** Empty rows must explain what is missing and offer the next action when one exists.

### Verification Results
- **Style:** Authentic results use Proof Green with icon, status text, issuer data, and chain metadata. Invalid results use Risk Rose with a clear plain-language explanation.
- **Language:** Say "verified proof", "certificate ID", "issuer", and "transaction record" before blockchain jargon.

## 6. Do's and Don'ts

### Do:
- **Do** keep dashboards calm, scannable, and professional, with consistent buttons, table actions, and status badges.
- **Do** support Arabic/RTL and English by using logical layout thinking, mirrored navigation, readable line lengths, and labels that do not depend on left-to-right order.
- **Do** pair every status color with text or an icon so color-blind users can read Issued, Pending, Invalid, Authentic, and Not authentic states.
- **Do** keep blockchain language plain. Use hashes and transactions as proof details, not as the main explanation.
- **Do** keep future design edits inside `resources/views`, `resources/css`, and `resources/js` unless backend work is explicitly requested.

### Don't:
- **Don't** use flashy crypto style, neon colors, gaming style, token-project visuals, or speculative Web3 decoration.
- **Don't** add too many animations. Product transitions should be short, functional, and reduced-motion safe.
- **Don't** create cluttered dashboards. If a card, stat, or chart does not help issuing, approving, managing, or verifying certificates, remove or demote it.
- **Don't** use confusing blockchain terminology as primary copy. External verifiers should understand authenticity before they see hashes.
- **Don't** change backend logic, routes, controllers, migrations, or database behavior during design-only work.
