# 🏛️ UI/UX Design System Specification (`DESIGN.md`)
## Alumni Tracking & Community Networking System

> **Design References & Benchmark Systems:**
> 1. [Craft Docs Design System](https://styles.refero.design/style/9f228e72-997a-4410-9190-68359028e3d0) — *Warm tactile canvas, literary crafted editorial typography, multi-layered diffuse drop shadows, generous vertical whitespace.*
> 2. [Superr Design System](https://styles.refero.design/style/cfd0fec1-f25a-4b9b-9bd0-d5b66960f2f2) — *Cream paper surface, human cocoa ink, punchy marker accents, tactile 20px pill buttons, 4px baseline spacing grid.*
> 3. [Officevibe Design System](https://styles.refero.design/style/ced1c98f-d489-48f7-a01f-1fa59a07b706) — *Editorial Roman Serif with italic voice cuts, electric cobalt chromatic punctuation, deep ink navy, 100px full pill interactive controls, 80px+ section breathing room.*

---

## 📑 Table of Contents
1. [Executive Design Philosophy & Synthesis](#1-executive-design-philosophy--synthesis)
2. [Design Tokens Architecture](#2-design-tokens-architecture)
   - [2.1. Color Palette & Chromatic Punctuation](#21-color-palette--chromatic-punctuation)
   - [2.2. Typography Pairing & Modular Scale](#22-typography-pairing--modular-scale)
   - [2.3. Multi-Layer Shadows & Ambient Depth](#23-multi-layer-shadows--ambient-depth)
   - [2.4. Corner Radius & Shape Hierarchy](#24-corner-radius--shape-hierarchy)
   - [2.5. Spacing Grid & Layout Geometry](#25-spacing-grid--layout-geometry)
3. [Component Design Specifications](#3-component-design-specifications)
   - [3.1. Floating Glass Navigation Bar](#31-floating-glass-navigation-bar)
   - [3.2. Editorial Hero Section with Italic Cut](#32-editorial-hero-section-with-italic-cut)
   - [3.3. Tactile Pill Buttons & Micro-Interactions](#33-tactile-pill-buttons--micro-interactions)
   - [3.4. Multi-Layered Elevation Cards (Jobs, News, Alumni)](#34-multi-layered-elevation-cards)
   - [3.5. Form Controls, Search & Filter Inputs](#35-form-controls-search--filter-inputs)
4. [Strict Design Guidelines (Do's and Don'ts)](#4-strict-design-guidelines-dos-and-donts)
5. [Implementation Ready CSS / Tailwind Tokens](#5-implementation-ready-css--tailwind-tokens)

---

## 1. Executive Design Philosophy & Synthesis

The Alumni Tracking System synthesizes three world-class design systems curated by Refero into a cohesive, highly accessible, and visually captivating experience:

```
┌────────────────────────────────────────────────────────────────────────┐
│                      ALUMNI ATS DESIGN SYNTHESIS                       │
├────────────────────┬────────────────────┬──────────────────────────────┤
│    CRAFT DOCS      │      SUPERR        │         OFFICEVIBE           │
│  (Literary Craft)  │  (Tactile Paper)   │      (Corporate SaaS)        │
├────────────────────┼────────────────────┼──────────────────────────────┤
│ • Warm canvas tone │ • Cream paper base │ • Editorial Serif headlines  │
│   (#FFF3E7/#FBF9F5)│   (#FDFBF9)        │   with italic voice cuts     │
│ • Deep multi-layer │ • 20px pill tags   │ • Electric Cobalt & Crimson  │
│   ambient shadows  │   and buttons      │   chromatic punctuation      │
│ • Rich serif title │ • Marker Amber     │ • 100px pill buttons         │
│   negative tracking│   highlights       │ • Ink Navy (#0C1754/#0B1B3D) │
│ • Generous 96px+   │ • 4px micro        │ • 16px radius cards with     │
│   section spacing  │   spacing unit     │   subtle cream border        │
└────────────────────┴────────────────────┴──────────────────────────────┘
                                  │
                                  ▼
           ┌──────────────────────────────────────────────┐
           │      İstanbul Üniversitesi Alumni ATS        │
           │  • Academic Prestige + Digital Ergonomics    │
           │  • High-Contrast WCAG 2.1 AAA Readability    │
           │  • Tactile Pill Ergonomics + Editorial Soul  │
           └──────────────────────────────────────────────┘
```

### Core Design Pillars:
1. **The Tactile Canvas over Pure White:** Avoid stark `#FFFFFF` canvases. Use warm, natural paper tones (`#FBF9F5` in light mode, `#0B1120` / `#070D1B` in dark mode) to minimize eye fatigue during extended browsing.
2. **Editorial Dignity with Human Warmth:** Pair stately serif headlines (featuring tight negative tracking and italic expression cuts) with ultra-legible humanist sans-serif for UI controls, data grids, and body text.
3. **Single Chromatic Punctuation per View:** Draw inspiration from Officevibe: allow a single high-energy hue (İÜ Crimson `#8A1538` or Electric Cobalt `#2545FF`) to dominate the primary action, keeping the remainder of the page grounded in calm neutrals.
4. **Soft Multi-Stage Shadows over Hard Borders:** Layer multiple diffuse shadow steps (ambient + direct + contact) so cards feel naturally suspended above the canvas.

---

## 2. Design Tokens Architecture

### 2.1. Color Palette & Chromatic Punctuation

#### A. Surface & Canvas Colors
| Token Name | HEX | Purpose / Usage | Reference Inspiration |
| :--- | :---: | :--- | :--- |
| `--color-canvas-warm` | `#FBF9F5` | Primary light canvas background (never pure white) | *Craft Docs (`#FFF3E7`) & Officevibe (`#F9F8F6`)* |
| `--color-surface-paper` | `#FFFFFF` | Elevated card surfaces and modal backgrounds | *Officevibe (`--color-paper-white`)* |
| `--color-surface-tint` | `#F4EFEA` | Secondary background tint for stats bars & inputs | *Superr (`--color-dew-drop: #F7EFE9`)* |
| `--color-canvas-dark` | `#070D1B` | Primary dark mode base background | *Alumni Dark Slate Heritage* |
| `--color-surface-dark`| `rgba(15, 27, 61, 0.75)` | Dark mode glassmorphic card surfaces | *Heritage Navy Glass* |
| `--color-border-cream` | `#EBE3D7` | Subtle non-intrusive card dividers and borders | *Officevibe (`--color-cream-border: #F0E9E1`)* |

#### B. Ink & Neutral Typography
| Token Name | HEX | Purpose / Usage | Reference Inspiration |
| :--- | :---: | :--- | :--- |
| `--color-ink-deep` | `#0C1754` | Primary ink for dark elements & high-contrast titles | *Officevibe (`--color-ink-navy: #0C1754`)* |
| `--color-ink-charcoal`| `#171717` | Standard text body color (softer than #000000) | *Superr (`--color-charcoal: #171717`)* |
| `--color-ink-muted` | `#64748B` | Secondary metadata, dates, and caption typography | *Craft Docs (`--color-graphite`)* |
| `--color-ink-light` | `#F8FAFC` | Dark mode primary readable text | *High Contrast WCAG AAA* |

#### C. Chromatic Punctuation & Accents
| Token Name | HEX | Purpose / Usage | Reference Inspiration |
| :--- | :---: | :--- | :--- |
| `--color-iu-crimson` | `#8A1538` | Primary institutional action button, brand badge | *İstanbul Üniversitesi Heritage Crimson* |
| `--color-electric-blue`| `#2545FF` | Active hyperlinks, interactive focus rings, Swagger | *Officevibe (`--color-electric-cobalt: #2545FF`)* |
| `--color-heritage-gold`| `#D4AF37` | Honors, verified alumni badges, ranking stickers | *İÜ Beyazıt Heritage Gold* |
| `--color-marker-amber` | `#FF6F1E` | Urgent announcements, deadline countdown chips | *Superr (`--color-marker-orange: #FF6F1E`)* |
| `--color-mint-success` | `#10B981` | Job accepted, application submitted, active status | *Craft Docs (`--color-mint`) & Superr* |

---

### 2.2. Typography Pairing & Modular Scale

Following the Officevibe and Craft Docs discipline, **Serif** is reserved for display storytelling and H1/H2 headlines, while **Sans-Serif** powers all functional UI components, body copy, and tables.

```
Headline Structure:
[ Serif Regular ]  +  [ Serif Italic Cut ]  =  Emotional, Academic Voice
"Mezunlarımızla Güçlü,  [ Geleceğe Birlikte. ]"
```

#### Typographic Hierarchy Table
| Level | Font Family | Size | Line Height | Tracking (Letter-Spacing) | Weight | Sample Usage |
| :--- | :--- | :---: | :---: | :---: | :---: | :--- |
| **Display LG** | Serif (`Lora` / `Merriweather` / `Martina`) | `56px - 64px` | `1.08` | `-0.05em (-2.8px)` | `700 Bold` | Hero Main Headline |
| **Display SM** | Serif | `42px - 48px` | `1.15` | `-0.04em (-1.8px)` | `700 Bold` | Section Hero Banners |
| **Heading 1** | Serif or Sans Semi-Bold | `32px - 36px` | `1.25` | `-0.03em (-1.0px)` | `700 Bold` | Page Primary Headings |
| **Heading 2** | Sans (`Plus Jakarta Sans` / `Inter`) | `24px - 28px` | `1.30` | `-0.02em (-0.5px)` | `600 SemiBold` | Card Module Titles |
| **Subheading**| Sans | `18px - 20px` | `1.40` | `0px` | `600 SemiBold` | Job Role / Announcement Titles |
| **Body Large**| Sans | `16px` | `1.60` | `0px` | `400 / 500` | Introduction Paragraphs |
| **Body Regular**| Sans | `14px` | `1.50` | `0px` | `400 / 500` | Table Rows, Card Descriptions |
| **Caption/Tag**| Sans (Uppercase) | `11px - 12px` | `1.30` | `+0.05em (+0.6px)` | `700 Bold` | Badges, Status Pills, Deadlines |
| **Code / Mono**| Monospace (`JetBrains Mono`) | `12px - 13px` | `1.50` | `0px` | `500 Medium` | API Endpoints, Error Telemetry |

---

### 2.3. Multi-Layer Shadows & Ambient Depth

Avoid harsh single-point black shadows (`box-shadow: 0 4px 6px rgba(0,0,0,0.5)`). Use the **diffuse multi-layered shadow stack** popularized by Craft Docs:

```css
/* Multi-Layered Floating Shadow Token (Craft Docs Benchmark) */
--shadow-card-elevated: 
    rgba(12, 23, 84, 0.02) 0px 50px 40px 0px,
    rgba(12, 23, 84, 0.04) 0px 20px 30px 0px,
    rgba(12, 23, 84, 0.06) 0px 4px 12px 0px,
    rgba(0, 0, 0, 0.04) 0px 1px 3px 0px;

/* Subtle Surface Contact Shadow (Superr Benchmark) */
--shadow-subtle: 
    rgba(12, 23, 84, 0.05) 0px 2px 8px -2px,
    rgba(12, 23, 84, 0.03) 0px 1px 3px 0px;

/* Floating Sticky Bar Shadow */
--shadow-navbar: 
    0 10px 30px rgba(0, 0, 0, 0.08), 
    0 1px 2px rgba(0, 0, 0, 0.04);
```

---

### 2.4. Corner Radius & Shape Hierarchy

Taking the approachable **pill-shape ergonomics** from Superr (`radius-full: 20px`) and Officevibe (`radius-buttons: 100px`):

```
┌────────────────────────────────────────────────────────┐
│ [ Full Pill (100px) ]  -> Buttons, Badges, Search Bar  │
│ [ Rounded-2XL (16px) ] -> Content Cards, Form Panels   │
│ [ Rounded-3XL (24px) ] -> Hero Containers, Big Modals  │
│ [ Rounded-4XL (48px) ] -> Section Asymmetric Dividers  │
└────────────────────────────────────────────────────────┘
```

| Radius Token | Value | Applied Elements | Reference Style |
| :--- | :---: | :--- | :--- |
| `--radius-full` | `100px / 9999px` | Action buttons, CTA chips, status pills, search bar | *Officevibe & Superr* |
| `--radius-card` | `16px` | Job cards, announcement cards, profile spotlight cards | *Officevibe (`16px`) & Craft (`14px`)* |
| `--radius-input`| `12px` | Form text fields, dropdown selectors, date pickers | *Superr (`8px-12px`)* |
| `--radius-hero` | `24px - 32px` | Hero showcase cards, developer console modal | *Craft Docs (`24px`)* |
| `--radius-band` | `48px - 56px` | Footer top curve and banner wrappers | *Superr (`56px` asymmetric footer)* |

---

### 2.5. Spacing Grid & Layout Geometry

The layout is built upon an **8px vertical rhythm with a 4px micro-increment**:

* `--spacing-4`: `4px` — Micro badge icon spacing
* `--spacing-8`: `8px` — Element interior gap (icon to label)
* `--spacing-12`: `12px` — Pill button horizontal padding factor
* `--spacing-16`: `16px` — Standard card inner margin
* `--spacing-24`: `24px` — Card body padding, grid gap between sibling cards
* `--spacing-32`: `32px` — Container side padding, modal interior margins
* `--spacing-48`: `48px` — Sub-section vertical separation
* `--spacing-80`: `80px` — Standard section gap *(Officevibe benchmark: `--section-gap: 80px`)*
* `--spacing-96`: `96px - 116px` — Major hero and footer breathing room *(Craft Docs & Superr)*

---

## 3. Component Design Specifications

### 3.1. Floating Glass Navigation Bar
* **Position:** Fixed / Sticky top `16px` with horizontal page margin.
* **Surface:** `rgba(255, 255, 255, 0.85)` in Light Mode, `rgba(15, 23, 42, 0.80)` in Dark Mode with `backdrop-filter: blur(16px)`.
* **Border:** `1px solid var(--color-border-cream)` with ambient glow.
* **Shape:** Fully rounded pill (`--radius-full: 9999px`) or softened modern rectangle (`18px`).
* **Active State:** Tactile pill indicator with smooth `transform: translateY(-1px)` hover interaction.

### 3.2. Editorial Hero Section with Italic Cut
* **Headline Treatment (Officevibe & Craft Docs Paradigm):**
  * Display font set to large serif (`54px - 64px`) with `-0.04em` tracking.
  * Exactly **one phrase** inside the H1 is wrapped in an italic cut (`<em>` tag) to establish the brand voice:
    > *"Mezunlarımızla Güçlü, <em style="font-family: serif; font-style: italic; color: #8A1538;">Geleceğe Birlikte.</em>"*
* **Supporting Tag:** Pill badge (`--radius-full`) with `#F4EFEA` background and subtle dot status.

### 3.3. Tactile Pill Buttons & Micro-Interactions
* **Primary Button:**
  * Background: Solid İÜ Crimson (`#8A1538`) or Electric Cobalt (`#2545FF`).
  * Shape: Full pill (`border-radius: 100px`).
  * Padding: `12px 26px` (touch-target minimum 44px height).
  * Hover: `transform: translateY(-2px); box-shadow: 0 8px 20px rgba(138, 21, 56, 0.35);`.
* **Secondary Ghost Button:**
  * Background: Transparent with `1.5px solid var(--color-border-cream)` and text `#171717` / `#F8FAFC`.
  * Hover: Soft tinted surface `#F4EFEA` / `rgba(255, 255, 255, 0.1)`.

### 3.4. Multi-Layered Elevation Cards
* **Job Posting & Announcement Cards:**
  * Surface: Warm Paper White (`#FFFFFF`) with cream edge (`1px solid #EBE3D7`).
  * Corner Radius: `16px`.
  * Padding: `24px - 28px`.
  * Top Accent: 3px subtle top gradient border (`#8A1538` to `#D4AF37`).
  * Hover Transition: `transform: translateY(-4px); box-shadow: var(--shadow-card-elevated);`.
* **Pill Metadata Tags:**
  * Category and employment status displayed in clean pill tags (`padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase;`).

### 3.5. Form Controls, Search & Filter Inputs
* **Background:** Soft Cream Tint (`#FDFBF9` / `#0B1B3D`).
* **Border:** `1.5px solid #E2DCD5`, focusing to `2px solid #8A1538` or `#2545FF` with `0 0 0 4px rgba(37, 69, 255, 0.15)` focus ring.
* **Shape:** `--radius-input: 12px`.
* **Typography:** `14px - 15px` Sans-Serif with high-contrast placeholder `#94A3B8`.

---

## 4. Strict Design Guidelines (Do's and Don'ts)

Directly synthesized from the three Refero design specifications:

### ✅ DO
1. **DO use the serif font exclusively for major headlines (H1, H2).** Let the editorial weight carry the academic tradition.
2. **DO italicize exactly one meaningful phrase in the main hero display.** The italic cut is an intentional voice tool, not random decoration *(Officevibe Benchmark)*.
3. **DO apply tight negative tracking (`-0.03em` to `-0.05em`) to large display typography.** This keeps large serif letters sharp, modern, and cohesive *(Craft Docs Benchmark)*.
4. **DO default to full pill radius (`100px` / `9999px`) for all clickable interactive buttons, filter chips, and tags.** It makes complex enterprise data feel friendly and approachable *(Superr & Officevibe Benchmark)*.
5. **DO preserve 80px to 96px+ vertical spacing between major sections.** Generous breathing room prevents institutional density from overwhelming the user *(Craft Docs Benchmark)*.
6. **DO use multi-layered diffuse shadows on cards.** Combine ambient and contact shadows rather than a single black drop shadow.
7. **DO keep canvas backgrounds on warm paper tones (`#FBF9F5` / `#FDFBF9`), never harsh 100% white (`#FFFFFF`).**

### ❌ DON'T
1. **DON'T use serif typography for UI controls, buttons, form labels, or body text smaller than 22px.** Keep all functional elements in ultra-crisp Sans-Serif.
2. **DON'T use pure pitch black (`#000000`) for text or borders.** Always use softened Deep Ink Navy (`#0C1754`) or Charcoal (`#171717`).
3. **DON'T introduce cool blue-gray borders.** Stick strictly to warm cream dividers (`#EBE3D7` / `#F0E9E1`).
4. **DON'T scatter multiple bright accent colors in one section.** Reserve high-energy chromatic colors (Electric Cobalt or İÜ Crimson) for the single most important action per view.
5. **DON'T use sharp 90-degree corners on clickable elements.** Avoid robotic sharp boxes; maintain human, tactile curves.
6. **DON'T use hard, single-source drop shadows.** They look dated and harsh against editorial layouts.

---

## 5. Implementation Ready CSS / Tailwind Tokens

### 5.1. Raw CSS Root Custom Properties
```css
:root {
  /* Canvas & Surfaces */
  --canvas-warm: #FBF9F5;
  --surface-paper: #FFFFFF;
  --surface-tint: #F7EFE9;
  --surface-card: #FFFFFF;
  --surface-dark-card: rgba(15, 27, 61, 0.75);

  /* Borders & Dividers */
  --border-cream: #EBE3D7;
  --border-subtle: rgba(12, 23, 84, 0.08);

  /* Inks & Typography */
  --ink-primary: #0C1754;
  --ink-charcoal: #171717;
  --ink-secondary: #64748B;
  --ink-light: #F8FAFC;

  /* Chromatic Punctuation */
  --color-iu-crimson: #8A1538;
  --color-electric-blue: #2545FF;
  --color-heritage-gold: #D4AF37;
  --color-marker-amber: #FF6F1E;
  --color-mint-success: #10B981;

  /* Font Families */
  --font-serif-editorial: 'Lora', 'Merriweather', 'Martina Plantijn', Georgia, serif;
  --font-sans-ui: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  --font-mono-code: 'JetBrains Mono', 'SF Mono', Consolas, monospace;

  /* Corner Radius Hierarchy */
  --radius-pill: 100px;
  --radius-card: 16px;
  --radius-input: 12px;
  --radius-hero: 24px;
  --radius-footer: 56px;

  /* Multi-Layered Diffuse Shadows */
  --shadow-diffuse-sm: 0 1px 3px rgba(12, 23, 84, 0.04), 0 2px 6px rgba(12, 23, 84, 0.03);
  --shadow-diffuse-md: 0 4px 12px rgba(12, 23, 84, 0.05), 0 1px 3px rgba(12, 23, 84, 0.04);
  --shadow-diffuse-card: 
    0 50px 40px rgba(12, 23, 84, 0.02),
    0 20px 30px rgba(12, 23, 84, 0.04),
    0 4px 12px rgba(12, 23, 84, 0.06),
    0 1px 3px rgba(0, 0, 0, 0.04);

  /* Layout Spacing */
  --section-gap: 80px;
  --page-max-width: 1200px;
}
```

### 5.2. Tailwind Configuration Preset (`tailwind.config.js`)
```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        canvas: {
          warm: '#FBF9F5',
          tint: '#F7EFE9',
          dark: '#070D1B',
        },
        ink: {
          navy: '#0C1754',
          charcoal: '#171717',
          muted: '#64748B',
        },
        iu: {
          crimson: '#8A1538',
          gold: '#D4AF37',
        },
        electric: '#2545FF',
        marker: '#FF6F1E',
        cream: '#EBE3D7',
      },
      fontFamily: {
        serif: ['Lora', 'Merriweather', 'Georgia', 'serif'],
        sans: ['Plus Jakarta Sans', 'Inter', 'system-ui', 'sans-serif'],
        mono: ['JetBrains Mono', 'monospace'],
      },
      borderRadius: {
        'pill': '100px',
        'card': '16px',
        'hero': '24px',
        'footer': '56px',
      },
      boxShadow: {
        'diffuse': '0 50px 40px rgba(12,23,84,0.02), 0 20px 30px rgba(12,23,84,0.04), 0 4px 12px rgba(12,23,84,0.06)',
      },
      spacing: {
        'section': '80px',
        'breathing': '96px',
      }
    }
  }
}
```

---

> 🔗 **Related Architecture & Brand Documents:**
> - Institutional Brand Guidelines & Logo Rules: [`brand.md`](brand.md)
> - Technical System Overview & MVC Architecture: [`README.md`](README.md)
> - Domain Data Dictionary & Database Schemas: [`ddd.md`](ddd.md)
> - Interactive OpenAPI / Swagger Documentation: [http://localhost:8000/api/swagger](http://localhost:8000/api/swagger)
