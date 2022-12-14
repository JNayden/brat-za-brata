<?php
    $con = mysqli_connect("localhost", "root", "", "db_php_task");
    if (!$con) {
        header("Location: create.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./styles/style-table.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    <title>Warehouse app</title>
</head>


<body>

    <div class="navigate">
        <a class="create-btn" href="create.php"> Create new record</a>
    </div>

    <div class="table-container">
        <form class="form" action="" method="GET">
            <select name="sort_condition" class="form-control">
                <option value="">---Select Option ----</option>
                <option value="a-z"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php if (isset($_GET['sort_condition']) && $_GET['sort_condition'] == "a-z") {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo "selected";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }?>> A-Z(Ascending Order)</option>
                <option value="z-a"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php if (isset($_GET['sort_condition']) && $_GET['sort_condition'] == "z-a") {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                echo "selected";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            }?>> Z-A(Descending Order)</option>
                <option value="byDateASC"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php if (isset($_GET['sort_condition']) && $_GET['sort_condition'] == "byDateASC") {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      echo "selected";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  }?>> A-Z(Ascending Order by Date)</option>
                <option value="byDateDESC"                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php if (isset($_GET['sort_condition']) && $_GET['sort_condition'] == "byDateDESC") {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               echo "selected";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           }?>> Z-A(Descending Order by Date)</option>
            </select>
            <button type="submit" class="input-group-text btn btn-primary" id="basic-addon2">
                Sort
            </button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name of product</th>
                    <th scope="col">Price</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>


            <tbody>
                <?php
                    $con = mysqli_connect("localhost", "root", "", "db_php_task");
                    if (!$con) {
                        header("Location: create.php");
                    }

                    $query = "SELECT * FROM product";
                    $query_run = mysqli_query($con, $query);

                    //$sort_option = "";
                    // $sort_option_name = "name";
                    $array = array();

                    while ($row = mysqli_fetch_array($query_run)) {
                        $array[] = $row;
                    }
                    if (isset($_GET['sort_condition'])) {
                        if ($_GET['sort_condition'] == "a-z") {
                            //$sort_option_name = "name";
                            //$sort_option = "ASC";
                            usort($array, build_sorter_name_A('name'));
                        } elseif ($_GET['sort_condition'] == "z-a") {
                            //$sort_option_name = "name";
                            //$sort_option = "DESC";
                            usort($array, build_sorter_name_D('name'));
                        } elseif ($_GET['sort_condition'] == "byDateASC") {
                            //$sort_option_name = "date";
                            //$sort_option = "ASC";
                            usort($array, build_sorter_date_A('date'));
                        } elseif ($_GET['sort_condition'] == "byDateDESC") {
                            //$sort_option_name = "date";
                            //$sort_option = "DESC";
                            usort($array, build_sorter_date_D('date'));
                        } elseif ($_GET['sort_condition'] == "") {
                            //$sort_option_name = "date";
                            //$sort_option = "DESC";
                            usort($array, build_sorter_name_A('name'));
                        }
                    }

                    // $query = "SELECT * FROM product ORDER BY  $sort_option_name $sort_option";
                    //$query_run = mysqli_query($con, $query);

                    if (sizeof($array) > 0) { //mysqli_num_rows($query_run) > 0) {
                        foreach ($array as $row_in_DB) { //$query_run as $row_in_DB) {
                        ?>
                        <tr>
                            <td><?php echo $row_in_DB['name']; ?></td>
                            <td><?php echo $row_in_DB['price']; ?></td>
                            <td><?php echo $row_in_DB['weight']; ?></td>
                            <td><?php echo $row_in_DB['date']; ?></td>
                            <td>
                                <form method="post" action="delete.php">
                                    <input type="hidden" name="id" value="<?php echo $row_in_DB['id_product'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>

                    <?php
                        }
                        } else {
                        ?>
                    <tr>
                        <td>NO RESULT IN DB</td>
                    </tr>

                <?php

                    }

                    function build_sorter_date_A($key)
                    {
                        return function ($a, $b) use ($key) {
                            return strnatcmp($a[$key], $b[$key]);
                        };
                    }

                    function build_sorter_date_D($key)
                    {
                        return function ($a, $b) use ($key) {
                            return strnatcmp($b[$key], $a[$key]);
                        };
                    }

                    function build_sorter_name_A($key)
                    {
                        return function ($a, $b) use ($key) {
                            return strnatcmp($a[$key], $b[$key]);
                        };
                    }

                    function build_sorter_name_D($key)
                    {
                        return function ($a, $b) use ($key) {
                            return strnatcmp($b[$key], $a[$key]);
                        };
                    }

                ?>
            </tbody>
        </table>
    </div>
</body>

</html>