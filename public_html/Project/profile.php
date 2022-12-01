<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
?>
<?php
if (isset($_POST["save"])) {
    $email = se($_POST, "email", null, false);
    $username = se($_POST, "username", null, false);
    $hasError = false;
    //sanitize
    $email = sanitize_email($email);
    //validate
    if (!is_valid_email($email)) {
        flash("Invalid email address", "danger");
        $hasError = true;
    }
    if (!is_valid_username($username)) {
        flash("Username must only contain 3-16 characters a-z, 0-9, _, or -", "danger");
        $hasError = true;
    }
    if (!$hasError) {
        $params = [":email" => $email, ":username" => $username, ":id" => get_user_id()];
        $db = getDB();
        $stmt = $db->prepare("UPDATE Users set email = :email, username = :username where id = :id");
        try {
            $stmt->execute($params);
            flash("Profile saved", "success");
        } catch (Exception $e) {
            users_check_duplicate($e->errorInfo);
        }
        //select fresh data from table
        $stmt = $db->prepare("SELECT id, email, username from Users where id = :id LIMIT 1");
        try {
            $stmt->execute([":id" => get_user_id()]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                //$_SESSION["user"] = $user;
                $_SESSION["user"]["email"] = $user["email"];
                $_SESSION["user"]["username"] = $user["username"];
            } else {
                flash("User doesn't exist", "danger");
            }
        } catch (Exception $e) {
            flash("An unexpected error occurred, please try again", "danger");
            //echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        }
    }


    //check/update password
    $current_password = se($_POST, "currentPassword", null, false);
    $new_password = se($_POST, "newPassword", null, false);
    $confirm_password = se($_POST, "confirmPassword", null, false);
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        $hasError = false;
        if (!is_valid_password($new_password)) {
            flash("Password too short", "danger");
            $hasError = true;
        }
        if (!$hasError) {
            if ($new_password === $confirm_password) {
                //TODO validate current
                $stmt = $db->prepare("SELECT password from Users where id = :id");
                try {
                    $stmt->execute([":id" => get_user_id()]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (isset($result["password"])) {
                        if (password_verify($current_password, $result["password"])) {
                            $query = "UPDATE Users set password = :password where id = :id";
                            $stmt = $db->prepare($query);
                            $stmt->execute([
                                ":id" => get_user_id(),
                                ":password" => password_hash($new_password, PASSWORD_BCRYPT)
                            ]);

                            flash("Password reset", "success");
                        } else {
                            flash("Current password is invalid", "warning");
                        }
                    }
                } catch (Exception $e) {
                    echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
                }
            } else {
                flash("New passwords don't match", "warning");
            }
        }
    }

    //Check/update Profile Privacy
    $profile_privacy = se($_POST, "profile_privacy", null, false);
    if (!empty($profile_privacy)) {
        $stmt = $db->prepare("UPDATE Users set Profile = :profile_privacy where id = :id");
        try {
            $stmt->execute([
                ":id" => get_user_id(),
                ":profile_privacy" => $profile_privacy
            ]);
        } catch (Exception $e) {
            echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        }
    } else {
        $profile_privacy = "Public";
        $stmt = $db->prepare("UPDATE Users set Profile = :profile_privacy where id = :id");
        try {
            $stmt->execute([
                ":id" => get_user_id(),
                ":profile_privacy" => $profile_privacy
            ]);
        } catch (Exception $e) {
            echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        }
    }
}

//Check if User is Private Or Public 
$db = getDB();
$stmt = $db->prepare("SELECT * from Users where id = :id");
$is_Private = false;
try {
    $stmt->execute([":id" => get_user_id()]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user["Profile"] == "Private") {
        $is_Private = true;
    }
} catch (Exception $e) {
    echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
}
?>

<?php
$email = get_user_email();
$username = get_username();
?>
<div class="container-fluid main">
    <h1>Edit Profile</h1>
    <form method="POST" onsubmit="return validate(this);">
        <div style="text-align:center; font-size:22px; margin: 10px 0px; font-weight: 700;">Email/Username Reset</div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php se($email); ?>" />
        </div>
        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php se($username); ?>" />
        </div>
        <div style="text-align:center; font-size:22px; margin: 10px 0px; font-weight: 700;">Profile Privacy</div>
        <div class="mb-3">
            <!-- <label for="Public/Private">Private</label>
            <input type="radio" name="Public/Private" value="Private" />
            <label for="Public">Public</label>
            <input type="radio" name="Public/Private" value="Public" /> -->
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" value="Private" name="profile_privacy" <?php if ($is_Private) : echo "checked";
                                                                                                                        endif; ?>>
                <label class="form-check-label" for="profile_privacy">Private Profile</label>
            </div>


        </div>
        <!-- DO NOT PRELOAD PASSWORD -->
        <div style="text-align:center; font-size:22px; margin: 10px 0px; font-weight: 700;">Password Reset</div>
        <div class="mb-3">
            <label for="cp">Current Password</label>
            <input type="password" name="currentPassword" id="cp" />
        </div>
        <div class="mb-3">
            <label for="np">New Password</label>
            <input type="password" name="newPassword" id="np" />
        </div>
        <div class="mb-3">
            <label for="conp">Confirm Password</label>
            <input type="password" name="confirmPassword" id="conp" />
        </div>
        <input type="submit" value="Update Profile" name="save" />
    </form>
</div>

<script>
    function validate(form) {
        let pw = form.newPassword.value;
        let con = form.confirmPassword.value;
        let isValid = true;
        //TODO add other client side validation....

        //Check if valid Email address
        let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(form.email.value)) {
            isValid = false;
            flash("Invalid email address", "warning");
        }
        //Check if valid username
        re = /^[a-z0-9_-]{3,30}$/;
        if (!re.test(form.username.value) || form.username.value.length < 3) {
            isValid = false;
            flash("Invalid username", "warning");
        }
        //example of using flash via javascript
        //find the flash container, create a new element, appendChild
        if (pw !== con) {
            flash("New Password and Confirm Password don't match", "warning");
            isValid = false;
        }
        if (pw.length > 0 && pw.length < 8) {
            flash("New Password must be at least 8 characters", "warning");
            isValid = false;
        }
        return isValid;
    }
    //Checks if All fields are filled to change the color of the submit button
    const inputs = document.querySelectorAll("input");
    const ChgBtnColor = () => {
        let filled = true;
        inputs.forEach(input => {
            if (input.value === "") {
                filled = false;
            }
        });
        let username = document.getElementById("username");
        let email = document.getElementById("email");
        let password = document.getElementById("cp");
        //Checks if Username OR Email is Filled AND while leaving the password unchanged
        if ((username.value !== "" || email.value !== "") && password.value == "") {
            filled = true;
        }
        //Change Color of Submit Button
        if (filled) {
            document.querySelector("input[type='submit']").style.backgroundColor = "#1AA7EC";
        } else {
            document.querySelector("input[type='submit']").style.backgroundColor = "lightgrey";
        }
    };
    //Checks Inputs on Load for prefilled values
    window.onload = () => {
        ChgBtnColor();
    };
    //Checks Inputs 
    inputs.forEach(input => {
        input.addEventListener("keyup", ChgBtnColor);
    });
</script>
<?php
require_once(__DIR__ . "/../../partials/flash.php");
?>