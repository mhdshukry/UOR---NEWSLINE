document.addEventListener("DOMContentLoaded", function () {
  const home = document.querySelector('.home');
  const formContainer = document.querySelector('.form_container');
  const signupBtn = document.getElementById('signup');
  const loginBtn = document.getElementById('login');
  const loginForm = document.querySelector('.login_form');
  const signupForm = document.querySelector('.signup_form');
  const pwToggles = document.querySelectorAll('.pw_hide');

  // Directly open login form when the page loads
  home.classList.add('show');
  formContainer.classList.add('show');
  loginForm.classList.add('show');

  signupBtn.addEventListener('click', (e) => {
    e.preventDefault();
    loginForm.classList.remove('show');
    signupForm.classList.add('show');
  });

  loginBtn.addEventListener('click', (e) => {
    e.preventDefault();
    signupForm.classList.remove('show');
    loginForm.classList.add('show');
  });

  pwToggles.forEach(toggle => {
    toggle.addEventListener('click', () => {
      const passwordField = toggle.previousElementSibling.previousElementSibling;
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      toggle.classList.toggle('uil-eye');
      toggle.classList.toggle('uil-eye-slash');
    });
  });
});


document.getElementById('profile_picture').addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (event) {
      document.getElementById('profile_preview').setAttribute('src', event.target.result);
    }
    reader.readAsDataURL(file);
  } else {
    document.getElementById('profile_preview').setAttribute('src', './assets/images/pro.png');
  }
});
