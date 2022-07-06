<?php require_once(__DIR__ . "/../../partials/nav.php"); ?>
<link rel="stylesheet" href="Styles/form.css" />
<link rel="stylesheet" href="Styles/nav.css">
<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required />
        <div class="FormMessage" id="invalid_Emial"></div>
    </div>
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" required maxlength="30" />
        <div class="FormMessage" id="invalid_Username"></div>
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
        <div class="FormMessage" id="invalid_pw"></div>
    </div>
    <div>
        <label for="confirm">Confirm</label>
        <input type="password" name="confirm" required minlength="8" />
        <div class="FormMessage" id="matchingError"></div>
    </div>
    <input type="submit" value="Register" />
</form>
<script>
    //Checks if All fields are filled to change the color of the submit button
    const registerButton = () => {
        const inputs = document.querySelectorAll("input");
        let filled = true;
        inputs.forEach(input => {
            if (input.value === "") {
                filled = false;
            }
        });
        //Change Color of Submit Button
        if (filled) {
            document.querySelector("input[type='submit']").style.backgroundColor = "#1AA7EC";
        } else {
            document.querySelector("input[type='submit']").style.backgroundColor = "lightgrey";
        }
    };

    function validate(form) {
        //TODO 1: implement JavaScript validation
        let Valid = true;
        //Validate email address
        let email = form.email.value;
        let re =
            /^(([^<>()\[\]\.,;:\s@"]+(\.[^<>()\[\]\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email.length == 0) {
            document.getElementById("invalid_Emial").innerHTML =
                "Email is required";
            Valid = false;
        } else if (!re.test(email)) {
            document.getElementById("invalid_Emial").innerHTML =
                "Email is invalid";
            Valid = false;
        } else {
            document.getElementById("invalid_Emial").innerHTML = "";
        }
        //Validate username
        let username = form.username.value;
        re = /^[a-z0-9_-]{3,30}$/;
        if (username.length == 0) {
            document.getElementById("invalid_Username").innerHTML =
                "Username is required";
            Valid = false;
        } else if (username.length < 3) {
            document.getElementById("invalid_Username").innerHTML =
                "Username must be at least 3 characters";
            Valid = false;
        } else if (!re.test(username)) {
            document.getElementById("invalid_Username").innerHTML =
                "Username is invalid";
            Valid = false;
        } else {
            document.getElementById("invalid_Username").innerHTML = "";
        }
        //Check Length of Password
        let pw = form.password.value;
        if (pw.length < 8) {
            document.getElementById("invalid_pw").innerHTML =
                "Password must be at least 8 characters long";
            Valid = false;
        } else {
            document.getElementById("invalid_pw").innerHTML = "";
        }
        //Check if passwords match
        let confirm = form.confirm.value;
        if (pw.length > 0 && pw != confirm) {
            document.getElementById("matchingError").innerHTML =
                "Passwords Must Macth";
            document.getElementById("invalid_pw").innerHTML =
                "Password Must Match";
            Valid = false;
        } else {
            document.getElementById("matchingError").innerHTML = "";
            document.getElementById("invalid_pw").innerHTML = "";
        }
        //ensure it returns false for an error and true for success
        return Valid;
    }

    //Event Listener for when the user types in the form
    document.querySelector("form").addEventListener("input", registerButton);
</script>

<?php
//TODO 2: add PHP Code
if (isset($_POST['email']) && $_POST['password'] && $_POST['confirm'] && $_POST['username']) {
    $email = se($_POST, "email", "", false); //$_POST['email'];
    $password = se($_POST, 'password', "", false); //$_POST['password'];
    $confirm = se($_POST, 'confirm', "", false); //$_POST['confirm'];
    $username = se($_POST, 'username', "", false); //$_POST['username'];
    //TODO 3: add PHP Code
    $hasError = false;
    if (empty($email)) {
        $hasError = true;
        flash("Email is required");
    }
    //sanitize email
    // $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = sanitize_email($email);

    //validate email
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     $hasError = true;
    //     flash("Email is invalid! Enter a valid email address");
    // }
    if (!is_valid_email($email)) {
        $hasError = true;
        flash("Email is invalid! Enter a valid email address");
    }
    if (!preg_match("/^[a-z0-9_-]{3,30}$/", $username)) {
        $hasError = true;
        flash("Username must be lowercase, alphanumeric, can only contain _ or - , and be 3 to 30 characters long ", 'warning');
    }
    if (empty($password)) {
        $hasError = true;
        flash("Password is required");
    }
    if (empty($confirm)) {
        $hasError = true;
        flash("Confirm is required");
    }
    if (strlen($password) < 8) {
        $hasError = true;
        flash("Password must be at least 8 characters");
    }
    if (strlen($password) > 0 && $password != $confirm) {
        $hasError = true;
        flash("Passwords do not match");
    }
    if (!$hasError) {
        //TODO 4: PASSWORD HASHING
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, username, password) VALUES (:email, :username, :password)");
        try {
            $stmt->execute([
                ':email' => $email,
                ':username' => $username,
                ':password' => $hash
            ]);
            flash("Successfully Registered!");
            //Hide the form
            echo "<script>document.querySelector('form').style.display = 'none';</script>";
        } catch (Exception $e) {
            flash("Error: <pre> " . var_export($e, true) . "</pre>");
        }
    }
}
?>
<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>