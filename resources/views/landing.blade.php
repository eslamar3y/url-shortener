<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Snip — Shorten your links</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
  --bg:        #0c0e11;
  --bg2:       #1e293b;
  --surface:   #1e293b;
  --surface2:  #2a3649;
  --border:    #334155;
  --border2:   #475569;
  --text:      #f1f5f9;
  --text2:     #cbd5e1;
  --muted:     #64748b;
  --accent:    #f59e0b;
  --accent-h:  #d97706;
  --accent-glow: rgba(245,158,11,0.15);
  --green:     #10b981;
  --blue:      #3b82f6;
  --radius:    10px;
  --radius-lg: 16px;
}

html { scroll-behavior: smooth; }
body {
  background: var(--bg);
  color: var(--text);
  font-family: 'Inter', sans-serif;
  overflow-x: hidden;
  line-height: 1.6;
}
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: var(--bg); }
::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

body::after {
  content: '';
  position: fixed; inset: 0;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
  pointer-events: none; z-index: 9999; opacity: 0.5;
}

/* ── NAV ── */
nav {
  position: fixed; top: 0; left: 0; right: 0; z-index: 100;
  padding: 0 2rem; height: 60px;
  display: flex; align-items: center; justify-content: space-between;
  border-bottom: 1px solid transparent;
  transition: all 0.3s;
}
nav.scrolled {
  background: rgba(15,23,42,0.92);
  backdrop-filter: blur(16px);
  border-bottom-color: var(--border);
}
.logo {
  font-family: 'Space Mono', monospace;
  font-size: 1.15rem; font-weight: 700;
  color: var(--accent); text-decoration: none;
  display: flex; align-items: center; gap: 0.5rem;
}
.logo-icon {
  width: 28px; height: 28px;
  background: var(--accent); border-radius: 7px;
  display: flex; align-items: center; justify-content: center;
  color: var(--bg); font-size: 0.75rem; font-weight: 700;
}
.nav-links { display: flex; align-items: center; gap: 0.2rem; list-style: none; }
.nav-links a {
  color: var(--muted); text-decoration: none;
  font-size: 0.875rem; font-weight: 500;
  padding: 0.4rem 0.75rem; border-radius: var(--radius);
  transition: all 0.15s;
}
.nav-links a:hover { color: var(--text2); background: var(--surface2); }
.nav-btn { background: var(--accent) !important; color: var(--bg) !important; font-weight: 700 !important; }
.nav-btn:hover { background: var(--accent-h) !important; color: var(--bg) !important; }

/* ── HERO ── */
.hero {
  min-height: 100vh;
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  text-align: center; padding: 100px 1.5rem 4rem;
  position: relative;
}
.hero-grid {
  position: absolute; inset: 0;
  background-image:
    linear-gradient(var(--border) 1px, transparent 1px),
    linear-gradient(90deg, var(--border) 1px, transparent 1px);
  background-size: 40px 40px; opacity: 0.12;
  mask-image: radial-gradient(ellipse 70% 70% at 50% 40%, black 20%, transparent 100%);
}
.hero-glow {
  position: absolute; width: 600px; height: 400px;
  background: radial-gradient(ellipse, rgba(245,158,11,0.09) 0%, transparent 70%);
  top: 60px; left: 50%; transform: translateX(-50%);
  pointer-events: none;
}
.hero-content { position: relative; z-index: 1; max-width: 740px; }

.badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: rgba(245,158,11,0.08);
  border: 1px solid rgba(245,158,11,0.25);
  color: var(--accent);
  padding: 0.32rem 0.9rem; border-radius: 100px;
  font-size: 0.8rem; font-weight: 600; letter-spacing: 0.01em;
  margin-bottom: 1.75rem;
  animation: fadeUp 0.5s ease both;
}
.badge-dot {
  width: 6px; height: 6px;
  background: var(--accent); border-radius: 50%;
  animation: blink 2s ease infinite;
}
@keyframes blink { 0%,100%{opacity:1;} 50%{opacity:0.3;} }

.hero h1 {
  font-size: clamp(2.4rem, 6vw, 4.8rem);
  font-weight: 900; line-height: 1.1; letter-spacing: -0.02em;
  margin-bottom: 1.25rem;
  animation: fadeUp 0.5s ease 0.1s both;
}
.hero h1 em {
  font-style: normal;
  background: linear-gradient(135deg, var(--accent) 0%, #fb923c 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text;
}
.hero-sub {
  font-size: clamp(1rem, 2vw, 1.15rem); color: var(--muted);
  max-width: 520px; margin: 0 auto 2rem;
  font-weight: 400; line-height: 1.7;
  animation: fadeUp 0.5s ease 0.2s both;
}
.hero-actions {
  display: flex; gap: 0.75rem;
  align-items: center; justify-content: center; flex-wrap: wrap;
  margin-bottom: 3rem;
  animation: fadeUp 0.5s ease 0.3s both;
}
.btn {
  display: inline-flex; align-items: center; gap: 0.4rem;
  padding: 0.65rem 1.4rem; border-radius: var(--radius);
  font-family: 'Inter', sans-serif;
  font-size: 0.9rem; font-weight: 600;
  text-decoration: none; cursor: pointer; border: none;
  transition: all 0.2s; letter-spacing: 0.01em;
}
.btn-amber { background: var(--accent); color: var(--bg); }
.btn-amber:hover { background: var(--accent-h); box-shadow: 0 0 0 3px rgba(245,158,11,0.2); }
.btn-ghost { background: var(--surface); color: var(--text2); border: 1px solid var(--border); }
.btn-ghost:hover { border-color: var(--border2); background: var(--surface2); }

/* demo */
.demo-wrap {
  animation: fadeUp 0.5s ease 0.4s both;
  width: 100%; max-width: 600px; margin: 0 auto 3rem;
}
.demo-bar {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  padding: 0.6rem 0.6rem 0.6rem 1.25rem;
  display: flex; align-items: center; gap: 0.75rem;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.demo-bar:focus-within { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }
.demo-input {
  flex: 1; background: transparent; border: none; outline: none;
  color: var(--muted); font-family: 'Space Mono', monospace;
  font-size: 0.78rem; min-width: 0;
}
.demo-result {
  display: none; align-items: center; gap: 0.5rem;
  font-family: 'Space Mono', monospace; font-size: 0.8rem;
  color: var(--green); flex: 1;
}
.demo-result.show { display: flex; }
.demo-btn {
  background: var(--accent); color: var(--bg);
  border: none; padding: 0.55rem 1.2rem; border-radius: 8px;
  font-family: 'Inter', sans-serif; font-weight: 700;
  font-size: 0.875rem; cursor: pointer; white-space: nowrap;
  transition: background 0.2s, transform 0.1s; flex-shrink: 0;
}
.demo-btn:hover { background: var(--accent-h); }
.demo-btn:active { transform: scale(0.97); }

/* stats */
.stats-row {
  display: flex; justify-content: center; gap: 3.5rem;
  flex-wrap: wrap; animation: fadeUp 0.5s ease 0.5s both;
}
.stat { text-align: center; }
.stat-n {
  font-family: 'Space Mono', monospace;
  font-size: 1.5rem; font-weight: 700; color: var(--text); display: block;
}
.stat-l { font-size: 0.76rem; color: var(--muted); margin-top: 0.2rem; letter-spacing: 0.02em; }

/* ── SECTION BASE ── */
.section-inner { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem; }
.chip {
  display: inline-block;
  background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2);
  color: var(--accent); padding: 0.22rem 0.75rem; border-radius: 100px;
  font-size: 0.72rem; font-weight: 700;
  letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 0.75rem;
}
.s-title {
  font-size: clamp(1.6rem, 3.5vw, 2.4rem); font-weight: 800;
  line-height: 1.2; letter-spacing: -0.02em; margin-bottom: 0.75rem;
}
.s-sub { color: var(--muted); font-size: 1rem; max-width: 460px; line-height: 1.7; }

/* ── FEATURES ── */
.feat-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1px; background: var(--border);
  border-radius: var(--radius-lg); overflow: hidden;
  margin-top: 3rem; border: 1px solid var(--border);
}
.feat-card {
  background: var(--bg); padding: 2rem;
  transition: background 0.2s; position: relative;
}
.feat-card:hover { background: var(--surface); }
.feat-card::after {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(90deg, var(--accent), transparent);
  opacity: 0; transition: opacity 0.3s;
}
.feat-card:hover::after { opacity: 1; }
.feat-icon {
  width: 40px; height: 40px; background: var(--surface2);
  border: 1px solid var(--border); border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.1rem; margin-bottom: 1rem;
}
.feat-card h3 { font-size: 0.95rem; font-weight: 700; margin-bottom: 0.4rem; letter-spacing: -0.01em; }
.feat-card p { color: var(--muted); font-size: 0.85rem; line-height: 1.65; }

/* ── HOW IT WORKS ── */
.steps {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem; margin-top: 3rem;
}
.step-card {
  background: var(--bg); border: 1px solid var(--border);
  border-radius: var(--radius-lg); padding: 1.75rem 1.5rem;
  text-align: center; transition: border-color 0.2s, transform 0.2s;
}
.step-card:hover { border-color: var(--accent); transform: translateY(-3px); }
.step-num {
  width: 34px; height: 34px; background: var(--surface2);
  border: 1px solid var(--border); border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-family: 'Space Mono', monospace; font-size: 0.75rem;
  font-weight: 700; color: var(--accent); margin: 0 auto 1rem;
}
.step-card h3 { font-size: 0.95rem; font-weight: 700; margin-bottom: 0.4rem; }
.step-card p { color: var(--muted); font-size: 0.83rem; line-height: 1.65; }

/* ── PRICING ── */
.pricing-grid {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 1.5rem; margin-top: 3rem;
  max-width: 620px; margin-left: auto; margin-right: auto;
}
.price-card {
  background: var(--surface); border: 1px solid var(--border);
  border-radius: var(--radius-lg); padding: 2rem;
  transition: transform 0.2s; position: relative;
}
.price-card:hover { transform: translateY(-3px); }
.price-card.featured {
  border-color: var(--accent);
  background: linear-gradient(160deg, rgba(245,158,11,0.06), var(--surface) 60%);
}
.popular-tag {
  position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
  background: var(--accent); color: var(--bg);
  padding: 0.2rem 0.9rem; border-radius: 100px;
  font-size: 0.72rem; font-weight: 700; white-space: nowrap; letter-spacing: 0.02em;
}
.plan-name { font-size: 0.82rem; color: var(--muted); font-weight: 600; margin-bottom: 0.5rem; letter-spacing: 0.05em; text-transform: uppercase; }
.plan-price {
  font-family: 'Space Mono', monospace;
  font-size: 2.8rem; font-weight: 700; color: var(--text); line-height: 1;
}
.plan-period { font-size: 0.78rem; color: var(--muted); margin-bottom: 1.5rem; }
.plan-feats { list-style: none; margin-bottom: 1.5rem; }
.plan-feats li {
  display: flex; align-items: center; gap: 0.6rem;
  padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.04);
  font-size: 0.875rem; color: var(--text2);
}
.plan-feats li:last-child { border-bottom: none; }
.ok { color: var(--green); font-size: 0.78rem; }
.no { color: var(--border2); font-size: 0.78rem; }
.plan-btn {
  display: block; text-align: center; padding: 0.7rem;
  border-radius: var(--radius); font-family: 'Inter', sans-serif;
  font-weight: 700; font-size: 0.9rem; text-decoration: none;
  transition: all 0.2s; letter-spacing: 0.01em;
}
.plan-btn-free { background: transparent; border: 1px solid var(--border); color: var(--text2); }
.plan-btn-free:hover { border-color: var(--border2); background: var(--surface2); }
.plan-btn-pro { background: var(--accent); color: var(--bg); }
.plan-btn-pro:hover { background: var(--accent-h); box-shadow: 0 4px 15px rgba(245,158,11,0.25); }

/* ── CTA ── */
.cta-banner {
  margin: 0 1.5rem;
  max-width: 1100px; margin-left: auto; margin-right: auto;
  background: var(--surface); border: 1px solid var(--border);
  border-radius: 20px; padding: 5rem 2rem;
  text-align: center; position: relative; overflow: hidden;
}
.cta-banner::before {
  content: ''; position: absolute;
  width: 500px; height: 300px;
  background: radial-gradient(ellipse, rgba(245,158,11,0.07), transparent 70%);
  top: 50%; left: 50%; transform: translate(-50%,-50%);
  pointer-events: none;
}
.cta-banner h2 {
  font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 900;
  letter-spacing: -0.02em; margin-bottom: 1rem; position: relative;
}
.cta-banner p { color: var(--muted); font-size: 1rem; margin-bottom: 2rem; position: relative; }

/* ── FOOTER ── */
footer {
  border-top: 1px solid var(--border);
  padding: 2.5rem 1.5rem;
  max-width: 1100px; margin: 0 auto;
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 1rem;
}
.footer-logo {
  font-family: 'Space Mono', monospace; font-size: 0.95rem;
  font-weight: 700; color: var(--accent); text-decoration: none;
  display: flex; align-items: center; gap: 0.4rem;
}
footer p { color: var(--muted); font-size: 0.8rem; }
.footer-links { display: flex; gap: 1.5rem; }
.footer-links a { color: var(--muted); font-size: 0.8rem; text-decoration: none; transition: color 0.2s; }
.footer-links a:hover { color: var(--text2); }

/* ── ANIMATIONS ── */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
.reveal { opacity: 0; transform: translateY(24px); transition: opacity 0.5s ease, transform 0.5s ease; }
.reveal.visible { opacity: 1; transform: translateY(0); }

/* ── RESPONSIVE ── */
@media (max-width: 640px) {
  .nav-links li:not(:last-child):not(:nth-last-child(2)) { display: none; }
  footer { flex-direction: column; text-align: center; }
  .footer-links { justify-content: center; }
  .feat-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<!-- NAV -->
<nav id="nav">
  <a href="/" class="logo">
    <span class="logo-icon">S</span>
    Snip
  </a>
  <ul class="nav-links">
    <li><a href="#features">Features</a></li>
    <li><a href="#how">How it works</a></li>
    <li><a href="#pricing">Pricing</a></li>
    <a href="{{ route('filament.app.auth.login') }}">Log in</a>
    <a href="{{ route('filament.app.auth.register') }}" class="nav-btn">Get started free</a>
  </ul>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-grid"></div>
  <div class="hero-glow"></div>
  <div class="hero-content">

    <div class="badge">
      <span class="badge-dot"></span>
      Free to start — no credit card required
    </div>

    <h1>
      Long URLs?<br>
      Make them <em>short & smart.</em>
    </h1>

    <p class="hero-sub">
      Shorten any link in seconds, track every click, and understand where your
      visitors come from — all in one clean dashboard.
    </p>

    <div class="hero-actions">
      <a href="{{ route('filament.app.auth.register') }}" class="btn btn-amber">Get started free →</a>
      <a href="#how" class="btn btn-ghost">See how it works</a>
    </div>

    <div class="demo-wrap">
      <div class="demo-bar">
        <input class="demo-input" id="demoInput" type="text"
          value="https://www.example.com/very/long/url/nobody-wants-to-share-or-type" />
        <div class="demo-result" id="demoResult">✓ &nbsp;snip.app/xK9mQ</div>
        <button class="demo-btn" onclick="runDemo()">Shorten</button>
      </div>
    </div>

    <div class="stats-row">
      <div class="stat">
        <span class="stat-n">10K+</span>
        <div class="stat-l">Links shortened</div>
      </div>
      <div class="stat">
        <span class="stat-n">99.9%</span>
        <div class="stat-l">Uptime</div>
      </div>
      <div class="stat">
        <span class="stat-n">&lt;50ms</span>
        <div class="stat-l">Redirect speed</div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<div style="background:var(--bg2);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:5rem 0;" id="features">
  <div class="section-inner">
    <div class="reveal">
      <span class="chip">Features</span>
      <h2 class="s-title">Everything you need, nothing you don't.</h2>
      <p class="s-sub">Not just link shortening — a complete platform to manage and track all your links.</p>
    </div>
    <div class="feat-grid reveal">
      <div class="feat-card">
        <div class="feat-icon">🔗</div>
        <h3>Instant short links</h3>
        <p>Shorten any URL in seconds with a custom alias or an auto-generated code. Share anywhere.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">📊</div>
        <h3>Detailed analytics</h3>
        <p>Track every click — country, device, browser, and time. Understand your audience deeply.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">⏰</div>
        <h3>Link expiry dates</h3>
        <p>Set an expiry date on any link. Perfect for limited-time offers and marketing campaigns.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">🔒</div>
        <h3>Full control</h3>
        <p>Enable or disable any link at any time. Beautiful error pages instead of ugly 404s.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">⚡</div>
        <h3>Lightning fast</h3>
        <p>Redirects happen in under 50ms. Your visitors won't notice a thing.</p>
      </div>
      <div class="feat-card">
        <div class="feat-icon">📱</div>
        <h3>Works everywhere</h3>
        <p>A fully responsive dashboard that looks great on mobile, tablet, and desktop.</p>
      </div>
    </div>
  </div>
</div>

<!-- HOW IT WORKS -->
<div style="padding:5rem 0;" id="how">
  <div class="section-inner">
    <div class="reveal">
      <span class="chip">How it works</span>
      <h2 class="s-title">Three simple steps.</h2>
      <p class="s-sub">From signup to your first short link in under a minute.</p>
    </div>
    <div class="steps reveal">
      <div class="step-card">
        <div class="step-num">01</div>
        <div style="font-size:2rem;margin-bottom:.75rem;">📝</div>
        <h3>Create your account</h3>
        <p>Sign up for free in seconds. No credit card required to get started.</p>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div style="font-size:2rem;margin-bottom:.75rem;">✂️</div>
        <h3>Paste your link</h3>
        <p>Drop in your long URL and hit shorten. Get a clean, shareable link instantly.</p>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div style="font-size:2rem;margin-bottom:.75rem;">📈</div>
        <h3>Track your results</h3>
        <p>See real-time stats for every link — clicks, countries, and device breakdown.</p>
      </div>
    </div>
  </div>
</div>

<!-- PRICING -->
<div style="background:var(--bg2);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:5rem 0;" id="pricing">
  <div class="section-inner">
    <div class="reveal" style="text-align:center">
      <span class="chip">Pricing</span>
      <h2 class="s-title">Simple and transparent.</h2>
      <p class="s-sub" style="margin:0 auto;">Start for free and upgrade when you need more.</p>
    </div>
    <div class="pricing-grid">
      <div class="price-card reveal">
        <div class="plan-name">Free</div>
        <div class="plan-price">$0</div>
        <div class="plan-period">forever</div>
        <ul class="plan-feats">
          <li><span class="ok">✓</span> 10 links</li>
          <li><span class="ok">✓</span> Fast redirect</li>
          <li><span class="ok">✓</span> Expiry dates</li>
          <li><span class="no">✗</span> Detailed analytics</li>
          <li><span class="no">✗</span> Unlimited links</li>
        </ul>
        <a href="{{ route('filament.app.auth.register') }}" class="plan-btn plan-btn-free">Get started free</a>
      </div>
      <div class="price-card featured reveal">
        <div class="popular-tag">Most popular ✦</div>
        <div class="plan-name">Pro</div>
        <div class="plan-price">$10</div>
        <div class="plan-period">per month</div>
        <ul class="plan-feats">
          <li><span class="ok">✓</span> Unlimited links</li>
          <li><span class="ok">✓</span> Full analytics</li>
          <li><span class="ok">✓</span> Country & device stats</li>
          <li><span class="ok">✓</span> Interactive chart</li>
          <li><span class="ok">✓</span> Priority support</li>
        </ul>
        <a href="{{ route('filament.app.auth.register') }}" class="plan-btn plan-btn-pro">Start Pro now →</a>
      </div>
    </div>
  </div>
</div>

<!-- CTA -->
<div style="padding:5rem 1.5rem;">
  <div class="cta-banner reveal">
    <h2>Ready to start?<br><em style="font-style:normal;color:var(--accent);">It's completely free.</em></h2>
    <p>Join now and shorten your first link in under a minute.</p>
    <a href="{{ route('filament.app.auth.register') }}" class="btn btn-amber">Get started free →</a>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <a href="/" class="footer-logo">
    <span class="logo-icon">S</span>
    Snip
  </a>
  <p>Shorten your links. Track your results. Grow faster.</p>
  <div class="footer-links">
    <a href="#features">Features</a>
    <a href="#pricing">Pricing</a>
    <a href="{{ route('filament.app.auth.login') }}">Login</a>
  </div>
  <p style="width:100%;text-align:center;margin-top:1rem;opacity:.35;font-size:.72rem;">
    © 2026 Snip. All rights reserved.
  </p>
</footer>

<script>
window.addEventListener('scroll', () => {
  document.getElementById('nav').classList.toggle('scrolled', scrollY > 40);
});

const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => obs.observe(el));

let demoState = 'idle';
function runDemo() {
  const input = document.getElementById('demoInput');
  const result = document.getElementById('demoResult');
  const btn = document.querySelector('.demo-btn');
  if (demoState === 'idle') {
    btn.textContent = '...'; btn.disabled = true;
    setTimeout(() => {
      input.style.display = 'none';
      result.classList.add('show');
      btn.textContent = 'Copy link';
      btn.disabled = false;
      demoState = 'done';
    }, 700);
  } else {
    navigator.clipboard?.writeText('https://snip.app/xK9mQ');
    btn.textContent = '✓ Copied!';
    btn.style.background = 'var(--green)';
    setTimeout(() => {
      input.style.display = '';
      result.classList.remove('show');
      btn.textContent = 'Shorten';
      btn.style.background = '';
      demoState = 'idle';
    }, 2000);
  }
}
</script>
</body>
</html>