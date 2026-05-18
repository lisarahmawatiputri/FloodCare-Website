/* FloodCare — Admin Login JS */

document.addEventListener('DOMContentLoaded', () => {

  /* ── Toggle password visibility ── */
  const toggleBtn = document.getElementById('togglePw');
  const pwInput   = document.getElementById('password');
  const eyeIcon   = document.getElementById('eyeIcon');

  const eyeOnPath  = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
  const eyeOffPath = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;

  let visible = false;

  if (toggleBtn && pwInput && eyeIcon) {
    toggleBtn.addEventListener('click', () => {
      visible = !visible;
      pwInput.type       = visible ? 'text' : 'password';
      eyeIcon.innerHTML  = visible ? eyeOffPath : eyeOnPath;
    });
  }

  /* ── Toggle new password visibility (reset-password page) ── */
  const toggleNewPw = document.getElementById('toggleNewPw');
  const newEyeIcon  = document.getElementById('newEyeIcon');
  // reset-password punya input#password tapi togglenya beda id
  const newPwInput  = toggleNewPw ? toggleNewPw.closest('.input-wrap')?.querySelector('input') : null;
  let newVisible = false;
  if (toggleNewPw && newPwInput && newEyeIcon) {
    toggleNewPw.addEventListener('click', () => {
      newVisible = !newVisible;
      newPwInput.type      = newVisible ? 'text' : 'password';
      newEyeIcon.innerHTML = newVisible ? eyeOffPath : eyeOnPath;
    });
  }

  /* ── Toggle confirm password visibility ── */
  const toggleConfirmPw = document.getElementById('toggleConfirmPw');
  const confirmEyeIcon  = document.getElementById('confirmEyeIcon');
  const confirmPwInput  = toggleConfirmPw ? toggleConfirmPw.closest('.input-wrap')?.querySelector('input') : null;
  let confirmVisible = false;
  if (toggleConfirmPw && confirmPwInput && confirmEyeIcon) {
    toggleConfirmPw.addEventListener('click', () => {
      confirmVisible = !confirmVisible;
      confirmPwInput.type      = confirmVisible ? 'text' : 'password';
      confirmEyeIcon.innerHTML = confirmVisible ? eyeOffPath : eyeOnPath;
    });
  }

  /* ── Ripple effect on any .btn-login ── */
  document.querySelectorAll('.btn-login').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const rect   = btn.getBoundingClientRect();
      const size   = Math.max(rect.width, rect.height);
      const ripple = document.createElement('span');

      ripple.classList.add('ripple');
      ripple.style.cssText = `
        width:  ${size}px;
        height: ${size}px;
        left:   ${e.clientX - rect.left - size / 2}px;
        top:    ${e.clientY - rect.top  - size / 2}px;
      `;

      btn.appendChild(ripple);
      ripple.addEventListener('animationend', () => ripple.remove());
    });
  });

  /* ── Loading state on form submit ── */
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', () => {
      const btn     = form.querySelector('.btn-login');
      const spinner = form.querySelector('.spinner') || document.getElementById('spinner');
      const btnText = form.querySelector('#btnText') || form.querySelector('.btn-text');

      if (spinner) spinner.style.display = 'block';
      if (btnText) btnText.textContent = 'Memproses...';
      if (btn) btn.disabled = true;
    });
  });

  /* ── Resend email cooldown ── */
  const resendBtn = document.getElementById('resendBtn');
  if (resendBtn) {
    resendBtn.addEventListener('click', () => {
      let secs = 30;
      resendBtn.disabled = true;
      const orig = resendBtn.textContent;
      const tick = setInterval(() => {
        resendBtn.textContent = `Kirim ulang (${secs}s)`;
        secs--;
        if (secs < 0) {
          clearInterval(tick);
          resendBtn.disabled = false;
          resendBtn.textContent = orig;
        }
      }, 1000);
    });
  }

});