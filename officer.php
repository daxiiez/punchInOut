<?php
include '__connect.php';
include '__checkSession.php';
?>
<!Document>
<html>

<head>
    <?php include '__header.php'; ?>
    <script>
        let employeeList,departmentList,positionList;
        $(document).ready(() => {
            getDepartmentList();
            getPositionList();
            getOfficerList();
        });
        let getDepartmentList=()=>{
            $.get("SQL_Select/selectDepartment.php", null, (data) => {
                departmentList = JSON.parse(data);
            });
        }
        let getPositionList=()=>{
            $.get("SQL_Select/selectPosition.php", null, (data) => {
                positionList = JSON.parse(data);
            });
        }
        let getOfficerList=()=>{
            $.get("SQL_Select/selectEmployee.php", null, (data) => {
                employeeList = JSON.parse(data);
                if(employeeList){
                    setEmployeeList();
                }else{
                    alert("ไม่พบข้อมูล");
                }
            });
        }
        let setEmployeeList=()=>{
            let html = "<div class='row'>";
            employeeList.forEach(f=>{
                let positionName = positionList.filter(x=>f.position_code == x.position_code)[0].name;
                let departmentName = departmentList.filter(x=>f.department_code == x.department_code)[0].name;
            html+="                        <div class='col-3'>" +
                "                            <div class='card'>" +
                "                                <div class='card-header'><strong>รหัส : "+f.emp_id+"</strong></div>" +
                "                                <div class='card-body'>" +
                "                                    <table class='table'>" +
                "                                        <tr>" +
                "                                            <td colspan='2'>" +
                "                                               <img  class='card-img-top' width='100%'" +
                "                                                     border='5'" +
                "                                                     name='imageShow'" +
                "                                                     src='data:image/jpeg;base64,"+f.emp_pic+"'>" +
                "                                           </td>" +
                "                                        </tr>" +
                "                                        <tr>" +
                "                                            <th>ชื่อ</th>" +
                "                                            <td>"+f.emp_name+"</td>" +
                "                                        </tr>" +
                "                                        <tr>" +
                "                                            <th>เบอร์โทร</th>" +
                "                                            <td>"+f.emp_tel+"</td>" +
                "                                        </tr>" +
                "                                        <tr>" +
                "                                            <th>ตำแหน่ง</th>" +
                "                                            <td>"+positionName+"</td>" +
                "                                        </tr>" +
                "                                        <tr>" +
                "                                        </tr>" +
                "                                    </table>" +
                "                                </div>" +
                "                                <div class='card-footer'>" +
                "                                    <button onclick='viewEmployeeDetail("+f.emp_id+")' class='btn-block btn btn-outline-info'>" +
                "                                        ดู/แก้ไข ข้อมูลพนักงาน" +
                "                                    </button>" +
                "                                </div>" +
                "                            </div>" +
                "                        </div>";
            });
            html+=   "                    </div>";
            $("#employeeList").html(html);
        }

        function viewEmployeeDetail(emp_id){
            let em = employeeList.filter(f=>f.emp_id == emp_id)[0];
            console.log("em " ,em);
        }

    </script>
</head>
<body>
<?php
include '__navbar_admin.php';
?>

<div class="container-fluid" style="margin-top: 10px; margin-bottom: 150px;">
    <div class="card">
        <div class="card-header">
            <nav aria-label="breadcrumb  bg-dark">
                <h5><strong>จัดการพนักงาน</strong></h5>
            </nav>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 50px;" class="card">
                <div class="card-header">ค้นหา</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>ชื่อ</label>
                                <input class="form-control" id="emId" name="emId">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>ชื่อ</label>
                                <input class="form-control" id="emName" name="emName">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา</button>
                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#addEmployeeModal"><i
                                    class="fa fa-plus"></i> เพิ่ม
                        </button>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><strong>รายการพนักงาน</strong></div>
                <div class="card-body" id="employeeList">
                </div>
            </div>
        </div>
        <div class="footer bg-warning text-white">

        </div>
    </div>
</div>


<div class="modal fade " id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeLabel"><i class="fa fa-print"></i> รายละเอียดการจอง</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>

            <div class="modal-body">
                <form name="addEmployeeForm">
                    <div class="container">
                        <div class="row">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Label</label>
                                            <input name="emName" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Label</label>
                                            <input class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Label</label>
                                            <input class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Label</label>
                                            <input class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

</body>
</html>
