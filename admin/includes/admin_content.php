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

//                $found_user = User::find_by_id(2);
//                var_dump($found_user);
//                $user = User::instantiation($found_user);

//                echo $user->id;
//                echo $user->username;
//                echo $found_user['username'];

//                $photos = Photo::find_all();
//                foreach ($photos as $photo) {
//                    echo $photo->title . "<br>";
//                }
//
//            $found_user = User::find_user_by_id(2);
//            echo $found_user->username;

//            $picktures = new Pictures();

//            $photo = new Photo();
//            $photo->title = "Just some test title 2";
//            $photo->size = 30;

//            $photo->create();
//            $photo->update();
//            $user = User::find_user_by_id(2);
//            $user->first_name = "Williams";
//            $user->last_name = "Konishi";
//
//            $user->update();

//            $user = User::find_user_by_id(8);
//            $ret =$user->delete();

            $user = Photo::find_by_id(2);
            $user->description = "just password";
            $user->save();

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