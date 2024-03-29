<?php require(__DIR__ . "/../../partials/nav.php"); ?>
<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Username</label>
        <input type="text" name="email" required />
        <div class="FormMessage" id="invalid_Emial"></div>
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
        <div class="FormMessage" id="invalid_pw"></div>
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
        let UsernameRegex = /^[a-z0-9_-]{3,30}$/;

        //Check if email or Username
        if (email.length == 0) {
            document.getElementById("invalid_Emial").innerHTML =
                "Username is required";
            Valid = false;
        } else if (!re.test(email)) {
            if (!UsernameRegex.test(email)) {
                document.getElementById("invalid_Emial").innerHTML =
                    "Username is invalid";
                Valid = false;
            }
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
    //Checks if All fields are filled to change the color of the submit button
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
        flash("Email must not be empty");
        $hasError = true;
    }
    if (str_contains($email, "@")) {
        //sanitize
        $email = sanitize_email($email);
        if (!is_valid_email($email)) {
            flash("Invalid email address");
            $hasError = true;
        }
    } else {
        if (!is_valid_username($email)) {
            flash("Invalid username");
            $hasError = true;
        }
    }
    if (empty($password)) {
        flash("password must not be empty");
        $hasError = true;
    }
    if (!is_valid_password($password)) {
        flash("Password too short");
        $hasError = true;
    }
    if (!$hasError) {
        //flash("Welcome, $email");
        //TODO 4
        $db = getDB();
        $stmt = $db->prepare("SELECT id, email, username, password from Users 
        where email = :email or username = :email");
        try {
            $r = $stmt->execute([":email" => $email]);
            if ($r) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    $hash = $user["password"];
                    unset($user["password"]);
                    if (password_verify($password, $hash)) {
                        //flash("Weclome $email");
                        $_SESSION["user"] = $user; //sets our session data from db
                        //lookup potential roles
                        $stmt = $db->prepare("SELECT Roles.name FROM Roles 
                        JOIN UserRoles on Roles.id = UserRoles.role_id 
                        where UserRoles.user_id = :user_id and Roles.is_active = 1 and UserRoles.is_active = 1");
                        $stmt->execute([":user_id" => $user["id"]]);
                        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC); //fetch all since we'll want multiple
                        //save roles or empty array
                        if ($roles) {
                            $_SESSION["user"]["roles"] = $roles; //at least 1 role
                        } else {
                            $_SESSION["user"]["roles"] = []; //no roles
                        }
                        flash("Welcome, " . get_username());
                        die("<script>location.replace('home.php');</script>");
                    } else {
                        flash("Invalid password");
                    }
                } else {
                    flash("Username not found");
                }
            }
        } catch (Exception $e) {
            flash("<pre>" . var_export($e, true) . "</pre>");
        }
    }
}
?>
<?php
require(__DIR__ . "/../../partials/flash.php");
