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

// for requirements on password
const passwordInput = document.getElementById('password');
const confirmPasswordInput = document.getElementById('confirm-password');
const submitButton = document.querySelector('.signup-btn input[type="submit"]');
const requirementList = document.querySelectorAll('.requirement-list li');

const requirements = [
  { regex: /.{8,}/, index: 0 },
  { regex: /[0-9]/, index: 1 },
  { regex: /[A-Z]/, index: 2 },
];

function updateRequirements() {
  let allValid = true;
  requirements.forEach((item) => {
    const isValid = item.regex.test(passwordInput.value);
    const requirementItem = requirementList[item.index];

    if (isValid) {
      requirementItem.firstElementChild.className = 'fa-solid fa-check';
      requirementItem.classList.add('valid');
    } else {
      requirementItem.firstElementChild.className = 'fa-solid fa-circle';
      requirementItem.classList.remove('valid');
      allValid = false;
    }
  });

  // Check if confirm password matches
  const passwordsMatch = passwordInput.value === confirmPasswordInput.value;
  confirmPasswordInput.style.borderColor = passwordsMatch ? 'green' : 'red';

  // Enable or disable submit button based on validations and match
  submitButton.disabled = !allValid || !passwordsMatch;
}

passwordInput.addEventListener('input', updateRequirements);
confirmPasswordInput.addEventListener('input', updateRequirements);
