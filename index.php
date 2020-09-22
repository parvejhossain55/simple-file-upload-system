<?php
include 'inc/header.php';
include 'class/Database.php';
$db = new Database();
?>
<section class="mainleft">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $permit = array('jpg', 'jpeg', 'gif', 'png');
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp =  $_FILES['file']['tmp_name'];

        $div = explode('.', $file_name);
        $extension = strtolower(end($div));
        $unique_name = substr(md5(time()), 0,10).'.'.$extension;
        $upload_image = "upload/".$unique_name;
        move_uploaded_file($file_tmp, $upload_image);

        if (empty($file_name)) {
            echo "Please Insert any Image";
        } else if($file_size > 1048576){
            echo "Image Size Should be 1MB";
        } else if(in_array($extension, $permit) === false){
            echo "You Can Upload Only : ".implode(', ',$permit);
        } else{
            $query = "INSERT INTO images(image) VALUES('$upload_image')";
            $res = $db->insert($query);
            if ($res) {
                echo "Image Successfully Inserted";
            } else{
                echo "Image Not Inserted";
            }
        }
    }
?>
<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM images WHERE id=$id";
        $delimg = $db->select($sql);
        if ($delimg) {
            while ($res = $delimg->fetch_assoc()) {
                $unlinkimg = $res['image'];
                unlink($unlinkimg);
            }
        }

        $sql = "DELETE FROM images WHERE id=$id";
        $deldata = $db->delete($sql);
        if ($deldata) {
            echo "Data Deleted Successfully";
        }
    }
?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Upload File : </td>
                <td><input type="file" name="file"></td>
            </tr>
            <td></td>
            <td>
                <input type="submit" name="submit" value="Submit"/>
            </td>
        </tr>
    </table>
</form>
</section>
<section class="mainright">
<table width="100%">
    <tr>
        <td width="30%">Sl</td>
        <td width="30%">Image</td>
        <td width="20%">Action</td>
    </tr>
    <?php
        $query = "SELECT * FROM images ORDER BY id";
        $res = $db->select($query);
        if ($res) {
            $i=0;
            while($row = $res->fetch_assoc()){
            $i++;
    ?>
    <tr>
        <td><?php echo $i; ?></td>
        <td><img src="<?php echo $row['image'] ?>" style="width: 100px;height: 120px"></td>
        <td><a href="?id=<?php echo $row['id'] ?>">Delete</a></td>
    </tr>    
    <?php } } ?>
</table>
</section>
<?php include 'inc/footer.php' ?>