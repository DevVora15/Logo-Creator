<?php include 'logo_create.php'; ?>
<?php include 'connection.php'; ?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logo Suggestions</title>
    <link rel="stylesheet" href="logo.css">   
</head>

<body>
    <div class="container">
        <div>
            <h1 class="heading">Logo Design Ideas</h1>
            <br>
        </div>

        <div class="details">
            <form action="" method="post">

                <label for="text">Enter your logo name</label>
                <input type="text" id="text" name="text" value="<?= $logotext ?>">
                <br><br>
                <label for="text">Enter your Font name</label>
                <input type="text" id="text" name="fontname" value="<?= $fontname ?>">
                <br><br>

                <select name="iconUrl">
                    <option value="">Select an icon...</option>
                    <?php if (!empty($icons)) : ?>
                        <?php foreach ($icons as $icon) : ?>
                            <option value="<?php echo $icon['thumbnails'][0]['url']; ?>"><?php echo $icon['name']; ?></option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value="" disabled>No icons found.</option>
                    <?php endif; ?>
                </select>

                <button type="submit" name="generate">Generate</button>

            </form>
        </div>

        <div class="suggestions">Suggestions</div>
        <p> * Refresh to get different colors</p>
    </div>
    <?= $logoSuggestions; ?>

</body>

</html>