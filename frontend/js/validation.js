function validatePhoneNumber() {
    const phoneInput = document.getElementById('telephone');
    const phoneValue = phoneInput.value;
    const phoneHelp = document.getElementById('phoneHelp');
    
    const phonePattern = /^[+]?[0-9]{1,3}?[-\s]?[0-9]{1,4}?[-\s]?[0-9]{4,6}$/;
    
    if (phonePattern.test(phoneValue)) {
       
        phoneInput.style.borderColor = '#28a745'; 
        phoneInput.style.backgroundColor = '#d4edda'; 
        
        phoneHelp.textContent = "Valid phone number!";
        phoneHelp.style.color = '#28a745'; 
    } else {
        phoneInput.style.borderColor = '#dc3545'; 
        phoneInput.style.backgroundColor = '#f8d7da'; 
        
        phoneHelp.textContent = "Invalid phone number. Please enter a valid telephone number.";
        phoneHelp.style.color = '#dc3545'; 
    }
}


function validateEmail() {
    const emailInput = document.getElementById('email');
    const emailValue = emailInput.value;
    const emailHelp = document.getElementById('emailHelp');
    
  
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (emailPattern.test(emailValue)) {
        emailInput.style.borderColor = '#28a745'; 
        emailInput.style.backgroundColor = '#d4edda'; 
        
        emailHelp.textContent = "Valid email address!";
        emailHelp.style.color = '#28a745'; 
    } else {
        emailInput.style.borderColor = '#dc3545'; 
        emailInput.style.backgroundColor = '#f8d7da'; 
        
        emailHelp.textContent = "Invalid email address. Please enter a valid email.";
        emailHelp.style.color = '#dc3545'; 
    }
}


function validatePassword() {
    const passwordInput = document.getElementById('password');
    const passwordValue = passwordInput.value;
    const passwordHelp = document.getElementById('passwordHelp');
    
    const strongPasswordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/;
    
    if (strongPasswordPattern.test(passwordValue)) {
        passwordInput.style.borderColor = '#28a745';
        passwordInput.style.backgroundColor = '#d4edda';
        passwordHelp.textContent = "Strong password!";
        passwordHelp.style.color = '#28a745';
    } else {
        passwordInput.style.borderColor = '#dc3545';
        passwordInput.style.backgroundColor = '#f8d7da';
        passwordHelp.textContent = "Password must be at least 8 characters long and include a number and a special character.";
        passwordHelp.style.color = '#dc3545';
    }
}

function validatePasswordMatch() {
    const passwordValue = document.getElementById('password').value;
    const confirmPasswordValue = document.getElementById('cpassword').value;
    const confirmPasswordHelp = document.getElementById('confirmPasswordHelp');
    const confirmPasswordInput = document.getElementById('cpassword');
    
    if (passwordValue === confirmPasswordValue) {
        confirmPasswordInput.style.borderColor = '#28a745';
        confirmPasswordInput.style.backgroundColor = '#d4edda';
        confirmPasswordHelp.textContent = "Passwords match!";
        confirmPasswordHelp.style.color = '#28a745';
    } else {
        confirmPasswordInput.style.borderColor = '#dc3545';
        confirmPasswordInput.style.backgroundColor = '#f8d7da';
        confirmPasswordHelp.textContent = "Passwords do not match.";
        confirmPasswordHelp.style.color = '#dc3545';
    }
}