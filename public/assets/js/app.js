/* Quality Core Cutting UAE — site script (vanilla JS, no libraries)
   1. Navigation          2. Header state
   3. Split-text reveal   4. Scroll reveals (3D / clip / fade)
   5. Parallax            6. 3D tilt + spotlight cards
   7. Count-up numbers    8. Pinned horizontal scroll
   9. Hero 3D scene loader   10. Quote form                          */
(function () {
    'use strict';
    var doc = document.documentElement;
    var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var finePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
    doc.classList.add('js');
    if (reduce) doc.classList.add('reduce-motion');

    var $$ = function (sel, root) { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); };

    /* 1. Navigation ------------------------------------------------------ */
    var toggle = document.querySelector('[data-nav-toggle]');
    var header = document.querySelector('[data-header]');
    function closeNav() {
        doc.classList.remove('nav-open');
        if (toggle) toggle.setAttribute('aria-expanded', 'false');
    }
    if (toggle) {
        toggle.addEventListener('click', function () {
            if (header) doc.style.setProperty('--nav-top', header.getBoundingClientRect().bottom + 'px');
            var open = doc.classList.toggle('nav-open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeNav(); });
        window.addEventListener('resize', function () { if (window.innerWidth >= 1024) closeNav(); });
    }
    $$('[data-sub-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var li = btn.closest('li');
            btn.setAttribute('aria-expanded', li.classList.toggle('sub-open') ? 'true' : 'false');
        });
    });
    $$('[data-nav] a').forEach(function (a) { a.addEventListener('click', closeNav); });

    /* 2. Header state ---------------------------------------------------- */
    function headerState() { if (header) header.classList.toggle('is-scrolled', window.scrollY > 24); }

    /* 3. Split text: wrap each word so it can rise in with a 3D flip ------ */
    $$('[data-split]').forEach(function (el) {
        var i = 0;
        (function walk(node) {
            Array.prototype.slice.call(node.childNodes).forEach(function (child) {
                if (child.nodeType === 3) {
                    var frag = document.createDocumentFragment();
                    child.textContent.split(/(\s+)/).forEach(function (part) {
                        if (!part) return;
                        if (/^\s+$/.test(part)) { frag.appendChild(document.createTextNode(part)); return; }
                        var outer = document.createElement('span');
                        outer.className = 'w';
                        var inner = document.createElement('span');
                        inner.textContent = part;
                        inner.style.setProperty('--i', i++);
                        outer.appendChild(inner);
                        frag.appendChild(outer);
                    });
                    child.parentNode.replaceChild(frag, child);
                } else if (child.nodeType === 1) { walk(child); }
            });
        })(el);
        el.setAttribute('data-reveal', el.getAttribute('data-reveal') || 'split');
    });

    /* stagger: children of [data-stagger] get an increasing delay */
    $$('[data-stagger]').forEach(function (group) {
        Array.prototype.slice.call(group.children).forEach(function (child, i) {
            child.style.setProperty('--d', (i * 0.08) + 's');
            if (!child.hasAttribute('data-reveal')) child.setAttribute('data-reveal', group.getAttribute('data-stagger') || 'up');
        });
    });

    /* 4. Scroll reveals -------------------------------------------------- */
    var reveals = $$('[data-reveal]');
    if (!reduce && 'IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    var el = en.target;
                    el.classList.add('is-in');
                    io.unobserve(el);
                    // once the entrance animation is over, switch to quick hover transitions
                    var delay = parseFloat(getComputedStyle(el).getPropertyValue('--d')) || 0;
                    setTimeout(function () { el.classList.add('done'); }, 1400 + delay * 1000);
                }
            });
        }, { rootMargin: '0px 0px -10% 0px', threshold: 0.05 });
        reveals.forEach(function (el) { io.observe(el); });
    } else {
        reveals.forEach(function (el) { el.classList.add('is-in'); });
    }

    /* 5. Parallax + 8. horizontal scroll share one rAF scroll loop -------- */
    var parallax = reduce ? [] : $$('[data-parallax]');
    var hscrolls = $$('[data-hscroll]');

    function setupHscroll() {
        hscrolls.forEach(function (sec) {
            var track = sec.querySelector('[data-hscroll-track]');
            var active = !reduce && window.innerWidth >= 1024;
            sec.classList.toggle('is-pinned', active);
            if (!active) { sec.style.height = ''; track.style.transform = ''; return; }
            var dist = track.scrollWidth - track.parentElement.clientWidth;
            sec._dist = Math.max(0, dist);
            sec.style.height = (window.innerHeight + sec._dist) + 'px';
        });
    }

    var ticking = false;
    function onScroll() {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(function () {
            ticking = false;
            headerState();
            var vh = window.innerHeight;
            parallax.forEach(function (el) {
                var r = el.getBoundingClientRect();
                if (r.bottom < -100 || r.top > vh + 100) return;
                var speed = parseFloat(el.getAttribute('data-parallax')) || 0.15;
                var offset = (r.top + r.height / 2 - vh / 2) * -speed;
                el.style.transform = 'translate3d(0,' + offset.toFixed(1) + 'px,0) scale(1.12)';
            });
            hscrolls.forEach(function (sec) {
                if (!sec.classList.contains('is-pinned')) return;
                var r = sec.getBoundingClientRect();
                var p = Math.min(1, Math.max(0, -r.top / (sec._dist || 1)));
                sec.querySelector('[data-hscroll-track]').style.transform = 'translate3d(' + (-p * sec._dist).toFixed(1) + 'px,0,0)';
                sec.style.setProperty('--progress', p.toFixed(3));
            });
        });
    }
    setupHscroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', function () { setupHscroll(); onScroll(); });
    window.addEventListener('load', function () { setupHscroll(); onScroll(); });
    onScroll();

    /* 6. 3D tilt + spotlight ------------------------------------------- */
    if (finePointer && !reduce) {
        $$('[data-tilt]').forEach(function (card) {
            var max = parseFloat(card.getAttribute('data-tilt')) || 7;
            card.addEventListener('pointermove', function (e) {
                var r = card.getBoundingClientRect();
                var x = (e.clientX - r.left) / r.width, y = (e.clientY - r.top) / r.height;
                card.style.setProperty('--mx', (x * 100).toFixed(1) + '%');
                card.style.setProperty('--my', (y * 100).toFixed(1) + '%');
                card.style.transform = 'perspective(900px) rotateX(' + ((0.5 - y) * max).toFixed(2) + 'deg) rotateY(' + ((x - 0.5) * max).toFixed(2) + 'deg) translateZ(0)';
            });
            card.addEventListener('pointerleave', function () { card.style.transform = ''; });
        });
    }

    /* 7. Count-up -------------------------------------------------------- */
    var counters = $$('[data-count]');
    function runCount(el) {
        var target = parseFloat(el.getAttribute('data-count'));
        var suffix = el.getAttribute('data-suffix') || '';
        if (reduce || isNaN(target)) { el.textContent = target + suffix; return; }
        var t0 = null, dur = 1600;
        function step(ts) {
            if (!t0) t0 = ts;
            var p = Math.min(1, (ts - t0) / dur);
            var eased = 1 - Math.pow(1 - p, 4);
            el.textContent = Math.round(target * eased) + suffix;
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }
    if ('IntersectionObserver' in window) {
        var cio = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) { if (en.isIntersecting) { runCount(en.target); cio.unobserve(en.target); } });
        }, { threshold: 0.6 });
        counters.forEach(function (el) { cio.observe(el); });
    }

    /* 9. Hero: depth parallax (mouse + scroll) and drifting dust ----------- */
    var hero = document.querySelector('[data-hero]');
    if (hero && !reduce) {
        var layers = $$('[data-depth]', hero);
        var mx = 0, my = 0, cx = 0, cy = 0, heroVisible = true;
        if (finePointer) {
            hero.addEventListener('pointermove', function (e) {
                mx = e.clientX / window.innerWidth - 0.5;
                my = e.clientY / window.innerHeight - 0.5;
            });
        }
        new IntersectionObserver(function (en) { heroVisible = en[0].isIntersecting; }).observe(hero);

        // dust motes floating through the work light
        var canvas = hero.querySelector('[data-dust]');
        var ctx = canvas && canvas.getContext('2d');
        var motes = [], W = 0, H = 0, dpr = Math.min(window.devicePixelRatio || 1, 2);
        function sizeCanvas() {
            W = hero.clientWidth; H = hero.clientHeight;
            canvas.width = W * dpr; canvas.height = H * dpr;
            canvas.style.width = W + 'px'; canvas.style.height = H + 'px';
            ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
            var count = Math.round(Math.min(90, W / 16));
            motes = [];
            for (var i = 0; i < count; i++) motes.push(newMote(true));
        }
        function newMote(anywhere) {
            return {
                x: Math.random() * W,
                y: anywhere ? Math.random() * H : H + 10,
                r: Math.random() * 1.8 + 0.4,
                vx: Math.random() * 0.25 + 0.05,
                vy: -(Math.random() * 0.35 + 0.1),
                a: Math.random() * 0.5 + 0.15,
                tw: Math.random() * Math.PI * 2
            };
        }
        if (ctx) { sizeCanvas(); window.addEventListener('resize', sizeCanvas); }

        (function loop() {
            requestAnimationFrame(loop);
            if (!heroVisible || document.hidden) return;
            cx += (mx - cx) * 0.06; cy += (my - cy) * 0.06;
            var sy = Math.min(window.scrollY, H);
            layers.forEach(function (el) {
                var d = parseFloat(el.getAttribute('data-depth'));
                el.style.transform = 'translate3d(' + (cx * d * W).toFixed(1) + 'px,' + (cy * d * H + sy * d * 4).toFixed(1) + 'px,0)';
            });
            if (!ctx) return;
            ctx.clearRect(0, 0, W, H);
            for (var i = 0; i < motes.length; i++) {
                var m = motes[i];
                m.x += m.vx + cx * 0.4; m.y += m.vy; m.tw += 0.02;
                if (m.y < -10 || m.x > W + 10) motes[i] = m = newMote(false);
                // brighter in the warm light on the right side of the photo
                var light = 0.45 + 0.55 * (m.x / W);
                ctx.globalAlpha = m.a * light * (0.7 + 0.3 * Math.sin(m.tw));
                ctx.fillStyle = '#ffd9b0';
                ctx.beginPath(); ctx.arc(m.x, m.y, m.r, 0, Math.PI * 2); ctx.fill();
            }
            ctx.globalAlpha = 1;
        })();
    }

    /* 10. Quote form ------------------------------------------------------ */
    $$('form[data-ajax]').forEach(function (form) {
        var msg = form.querySelector('[data-form-msg]');
        function show(text, ok) {
            msg.hidden = false;
            msg.textContent = text;
            msg.classList.toggle('form-msg--ok', !!ok);
        }
        function clearErrors() {
            $$('.field__error[data-js]', form).forEach(function (el) { el.remove(); });
            $$('.has-error', form).forEach(function (el) { el.classList.remove('has-error'); });
        }
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearErrors();
            var firstBad = null;
            $$('[required]', form).forEach(function (input) {
                if (!input.value.trim()) { input.closest('.field').classList.add('has-error'); firstBad = firstBad || input; }
            });
            if (firstBad) { show('Please fill in your name and phone number.'); firstBad.focus(); return; }

            form.classList.add('is-sending');
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (res) { return res.json().then(function (data) { return { ok: res.ok, data: data }; }); })
                .then(function (r) {
                    if (r.ok) {
                        form.reset();
                        show(r.data.message, true);
                        if (window.gtag) window.gtag('event', 'generate_lead', { form: form.id });
                        return;
                    }
                    var errors = (r.data && r.data.errors) || {};
                    Object.keys(errors).forEach(function (name) {
                        var input = form.querySelector('[name="' + name + '"]');
                        if (!input) return;
                        var field = input.closest('.field');
                        field.classList.add('has-error');
                        var p = document.createElement('p');
                        p.className = 'field__error';
                        p.setAttribute('data-js', '');
                        p.textContent = errors[name][0];
                        field.appendChild(p);
                    });
                    show((r.data && r.data.message) || 'Something went wrong. Please call us instead.');
                })
                .catch(function () { show('Could not send right now. Please call or WhatsApp us instead.'); })
                .finally(function () { form.classList.remove('is-sending'); });
        });
    });
})();
