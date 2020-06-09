<html>
    <head>
        <title>IMAGE UPLOAD</title>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>
        <form enctype='multipart/form-data' method='post' id='menu'>
            <input type='file' name='file'>
            <input type='submit' value='SEND' name='submit'>
            <input type='submit' value='delete' name='delete'>
        </form>
        <div id='body'>




        <?php
        error_reporting(E_ERROR | E_PARSE);
        $images = array();
        $files = glob("upload/*.*");
        for ($i=0; $i<count($files); $i++)
        {
        array_push($images,$files[$i]);
        $image = $files[$i];
        echo "<form method=get>";
        echo '<a href="'.$image.'"id="id"'.$i.'">';
        echo '<img src="'.$image .'" alt="Gallery #2" style="width:200px;"/>';
        if($_GET['select']==$i){
            echo "<input type='submit' value='$i' name='select' class='button selected'>";
        }else
        {
            echo "<input type='submit' value='$i' name='select' class='button'>";
        }

        echo "</a>";
        echo "</form>";
        }
        if(isset($_POST['delete']))
        {
            $im = $_GET["select"];
            $file = fopen($images[$im],'w');
            echo fwrite($file,"hello world,testing");
            fclose($file);
            unlink($images[$im]);
            header('Location: index.php?filedeleted');
        }
        if(isset($_POST["submit"])){
            $file = $_FILES['file'];
        
            $fileName = $_FILES['file']['name'];
            $fileTmpName = $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType= $_FILES['file']['type'];
            
            $fileExt = explode('.',$fileName);
            $fileActualExt = strtolower(end($fileExt));
        
            $allowed = array('jpg','jpeg','png','pdf');
            
            if(in_array($fileActualExt,$allowed)){
                if($fileError === 0){
                    if($fileSize < 500000){
                        $fileNameNew = uniqid('-', true).'.'.$fileActualExt;
                        $fileDestination = 'upload/'.$fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        header('Location: loc.php');
                    }else{
                        echo "File size is too big";
                    }
                }else{
                    echo "There was an error uploading your file!";
                }
            }else{
                echo "You cant upload files of this type!";
            }
        }
        ?>
        </div>


    </body>
</html>