<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>
            <?php
//                $result_set = User::find_all_users();
//
//                while($row = mysqli_fetch_array($result_set)) {
//                    echo $row['username'] . "<br>";
//                }

//                $found_user = User::find_user_by_id(2);
//                $user = User::instantiation($found_user);

//                echo $user->id;
//                echo $user->username;
//                echo $found_user['username'];

//                $users = User::find_all_users();
//                foreach ($users as $user) {
//                    echo $user->username . "<br>";
//                    echo $user->id . "<br>";
//                }
//
//            $found_user = User::find_user_by_id(2);
//            echo $found_user->username;

//            $picktures = new Pictures();

            $user = new User();
            $user->username = "Example_username";
            $user->password = "Example_password";
            $user->first_name = "John";
            $user->last_name = "Doe";

            $user->create();

//            $user = User::find_user_by_id(2);
//            $user->first_name = "Williams";
//            $user->last_name = "Konishi";
//
//            $user->update();

//            $user = User::find_user_by_id(8);
//            $ret =$user->delete();

//            $user = User::find_user_by_id(4);
//            $user->password = "justpassword";
//            $user->save();

//            $user = new User();
//            $user->username = "takuya";
//            $user->password = "takuya";
//            $user->save();



            ?>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->