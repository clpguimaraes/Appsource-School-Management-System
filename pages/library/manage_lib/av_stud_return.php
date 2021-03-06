<!DOCTYPE html>
<html>


    <!-- Mirrored from webapplayers.com/inspinia_admin-v2.1/empty_page.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 31 May 2015 10:01:57 GMT -->
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $title . 'Return Book'; ?></title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <!-- Data Tables -->
        <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
        <link href="css/plugins/dataTables/dataTables.responsive.css" rel="stylesheet">
        <link href="css/plugins/dataTables/dataTables.tableTools.min.css" rel="stylesheet">

    </head>

    <body>

        <div id="wrapper">

            <nav class="navbar-default navbar-static-side" role="navigation">
                <?php include_once 'includes/nav_side_bar.php'; ?>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                        <?php include_once 'includes/nav_header.php'; ?>
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-sm-4">
                        <h2><strong>Return Books <font color="blue"> [Students] </font></strong></h2>
                    </div>
                </div>

                <div class="wrapper wrapper-content">
                    <!--Page content here..-->
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="ibox float-e-margins">
                                <div class="ibox-content">

                                    <form action="" method="POST" role="form">

                                        <div class="form-group">
                                            <label>Select Either Teacher or Student <sup style="color: red">*</sup></label>
                                            <select name="page" onchange="window.location = this.value" class="form-control" required>

                                                <option value="#"> ---- Selected Student -----  </option>
                                                <option value="index.php?page=av_teacher_return"> Teacher </option> 
                                            </select>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Students query and table starts here ...... -----> 
                        <div class="ibox float-e-margins">
                            <div class="ibox-conten table table-responsive">

                                <?php
                                //Script to delete class teacher from class teachers
                                if (isset($_GET['class_teacher_id']) && $_GET['class_teacher_id'] != "" && $_GET['class_id'] != "" && $_GET['stream_id'] != "" && $_GET['action'] == "delete_class_teacher") {
                                    $teacher = $_GET['class_teacher_id'];
                                    $class = $_GET['class_id'];
                                    $stream = $_GET['stream_id'];
                                    if (DB::getInstance()->checkRows("SELECT * FROM class_teacher where teacher_id=" . $teacher . " and class_id=" . $class . " and stream_id=" . $stream . "")) {
                                        $queryDeleteTeachert = DB::getInstance()->query("delete from class_teacher where teacher_id=" . $teacher . " and class_id=" . $class . " and stream_id=" . $stream . "");
                                        if ($queryDeleteTeachert) {
                                            redirect('Class Teacher removed successfully from the class teacher list', 'index.php?page=view_class_teachers');
                                        } else {
                                            redirect('An error occured while removing Class Teacher', 'index.php?page=view_class_teachers');
                                        }
                                    }
                                }
                                //Query to select all class teachers
                                $status = 1;
                                $queryDup = "select distinct student_info.student_id as student_id,fname,sname,sex,class_name,stream_name ,level,comb_name,book_no from student_info,houses,class,academic_yr,streams,combinations,book_student where(student_info.house_id=houses.house_id and student_info.student_id=book_student.student_id and student_info.class_id=class.class_id and student_info.stream_id=streams.stream_id and student_info.comb_id=combinations.comb_id and book_student.status = '".$status."' )";
                                if (DB::getInstance()->checkRows($queryDup)) {
                                    ?>
                                    <table class="table table-striped table-bordered table-hover " id="editable" >
                                        <caption>Student's Record</caption>
                                        <thead>
                                            <tr>
                                                <th>ID.</th>
                                                <th>Student Names</th>
                                               
                                                <th>Class</th>
                                                <th>Stream</th>
                                                <th>Level</th>
                                                <th>Combination</th>
                                                
                                                <th>Book No.</th>
                                                <th>Clear Book</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $users_list = DB::getInstance()->query($queryDup);
                                            $no = 1;
                                            foreach ($users_list->results() as $users_list) :
                                                ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td  style="text-transform: capitalize"><?php echo $users_list->fname.' '.$users_list->sname; ?></td>
                                                    
                                                    <td><?php echo $users_list->class_name; ?></td>
                                                    <td><?php echo $users_list->stream_name; ?></td>
                                                    <td><?php echo $users_list->level; ?></td>
                                                    <td><?php echo $users_list->comb_name; ?></td>
                                                    <td> <label class="label label-info"><?php echo $users_list->book_no; ?> </label></td>
                                                    
                                                    <td>
                                                        <a href="index.php?page=clear_student&action=borror_book&student_id=<?php echo $users_list->student_id . '&token=' . Token::generate(); ?>"  class="btn btn-warning btn-xs"><i class="fa fa-crosshairs"></i> Clear </a>
                                                    </td>
                                                </tr>  
                                                <?php
                                                $no++;
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>




                                    <?php
                                }else {
                                    echo '<b style="color:red">No Class Teachers Available</b>';
                                }
                                ?>





                            </div>
                        </div>
                    </div>
                </div>
                <!--Footer-->
                <?php include_once 'includes/nav_footer.php'; ?>

            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="js/jquery-2.1.1.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>
        <!-- Data Tables -->
        <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
        <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
        <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>


        <script>
                                                $(document).ready(function () {
                                                    /* Init DataTables */
                                                    var oTable = $('#editable').dataTable();
                                                });
        </script>
    </body>

    <!-- Mirrored from webapplayers.com/inspinia_admin-v2.1/empty_page.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 31 May 2015 10:01:57 GMT -->
</html>
