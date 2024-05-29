

// REPLACE THE INPUT USERNAME IN THE CARD

let inputUser = document.getElementById('input-user');
let usernameText = document.getElementById('username-text');

inputUser.addEventListener("input", updateUsername);

function updateUsername(e) {
    usernameText.textContent = "@" + e.srcElement.value;
}



function validateUsername() {
    const usernameInput = document.getElementById('input-user');
    const statusText = document.getElementById('username-status');
    const username = usernameInput.value;
    
    // VALIDATE THE LENGTH
    if (username.length < 5 || username.length > 15) {
        statusText.textContent = 'Username must be between 5 and 15 characters';
        return;
    }
    
    
    // VALIDATE THE SPECIAL CHARACTERS
    if (!/^\w+$/.test(username)) {
        statusText.textContent = 'Username can only contain letters, numbers, and underscores';
        return;
    }

    statusText.textContent = ''; // IF EVERYTHING IS CORRECT, CLEAN THE CONTENT;
    
    // AJAX VALIDATION FOR DE USERNAME DISPONIBILITY
    checkUsernameAvailability(username);
}

// CHECK IF THE USERNAME IS AVAILABLE

function checkUsernameAvailability(username) {
    const statusText = document.getElementById('username-status');
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/check-username.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            const response = JSON.parse(this.responseText);
            if (!response.isAvailable) {
                statusText.textContent = response.message;
            } else {
                statusText.textContent = 'Username is available';
            }
        }
    };
    xhr.send('username=' + encodeURIComponent(username));
}



document.getElementById('input-user').addEventListener('input', function() {
    var username = this.value;
    var statusDiv = document.getElementById('username-status');

    // vALIDATE THE UNNECESSARY PETITIONS ON THE CLIENT 
    if (username.length < 5 || username.length > 15 || !/^\w+$/.test(username)) {
        statusDiv.textContent = 'Username must be between 5 and 15 characters and can only contain letters, numbers, and underscores.';
        statusDiv.style.color = 'red';
        return;
    }

    // CREATE AN OBJECT FORMDATA TO SEND THE USERNAME

    var formData = new FormData();
    formData.append('username', username);

    // CREATE AND SEND THE AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../php/check-username.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.isAvailable) {
                statusDiv.textContent = response.message;
                statusDiv.style.color = 'green';
            } else {
                statusDiv.textContent = response.message;
                statusDiv.style.color = 'red';
            }
        }
    };
    xhr.send(formData);
});

// VALIDATE IF THE PROFILE WAS UPDATED 

$(document).ready(function() {
    $('#profileForm').on('submit', function(e) {
        e.preventDefault();
        var username = $('#input-user').val();
        $.ajax({
            type: 'POST',
            url: '../php/check-username.php',
            data: {username: username},
            success: function(response) {
                alert(response);
                if (response === "Profile updated successfully.") {
                    window.location.href = '../index.php'; // REDIRECT IF ALL IS CORRECT
                } else {
                    $('#input-user').val('').focus(); // CLEAN THE INPUT FOR A NEW TRY
                }
            }
        });
    });
});

//Style of search button when is focus on the input

function inputFocus() {
    document.getElementById('fa-search').style.color="black";
}

function inputNoFocus() {
    document.getElementById('fa-search').style.color="white";
}