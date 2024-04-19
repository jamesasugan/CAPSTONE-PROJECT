// for eye password icon
function togglePasswordVisibility() {
  var passwordInput = document.getElementById('password');
  var passwordIcon = document.getElementById('password-icon');
  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    passwordIcon.className = 'fas fa-eye-slash';
  } else {
    passwordInput.type = 'password';
    passwordIcon.className = 'fas fa-eye';
  }
}
