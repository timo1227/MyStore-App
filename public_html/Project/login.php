<?php require(__DIR__ . "/../../partials/nav.php");
?>
<link rel="stylesheet" href="Styles/form.css" />
<link rel="stylesheet" href="Styles/nav.css">
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
    <input type="submit" value="Login" />
</form>
<script>
    function validate(form) {
        //TODO 1: implement JavaScript validation
        //ensure it returns false for an error and true for success
        let Valid = true;
        let email = form.email.value;
        let re =
            /^(([^<>()\[\]\.,;:\s@"]+(\.[^<>()\[\]\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        let pw = form.password.value;

        //Check email address
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
        if (pw.length < 8) {
            document.getElementById("invalid_pw").innerHTML =
                "Password must be at least 8 characters";
            Valid = false;
        } else {
            document.getElementById("invalid_pw").innerHTML = "";
        }
        return Valid;
    }



    //Checks if All fields are filled to change the color of the submit button
    const ChgBtnColor = () => {
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

    document.querySelector("input[type='password']").addEventListener("keyup", ChgBtnColor);
</script>
<?php
//TODO 2: add PHP Code
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);

    //TODO 3
    $hasError = false;
    if (empty($email)) {
        echo "Email must not be empty";
        $hasError = true;
    }
    //sanitize email
    // $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = sanitize_email($email);

    //validate email
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     $hasError = true;
    //     echo "Email is invalid! Enter a valid email address";
    // }
    if (!is_valid_email($email)) {
        $hasError = true;
        echo "Email is invalid! Enter a valid email address";
    }

    if (empty($password)) {
        echo "password must not be empty";
        $hasError = true;
    }
    if (strlen($password) < 8) {
        echo "Password too short";
        $hasError = true;
    }
    if (!$hasError) {
        //TODO 4
        $db = getDB();
        $stmt = $db->prepare("SELECT email, password FROM Users WHERE email = :email");
        try {
            $stmt->execute([":email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $hash = $user["password"];
                unset($user["password"]);
                if (password_verify($password, $hash)) {
                    $_SESSION["user"] = $user;
                    //redirect to home page
                    die(header("Location: /Project/home.php"));
                } else {
                    echo "Invalid password";
                }
            } else {
                echo "Email not found";
            }
        } catch (Exception $e) {
            echo "<div class='registerMessage'> Error: <pre> " . var_export($e, true) . "</pre></div>";
        }
    }
}
?>