<?php
//note we need to go up 1 more directory
require(__DIR__ . "/../../../partials/nav.php");
$TABLE_NAME = "RM_Items";
if (!has_role("Admin")) {
    flash("You don't have permission to view this page", "warning");
    die(header("Location: $BASE_PATH/home.php"));
}
// update the item
// if (isset($_POST["upload"])) {
//     $image = new Bulletproof\Image($_FILES);
//     $image->setLocation("../Images/");
//     $image->setName($_POST["name"]);
//     if ($image["image"]) {
//         $upload = $image->upload();
//         if ($upload) {
//             // echo $upload->getFullPath(); // uploads/cat.gif
//             // flash("Uploaded image", "success");
//             $newPath = $image->getFullPath();
//             $newPath = str_replace("../", "", $newPath);
//             $_POST["image"] = $newPath;
//             if (update_data($TABLE_NAME, $_GET["id"], $_POST)) {
//                 flash("Updated item", "success");
//             }
//         } else {
//             // flash error
//             $e = $image->getError();
//             flash("$e", "danger");
//             // flash("Error uploading image", "danger");
//         }
//     }
//     //set the image value to the full path of the image
// }

//get the table definition
$result = [];
$columns = get_columns($TABLE_NAME);
//echo "<pre>" . var_export($columns, true) . "</pre>";
$ignore = ["id", "modified", "created"];
$db = getDB();
//get the item
$id = se($_GET, "id", -1, false);
$stmt = $db->prepare("SELECT * FROM $TABLE_NAME where id =:id");
try {
    $stmt->execute([":id" => $id]);
    $r = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($r) {
        $result = $r;
    }
} catch (PDOException $e) {
    error_log(var_export($e, true));
    flash("Error looking up record", "danger");
}
//uses the fetched columns to map via input_map()
function map_column($col)
{
    global $columns;
    foreach ($columns as $c) {
        if ($c["Field"] === $col) {
            return input_map($c["Type"]);
        }
    }
    return "text";
}
?>
<div class="container-fluid">
    <h1>Edit Item</h1>
    <form id="fileUploadForm" method="POST" enctype="multipart/form-data">
        <?php foreach ($result as $column => $value) : ?>
            <?php /* Lazily ignoring fields via hardcoded array*/ ?>
            <div class="mb-4">
                <input type="hidden" name="id" value="<?php echo $id ?>">
            </div>
            <?php if (!in_array($column, $ignore)) : ?>
                <?php if ($column == "image") : ?>
                    <div class="mb-4">
                        <label for="<?php echo $column; ?>">Image</label>
                        <input id='<?php echo $column; ?>' type="file" name="image" accept="image/*" />
                    </div>
                <?php else : ?>
                    <div class="mb-4">
                        <label class="form-label" for="<?php se($column); ?>"><?php se($column); ?></label>
                        <input class="form-control" id="<?php se($column); ?>" type="<?php echo map_column($column); ?>" value="<?php se($value); ?>" name="<?php se($column); ?>" />
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <input id="Active_Button" type="submit" value="Update" name="upload" />
    </form>
</div>
<div class="" id="output"></div>
<script>
    $("#fileUploadForm").submit(function(e) {
        e.preventDefault();
        var action = "../api/requests.php?action=upload";
        var data = new FormData(e.target);
        console.log(data);
        $.ajax({
            type: "POST",
            url: action,
            data: data,
            contentType: false,
            processData: false,
        }).done(function(response) {
            flash("Upadted", "success");
        }).fail(function(response) {
            flash("Error uploading image" + response, "danger");
        });
    });
</script>
<?php
//note we need to go up 1 more directory
require_once(__DIR__ . "/../../../partials/flash.php");
?>