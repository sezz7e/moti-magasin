import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const mm = gsap.matchMedia();

mm.add(
    { reduce: '(prefers-reduced-motion: reduce)', desktop: '(min-width: 768px)' },
    (ctx) => {
        const { reduce, desktop } = ctx.conditions;
        if (reduce) return;

        // Hero: layered depth as you scroll (pinned on desktop only)
        const hero = document.querySelector('[data-hero]');
        if (hero) {
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: hero,
                    start: 'top top',
                    end: desktop ? '+=100%' : 'bottom top',
                    scrub: 0.6,
                    pin: desktop,
                },
            });

            tl.to('[data-hero-img]', { scale: 1.2, rotateX: 10, rotateY: -8, yPercent: -6, ease: 'none' }, 0)
              .to('[data-hero-ring]', { scale: 1.7, rotate: 90, opacity: 0, ease: 'none' }, 0)
              .to('[data-hero-text]', { yPercent: -80, opacity: 0, ease: 'none' }, 0);
        }

        // 3D reveal: elements tip up from below as they enter the screen
        gsap.utils.toArray('[data-reveal]').forEach((el) => {
            gsap.fromTo(
                el,
                { opacity: 0, y: 70, rotateX: 22, transformOrigin: '50% 100%' },
                {
                    opacity: 1, y: 0, rotateX: 0, duration: 1, ease: 'power3.out',
                    scrollTrigger: { trigger: el, start: 'top 90%' },
                }
            );
        });

        // Mouse tilt on collection tiles (devices with a real pointer only)
        if (window.matchMedia('(hover: hover)').matches) {
            document.querySelectorAll('[data-tilt]').forEach((el) => {
                el.addEventListener('mousemove', (e) => {
                    const r = el.getBoundingClientRect();
                    const x = (e.clientX - r.left) / r.width - 0.5;
                    const y = (e.clientY - r.top) / r.height - 0.5;
                    gsap.to(el, { rotateY: x * 14, rotateX: -y * 14, duration: 0.4, ease: 'power2.out' });
                });
                el.addEventListener('mouseleave', () => {
                    gsap.to(el, { rotateY: 0, rotateX: 0, duration: 0.6, ease: 'power3.out' });
                });
            });
        }
    }
);