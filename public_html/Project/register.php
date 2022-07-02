<?php require_once(__DIR__ . "/../../lib/function.php"); ?>
<link rel="stylesheet" href="Styles/register.css" />
<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" required />
        <div class="Alert" id="invalid_Emial"></div>
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
        <div class="Alert" id="invalid_pw"></div>
    </div>
    <div>
        <label for="confirm">Confirm</label>
        <input type="password" name="confirm" required minlength="8" />
        <div class="Alert" id="matchingError"></div>
    </div>
    <input type="submit" value="Register" />
</form>
<script>
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
        if (Valid) {
            return true;
        } else {
            return false;
        }
    }
</script>

<?php
//TODO 2: add PHP Code
if (isset($_POST['email']) && $_POST['password'] && $_POST['confirm']) {
    $email = se($_POST, "email", "", false); //$_POST['email'];
    $password = se($_POST, 'password', "", false); //$_POST['password'];
    $confirm = se($_POST, 'confirm', "", false); //$_POST['confirm'];
    //TODO 3: add PHP Code
    $hasError = false;
    if (empty($email)) {
        $hasError = true;
        echo "Email is required";
    }
    //sanitize email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    //validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $hasError = true;
        echo "Email is invalid! Enter a valid email address";
    }

    if (empty($password)) {
        $hasError = true;
        echo "Password is required";
    }
    if (empty($confirm)) {
        $hasError = true;
        echo "Confirm is required";
    }
    if (strlen($password) < 8) {
        $hasError = true;
        echo "Password must be at least 8 characters";
    }
    if (strlen($password) > 0 && $password != $confirm) {
        $hasError = true;
        echo "Passwords do not match";
    }
    if (!$hasError) {
        echo "Success! Welcome , $email";
    }
}
?>