<?php
include("functions.php");
include("connection.php");

if (isset($_POST['editusername'])) {
    // include_once("connection.php");
    // include_once("functions.php");
    if(updateUser($conn, $_POST['editusername'], $_POST['editname'], $_POST['editemail'])){
        echo "<script>
            alert('Update successfully!');
            window.location.href = 'index.php?page_type=home';
        </script>";
    } else {
        echo "<script>
            alert('Update fail !');
            window.location.href = 'index.php?page_type=home';
        </script>";
    }
}
if (isset($_POST['delete_button'])) {
    // include_once("connection.php");
    // include_once("functions.php");
    if(deleteUser($conn, $_POST['delete_button'])){
        echo "<script>
            alert('Delete successfully!');
            window.location.href = 'index.php?page_type=home';
        </script>";
    } else {
        echo "<script>
            alert('Delete fail !');
            window.location.href = 'index.php?page_type=home';
        </script>";
    }
}
if (isset($_POST['input'])) {
    $search_zone = $_POST['input'];

    if (empty($search_zone)) {
        // Fetch all rows if input is empty
        $query = "
            SELECT * 
            FROM user
            WHERE admin != 1
        ";
    } else {
        // Fetch rows based on search input
        $query = "
            SELECT * 
            FROM user
            WHERE (username LIKE '%$search_zone%'
            OR name LIKE '%$search_zone%'
            OR email LIKE '%$search_zone%')
            AND admin != 1
        ";
    }

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        ?>
        <!-- Display table structure -->
        <table class="table table-light table-striped table-hover table-bordered table-responsive">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $row_number = 1;
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row_number; ?></th>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td class="text-center d-flex flex-column justify-content-center align-items-center gap-1">
                            <!-- <button class="btn btn-primary">edit</button> -->
                            <button class="btn btn-primary"  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?php echo $row['username']; ?>">
                                Edit
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="<?php echo $row['username']; ?>" tabindex="-1" aria-labelledby="<?php echo $row['username']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                    <div class="modal-header text-dark">
                                        <h1 class="modal-title fs-5" id="<?php echo $row['username']; ?>">Edit user</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="searchDB.php" method="post">
                                        <div class="modal-body text-dark">
                                            <div class="mb-3">
                                                <label for="editusername" class="form-label"><strong>Username</strong></label>
                                                <input type="text" class="form-control" name="editusername" id="editusername" aria-describedby="usernameHelp" 
                                                    value="<?php echo $row['username']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editname" class="form-label"><strong>Name</strong></label>
                                                <input type="text" class="form-control" name="editname" id="editname" aria-describedby="nameHelp"
                                                    value="<?php echo $row['name']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editemail" class="form-label"><strong>Email address</strong></label>
                                                <input type="email" class="form-control" name="editemail" id="editemail" aria-describedby="emailHelp"
                                                    value="<?php echo $row['email']; ?>" required>
                                            </div>
                                            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                                        </div>
                                        <div class="modal-footer text-dark">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal end -->
                            <form action="searchDB.php" method="post">
                                <button class="btn btn-danger"
                                    name="delete_button" value="<?php echo $row['username']; ?>">
                                    delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php
                    $row_number++;
                }
                ?>
            </tbody>
        </table>
        <?php
    } else {
        echo "<h6 class='text-danger text-center mt-3'>No results found.</h6>";
    }
}
?>