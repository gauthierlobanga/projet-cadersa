Proposal: Replace inline Alpine expressions with named function calls (CSP-safe)

Goal
----
Replace inline Alpine expressions that are evaluated as strings (which trigger AsyncFunction/eval under the hood) with references to named functions. This avoids 'unsafe-eval' usage and keeps a strict CSP in production.

Strategy
--------
1. Scan for inline Alpine attributes that contain code strings: x-on:*, x-init, x-effect, x-text (when used with complex inline code), x-bind (complex), etc.
2. For each occurrence, replace the inline expression with a function call (no string evaluation) and define the function in a centralized, CSP-allowed script block.
   - Option A (recommended): Add a Blade partial that injects a small <script nonce="{{ request()->header('X-CSP-Nonce') }}"> with named functions used by templates.
   - Option B: Add a JS module (resources/js/alpine-csp-handlers.js) and include it via the normal asset pipeline; ensure it is loaded from an allowed origin.
3. Keep changes minimal and local to each template: replace attribute value only and add function names that reflect the file/component (e.g., scrollToTop, initPdfViewer, focusPasskeyInput).
4. Run formatting and smoke-test pages in dev (with or without relaxed dev CSP) and verify browser console no longer shows EvalError from AsyncFunction for Alpine.

Files found (scan summary)
------------------------
The following files contain inline Alpine expressions that may be evaluated as strings and should be reviewed/refactored:

- resources\views\components\⚡scroll-to-top\scroll-to-top.blade.php
  - x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })"
  - Proposed: x-on:click="scrollToTop" + define function scrollToTop() in nonce script.

- resources\views\components\pdf-viewer.blade.php
  - x-on:load="handleIframeLoad()" (already function reference)
  - x-on:error="handleIframeError()"
  - Proposed: leave as-is when already function ref, or ensure functions are defined in nonce script.

- resources\views\components\passkey-registration.blade.php
- resources\views\components\passkey-verify.blade.php
  - x-init examples: $nextTick(() => $refs.passkeyNameInput?.focus())
  - Proposed: replace with x-init="focusPasskeyName" and define function focusPasskeyName(el) { $nextTick(() => el.querySelector('[data-passkey-name]')?.focus()) } (or similar; may need slight per-template adjustment).

- resources\views\pages\site\⚡about.blade.php
  - x-effect="if (shown) animate()" and other inline handlers
  - Proposed: ensure animate() is a named function or call animateShown() defined in nonce script.

- resources\views\pages\posts\⚡show.blade.php
  - x-init uses inline window.addEventListener('scroll', () => { ... })
  - Proposed: replace with x-init="initScrollProgress" and define function initScrollProgress(el) { window.addEventListener('scroll', () => { /*...*/ }) }

- resources\views\flux\toast\index.blade.php and flux\toast\group.blade.php
  - x-on events referencing $el.showToast($event.detail) (inline expressions observed in console errors)
  - Proposed: replace inline expressions with calls to named handlers like x-on:some-event="handleShowToast" and define handleShowToast(el, detail) { el.showToast(detail) }

- Various Filament/vendor components and storage/framework/views compiled templates contain inline expressions (list included below). Some are third-party bundles and may be left alone or overridden if necessary.
  - resources\views\vendor\filament\components\*
  - resources\views\vendor\filament\components\button\index.blade.php
  - resources\views\vendor\filament\components\dropdown\list\item.blade.php
  - resources\views\vendor\filament\components\tabs\item.blade.php
  - resources\views\vendor\filament\components\input\one-time-code.blade.php
  - public\js\filament\forms\components\tags-input.js

Other files scanned (non-exhaustive list produced by the scan):
- resources\views\vendor\filament\components\toggle.blade.php
- resources\views\components\footer\⚡footer\footer.blade.php
- resources\views\layouts\app\header.blade.php
- resources\views\flux\sidebar\index.blade.php
- resources\views\flux\sidebar\toggle.blade.php
- resources\views\flux\modal\trigger.blade.php
- resources\views\flux\modal\index.blade.php
- resources\views\flux\input\viewable.blade.php
- resources\views\flux\input\clearable.blade.php
- resources\views\flux\input\copyable.blade.php
- resources\views\flux\input\file.blade.php
- storage\framework\views\*.php (compiled templates — do not edit these directly)

Recommended change pattern (examples)
-------------------------------------
1) Inline action -> named function
   Before:
     <button x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })">Top</button>
   After:
     <button x-on:click="scrollToTop">Top</button>
   Define in nonce script (Blade partial):
     <script nonce="{{ request()->header('X-CSP-Nonce') }}">
       function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }) }
     </script>

2) Inline arrow function in x-init -> named initializer
   Before:
     <div x-init="() => { visible = window.scrollY > 500 }"></div>
   After:
     <div x-init="initScrollVisibility"></div>
   Define:
     <script nonce="{{ request()->header('X-CSP-Nonce') }}">
       function initScrollVisibility(el) { window.addEventListener('scroll', () => { el.__x.$data.visible = window.scrollY > 500 }) }
     </script>

Notes and caveats
-----------------
- Compiled templates under storage/framework/views should not be edited; find their source Blade files when possible.
- Filament vendor files: where possible prefer overriding the component or copying to resources/views/vendor/ to patch; some may already be using function references and only need small tweaks.
- For complex per-component logic, define a namespaced function (e.g., cdr_about_animate) to avoid collisions.
- Prefer adding functions to a small Blade partial included in layouts/app/head or before closing </body> with the nonce so functions are available to templates.

Proposed next steps
-------------------
1. Review this proposal and approve the approach.
2. If approved, implement automated replacements for straightforward cases (simple inline expressions and arrow functions) and create a follow-up PR with code changes (I can do this). For complex handlers, implement by-hand and test.
3. Verify in dev with strict CSP (no unsafe-eval) and in production build.

If approved, next action will be: create a feature branch with the changes, run formatting, test key pages, and create a PR with the code changes for review.

---
Generated by automated scan on request. Adjustments will be made during implementation if you prefer different naming or file locations for handler functions.
