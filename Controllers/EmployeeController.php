<?php
include_once "Models/Employee.php";
include_once "Controllers/Controller.php";

class EmployeeController extends Controller{


function route(){


    $action = isset($_GET['action']) ? $_GET['action'] : "EmployeeView";
    $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

    if($action=="defaultView"){
        $action="EmployeeView";
    }

 echo "Action: " . $action . "<br>";
        echo "ID: " . $id . "<br>";


if($action=="EmployeeView"){
$employees = Employee::list();
$this->render("Employee","EmployeeView",$employees);

}else if($action== "view"){
    $employee= new Employee($id);
    $this->render("Employee","view",array($employee));


}else if($action== "update"){
    $employee= new Employee($id);
    $jobLists= Employee::listJobs();
    $reportsToLists= Employee::listReports(); 
    $this->render("Employee", "update",  ['arrJobTitles' => $jobLists, 'data' => array($employee),'arrReportsTo'=>$reportsToLists]);
    
}else if($action== "updateSave"){
    $employee= new Employee($id);
    $employee->save($_POST); 
    header("location: /mvcpractice/employee");

}else if($action=="viewManagerTree"){
$managerTree=$this->getManagers($id);
$this->render("Employee", "managerTree", ['managerTree' => $managerTree]);  // Pass data

}else if($action== 'delete'){
        $employee= new Employee($id);
        $employee->delete($id);
        header("location: /mvcpractice/employee");

    }else if($action=="add"){
        $employee= Employee::listJobs();
        $reportsToLists=Employee::listReports();
        $this->render("Employee", "add",['arrJobTitles'=>$employee, 'arrReportsTo'=>$reportsToLists]);
    }else if($action=="insert"){
        $employee=new Employee();
        $employee->insert($_POST);
        
        header("location: /mvcpractice/employee");

    }
}
public function getManagers($employeeNumber) {
    global $conn;
   

    // Query to get the manager of the current employee
    $sql = "SELECT e1.employeeNumber, e1.firstName, e1.lastName, e1.reportsTo, e2.firstName AS managerFirstName, e2.lastName AS managerLastName
            FROM employees e1
            LEFT JOIN employees e2 ON e1.reportsTo = e2.employeeNumber
            WHERE e1.employeeNumber = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employeeNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the employee's details
    if ($row = $result->fetch_object()) {
        // Create an array to hold the employee's details and manager's info
        $employee = [
            'employeeNumber' => $row->employeeNumber,
            'firstName' => $row->firstName,
            'lastName' => $row->lastName,
            'manager' => null
        ];

        // If the employee has a manager, recursively get the manager's info
        if ($row->reportsTo) {
            $employee['manager'] = $this->getManagers($row->reportsTo);  // Recursive call
        }

        return $employee;
    }

    return null;  // If no employee found, return null
}
}


?>