// Countdown to the 4 November 2026 Local Government Elections
document.addEventListener('DOMContentLoaded', () => {
  const el = document.querySelector('[data-election-countdown]');
  if (!el) return;
  const target = new Date('2026-11-04T07:00:00+02:00').getTime();
  const render = () => {
    const diff = target - Date.now();
    if (diff <= 0) { el.textContent = 'Election day is here — go vote!'; return; }
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    el.textContent = days + ' days to the 2026 Local Government Elections';
  };
  render();
  setInterval(render, 1000 * 60 * 60);
});

// Membership / contact form: static-site friendly mailto handoff
document.addEventListener('submit', (e) => {
  const form = e.target.closest('form[data-mailto]');
  if (!form) return;
  e.preventDefault();
  const to = form.getAttribute('data-mailto');
  const data = new FormData(form);
  const lines = [];
  for (const [key, value] of data.entries()) lines.push(`${key}: ${value}`);
  const subject = encodeURIComponent(form.getAttribute('data-subject') || 'Website enquiry');
  const body = encodeURIComponent(lines.join('\n'));
  window.location.href = `mailto:${to}?subject=${subject}&body=${body}`;
  const note = form.querySelector('[data-form-note]');
  if (note) note.textContent = 'Opening your email client to send this form…';
});
