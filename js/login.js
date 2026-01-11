let savedUser = {};

function toggleForm(formType) {
  const signUp = document.getElementById('signupForm');
  const signIn = document.getElementById('signinForm');
  if (formType === 'signin') {
    signUp.classList.add('hidden');
    signIn.classList.remove('hidden');
  } else {
    signUp.classList.remove('hidden');
    signIn.classList.add('hidden');
  }
}

document.getElementById('signupForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const name = document.getElementById('signupName').value;
  const email = document.getElementById('signupEmail').value;
  const username = document.getElementById('signupUsername').value;
  const pass = document.getElementById('signupPassword').value;
  const repeat = document.getElementById('signupRepeat').value;

  if (pass !== repeat) {
    alert("Passwords do not match.");
    return;
  }

  savedUser = { name, email, username, pass };
  showPopup("Sign up successful!");
  toggleForm('signin');
});

document.getElementById('signinForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const email = document.getElementById('signinEmail').value;
  const pass = document.getElementById('signinPassword').value;

  if (email === savedUser.email && pass === savedUser.pass) {
    window.location.href = "index.html";
  } else {
    alert("Invalid email or password.");
  }
});

function showPopup(message) {
  const popup = document.getElementById('popup');
  popup.textContent = message;
  popup.classList.remove('hidden');
  setTimeout(() => {
    popup.classList.add('hidden');
  }, 2000);
}
