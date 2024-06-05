<html>
<head>
<title>SquadScope</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    }

</style>

</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
              </li>
              <button id="login">Login</button>
              <div id="loginModal" class="modal">
                  <div class="modal-content">
                      <span class="close">&times;</span>
                        <form name="loginForm" action="/submit_login" onsubmit="return validateForm()" method="post">
                          @csrf
                          <label for="username">Username:</label><br>
                          <input type="text" id="login-username" name="username"><br>
                          <label for="password">Password:</label><br>
                          <input type="password" id="login-password" name="password"><br>
                          <input type="submit" value="Login">
                      </form>
                  </div>
              </div>

              <button id="register">Register</button>
              <div id="regModal" class="modal">
                  <div class="modal-content">
                      <span class="regclose">&times;</span>
                      <form name="registrationForm" action="{{ route('registration.store') }}" onsubmit="return validateForm()" method="post">
                          @csrf
                          <label for="name">Name:</label><br>
                          <input type="text" id="name" name="name"><br>
                          <label for="username">Username:</label><br>
                          <input type="text" id="register-username" name="username"><br>
                          <label for="email">Email:</label><br>
                          <input type="text" id="email" name="email"><br>
                          <label for="password">Password:</label><br>
                          <input type="password" id="register-password" name="password"><br>
                          <input type="submit" value="Register">
                      </form>
                  </div>
              </div>

            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
          </div>
      </nav>
    </div>

    <script>
      // Function to validate form inputs
      function validateForm() {
          // Basic validation for registration form
          const username = document.getElementById("register-username").value;
          const email = document.getElementById("email").value;
          const password = document.getElementById("register-password").value;
  
          if (username === "" || email === "" || password === "") {
              alert("All fields must be filled out");
              return false;
          }
  
          return true;
      }
  
      // Function to handle form submissions
      function handleSubmit(event) {
          event.preventDefault(); // Prevent the default form submission behavior
  
          const formData = new FormData(event.target); // Create a FormData object from the form
          const data = Object.fromEntries(formData.entries()); // Convert FormData to a plain object
  
          fetch('/submit_registration', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
              },
              body: JSON.stringify(data) // Send the form data as JSON
          })
         .then(response => response.text())
         .then(text => {
            console.log('Server response:', text); // Log de volledige serverrespons
            const data = JSON.parse(text); // Probeer de tekst om te zetten naar JSON
            if (data.success) {
                document.getElementById('regModal').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error); // Log eventuele fouten
          });
      }
  
      // Event listeners for opening/closing modals
      document.getElementById("register").onclick = function() {
          document.getElementById("regModal").style.display = "block";
      };
      document.querySelector(".regclose").onclick = function() {
          document.getElementById("regModal").style.display = "none";
      };
  
      document.getElementById("login").onclick = function() {
          document.getElementById("loginModal").style.display = "block";
      };
      document.querySelector(".close").onclick = function() {
          document.getElementById("loginModal").style.display = "none";
      };
  
      document.querySelectorAll('form').forEach(form => {
          form.addEventListener('submit', handleSubmit);
      });
  </script>
  
  