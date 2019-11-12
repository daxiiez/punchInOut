<style>
    .bg-rose {
        background-image: url("img/img2.jpg");
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <a class="navbar-brand" href="index.php">Time AD</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div id="navbarNavDropdown" class="navbar-collapse collapse">

        <ul class="navbar-nav mr-auto">
            <?php
            if (isset($_SESSION['emp_typeuser'])) {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="transaction.php">รายการเข้า-ออก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="officer.php">พนักงาน</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="department.php">แผนก</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="device.php">อุปกรณ์</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="report.php">รายงาน</a>
                </li>
                <?php
            }
            ?>

        </ul>
        <ul class="navbar-nav">
            <?php
            if (isset($_SESSION['emp_username'])) {
                ?>
                <li class="nav-item dropdown" style="cursor: pointer;">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <!--img-->
                        <?php
                        echo $_SESSION['emp_username'];
                        ?>
                    </a>
                    <!--
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                         <a class="dropdown-item" href="__register.php?viewProfile=1">
                             <i class="fa fa-user-circle-o"></i> Profile</a>
                     </div>
                     -->
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="__logout.php">ออกจากระบบ</a>
                </li>
                <?php
            } ?>

        </ul>
    </div>
</nav>
<script>
    function arrayToObject(arr) {
        let obj = {};
        arr.forEach(m => {
            obj[m.name] = m.value
        });
        return obj
    }

    function dateFormat(date) {
        return (date.getDate().toString()).padStart(2, 0) + "-" + (date.getMonth() + 1).toString().padStart(2, 0) + "-" + date.getFullYear();
    }
</script>

