<?php
/**
 * @file
 *  Create a dynamic page.
 */
session_start();

 include "./config/config.php";
 include "./functions/common.php";

 // Препращаме не-логнатите потребители към началото, ако се опитват да достъпят страницата неоторизирано.
 if(!isLoggedIn()) {
     header("Location: index.php");
}

 ?>
<!DOCTYPE html>
<html>
	<?php
		include "./partials/header.php";
	?>
	<body class="page page-content-add">
		<h1 class="page-title">Add content</h1>
		<?php
			include "./partials/navigation.php";
		?>

        <form method="POST" action="#" name="add-content" enctype='multipart/form-data'>
            <label for="content-type">Тип:</label>
            <select id="content-type" name="content-type">
                <?php
                    printSelect($contentTypes);
                ?>
            </select>
            <label for="content-text">Текст:</label>
            <textarea id="content-text" name="content-text" cols="50" rows="10"></textarea>
            <label for="content-media">Картинка/видео:</label>
            <input id="content-media" name="content-media" type="file" />
            <label for="content-category">Категория:</label>
            <select id="content-category" name="content-category[]" multiple>
                <option value="<?php echo $defaultCategorie; ?>"><?php echo $defaultCategorie; ?></option>
                <?php
                    printSelect($categories);
                ?>
            </select>
            <!--
            <input type="checkbox" name="contet-category2[]" value="<?php echo $defaultCategorie; ?>" />
            <input type="checkbox" name="contet-category2[]" value="<?php echo "Nature"; ?>" />
            <input type="checkbox" name="contet-category2[]" value="<?php echo "Music"; ?>" />
            <input type="checkbox" name="contet-category2[]" value="<?php echo "Fiction"; ?>" />
            -->
            <input type="submit" value="Запиши" name="submit" />
        </form>
	</body>
</html>