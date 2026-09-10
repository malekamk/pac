document.addEventListener('DOMContentLoaded', () => {
  const page = document.body.getAttribute('data-page');
  document.querySelectorAll('nav.main-nav a[data-page]').forEach((a) => {
    if (a.getAttribute('data-page') === page) a.classList.add('active');
  });

  const toggle = document.querySelector('[data-nav-toggle]');
  const nav = document.querySelector('nav.main-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => nav.classList.toggle('open'));
  }

  const yearEl = document.querySelector('[data-year]');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  const siteHeader = document.querySelector('[data-site-header]');
  if (siteHeader) {
    const onScroll = () => siteHeader.classList.toggle('is-scrolled', window.scrollY > 12);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }
});
