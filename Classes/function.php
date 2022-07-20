<?php
class DbClass
{
    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "priequity_portal";
    private $usersTable = 'users';
    private $userMetaTable = 'user_meta';
    private $countryTable = 'country';
    private $applicationTable = 'application';
    private $documentsTable = 'documents';
    private $portalTable = 'portal_option';


    private $invoiceOrderTable = 'invoice_order';
    private $invoiceOrderItemTable = 'invoice_order_item';
    private $customerTable = 'customer';
    private $dbConnect = false;


    // DB Connect 
    public function __construct()
    {
        if (!$this->dbConnect) {
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if ($conn->connect_error) {
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            } else {
                $this->dbConnect = $conn;
            }
        }
    }


    private function getData($sqlQuery)
    {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if (!$result) {
            die('Error in query: ' . mysqli_error($this->dbConnect));
        }
        $data = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }


    private function getNumRows($sqlQuery)
    {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if (!$result) {
            die('Error in query: ' . mysqli_error($this->dbConnect));
        }
        $numRows = mysqli_num_rows($result);
        return $numRows;
    }



    // Login userdata
    public function loginUsers($email, $password)
    {
        $sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile 
			FROM " . $this->invoiceUserTable . " 
			WHERE email='" . $email . "' AND password='" . $password . "'";
        return  $this->getData($sqlQuery);
    }

    // Login Check 
    public function checkLoggedIn()
    {
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("location: auth-login.php");
            exit;
        }
    }




    // --------------  SAVE INVOICE ---------------


    public function saveInvoice($POST, $currentNumber)
    {
        $sqlInsert = "
			INSERT INTO " . $this->invoiceOrderTable . "(user_id, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax,order_due_date, order_date, inv_ref, order_total_after_tax) 
			VALUES ('" . $POST['userId'] . "', '" . $POST['companyName'] . "', '" . $POST['address'] . "', '" . $POST['netAmount'] . "', '" . $POST['taxAmount'] . "','" . $POST['due_date'] . "','" . $POST['order_date'] . "','" . $POST['ref'] . "', '" . $POST['subTotal'] . "')";
        mysqli_query($this->dbConnect, $sqlInsert);


        $lastInsertId = mysqli_insert_id($this->dbConnect);
        for ($i = 0; $i < count($POST['productName']); $i++) {
            $sqlInsertItem = "
			INSERT INTO " . $this->invoiceOrderItemTable . "(order_id, item_disc, item_name, order_item_quantity,uom, order_item_price,tax_percent,tax_amount, order_item_final_amount,date) 
			VALUES ('" . $currentNumber . "', '" . $POST['productDisc'][$i] . "', '" . $POST['productName'][$i] . "', '" . $POST['quantity'][$i] . "', '" . $POST['uom'][$i] . "', '" . $POST['price'][$i] . "','" . $POST['tax'][$i] . "', '" . $POST['taxtot'][$i] . "',  '" . $POST['total'][$i] . "',  '" . $POST['date'][$i] . "')";
            mysqli_query($this->dbConnect, $sqlInsertItem);
        }

        // echo $currentNumber;
    }


    /*
	public function updateInvoice($POST) {
		if($POST['invoiceId']) {	
			$sqlInsert = "
				UPDATE ".$this->invoiceOrderTable." 
				SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."' 
				WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['invoiceId']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
		}		
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_disc, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
				VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);			
		}       	
	}	

	*/
    public function getInvoiceList()
    {
        $sqlQuery = "
			SELECT * FROM " . $this->invoiceOrderTable . " 
			WHERE user_id = '" . $_SESSION['userid'] . "'";
        return  $this->getData($sqlQuery);
    }
    public function getInvoice($invoiceId)
    {
        $sqlQuery = "
			SELECT * FROM " . $this->invoiceOrderTable . " 
			WHERE user_id = '" . $_SESSION['userid'] . "' AND order_id = '$invoiceId'";
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $row;
    }
    public function getInvoiceItems($invoiceId)
    {
        $sqlQuery = "
			SELECT * FROM " . $this->invoiceOrderItemTable . " 
			WHERE order_id = '$invoiceId'";
        return  $this->getData($sqlQuery);
    }


    // ---------------- DELETING PROCESS -------------
    public function deleteInvoiceItems($invoiceId)
    {
        $sqlQuery = "
			DELETE FROM " . $this->invoiceOrderItemTable . " 
			WHERE order_id = '" . $invoiceId . "'";
        mysqli_query($this->dbConnect, $sqlQuery);
    }
    public function deleteInvoice($invoiceId)
    {
        $sqlQuery = "
			DELETE FROM " . $this->invoiceOrderTable . " 
			WHERE order_id = '" . $invoiceId . "'";
        mysqli_query($this->dbConnect, $sqlQuery);
        $this->deleteInvoiceItems($invoiceId);
        return 1;
    }



    // ---------------------------------------AFTER THE HELL -------------------------------------

    public function allCustomerList()
    {
        $sqlQuery = "SELECT * FROM " . $this->customerTable . "";
        return  $this->getData($sqlQuery);
    }
    public function currentInvoiceNumber()
    {
        $sqlQuery = "SELECT * FROM " . $this->invoiceOrderTable . " ORDER BY order_id DESC LIMIT 1";
        return  $this->getData($sqlQuery);
    }



    // =======|||| EXTRAS ||||=======
    // -------Country Data
    public function countryData()
    {
        $sqlQuery = "SELECT * FROM " . $this->countryTable . " ";
        return  $this->getData($sqlQuery);
    }



    // =======|||| USER OPERATION ||||=======


    // updateUserMeta 
    public function updateUserMeta($useremail, $data)
    {
        $sqlInsert = "
        UPDATE " . $this->userMetaTable . " 
        SET 
            phone = '" . $data['phone'] . "',
            first_name= '" . $data['first_name'] . "',
            last_name = '" . $data['last_name'] . "',
            gender = '" . $data['gender'] . "',
            birthday = '" . $data['birthday'] . "',
            country = '" . $data['country'] . "',
            state = '" . $data['state'] . "',
            city = '" . $data['city'] . "',
            zip_code = '" . $data['zip_code'] . "' 
        WHERE useremail = '" . $useremail . "'";

        // mysqli_query($this->dbConnect, $sqlInsert);
        if (mysqli_query($this->dbConnect, $sqlInsert)) {
            header("location: edit-profile.php?message=Profile Has been Updated successfully");
        }
    }


    // -------Single User Core Data
    public function userData($user_id)
    {
        $sqlQuery = "SELECT * FROM " . $this->usersTable . " WHERE `id` = $user_id";
        return  $this->getData($sqlQuery);
    }

    // -------Single User META Data
    public function userAllData($useremail)
    {
        $sqlQuery = "SELECT * FROM " . $this->userMetaTable . " WHERE `useremail` = '$useremail'";
        return  $this->getData($sqlQuery);
    }
    // Get All User Data 

    public function allUsers()
    {
        $sqlQuery = "SELECT * FROM " . $this->usersTable . " ";
        return  $this->getData($sqlQuery);
    }
    // Delete a single user and his meta data 
    public function deleteUsers($user)
    {
        $this->requireAdmin();
        $sqlQuery = "DELETE FROM " . $this->usersTable . " WHERE useremail = '" . $user . "'";
        if (mysqli_query($this->dbConnect, $sqlQuery)) {
            $sqlQuery2 = "DELETE FROM " . $this->userMetaTable . " WHERE useremail = '" . $user . "'";
            if (mysqli_query($this->dbConnect, $sqlQuery2)) {
                return true;
            }
        }
    }



    // ------------------------ ROLES ----------------------
    public function requireAdmin()
    {
        $this->checkLoggedIn();

        $getuser = $this->userData($_SESSION["id"]);
        $getUsersRole = intval($getuser[0]['role']);
        if ($getUsersRole !== 10000) {
            // echo "you are not an admin";

            header("location: unauthorised.php");
            exit;
        }
    }

    // =======|||| APPLICATION SYSTEM ||||=======

    public function saveApplication($useremail, $data)
    {

        $sqlInsert = "
			INSERT INTO " . $this->applicationTable . "(
                useremail,
                username,
                first_name, 
                last_name, 
                phone, 
                company_name,
                position,
                business_address,
                state, 
                city, 
                zip_code,
                country, 
                capital_uses,
                capital_need,
                experience,
                attachment,
                letter

                ) 
			VALUES (
                '" . $useremail . "',
                '" . $data['username'] . "',
                '" . $data['first_name'] . "',
                '" . $data['last_name'] . "',
                '" . $data['phone'] . "',
                '" . $data['company_name'] . "',
                '" . $data['position'] . "',
                '" . $data['business_address'] . "',
                '" . $data['state'] . "',
                '" . $data['city'] . "',
                '" . $data['zip_code'] . "',
                '" . $data['country'] . "',
                '" . $data['capital_uses'] . "',
                '" . $data['capital_need'] . "',
                '" . $data['experience'] . "',
                '" . $data['attachment'] . "',
                '" . $data['letter'] . "'

                )";

        if (mysqli_query($this->dbConnect, $sqlInsert)) {
            return true;
        }

        // echo $currentNumber;
    }



    public function applicationList()
    {
        $this->requireAdmin();
        $sqlQuery = "SELECT * FROM " . $this->applicationTable . " ORDER BY id DESC";
        return  $this->getData($sqlQuery);
    }
    public function usersApplicationList($email)
    {

        $sqlQuery = "SELECT * FROM " . $this->applicationTable . " WHERE useremail = '" . $email . "'ORDER BY id DESC";
        return  $this->getData($sqlQuery);
    }


    public function getSingleAppData($appID)
    {
        $sqlQuery = "SELECT * FROM " . $this->applicationTable . " WHERE id = '" . $appID . "'";
        return  $this->getData($sqlQuery);
    }


    public function updateApplicationStatus($appID, $status)
    {
        $sqlQuery = "
        UPDATE " . $this->applicationTable . " 
        SET 
            status = '" . $status . "'
        WHERE id = '" . $appID . "'";

        // mysqli_query($this->dbConnect, $sqlInsert);
        if (mysqli_query($this->dbConnect, $sqlQuery)) {
            return true;
        }
    }

    // Application Files ====================

    //Request
    public function requestFiles($app_id, $data)
    {

        $sqlInsert = "
			INSERT INTO " . $this->documentsTable . "(
                app_id,
                ask_for,
                asked_by
                ) 
			VALUES (
                '" . $app_id . "',
                '" . $data['ask_for'] . "',
                '" . $data['asked_by'] . "'
                )";

        if (mysqli_query($this->dbConnect, $sqlInsert)) {
            return true;
        }

        // echo $currentNumber;
    }
    // Submit Files and update requests

    public function updateRequestedFile($req_id, $data)
    {
        $sqlQuery = "
        UPDATE " . $this->documentsTable . " 
        SET 
            submissions = '" . $data['submissions'] . "',
            files = '" . $data['files'] . "'
        WHERE id = '" . $req_id . "'";

        // mysqli_query($this->dbConnect, $sqlInsert);
        if (mysqli_query($this->dbConnect, $sqlQuery)) {
            return true;
        } else {
            echo "hoyni";
            echo $req_id;
            echo $data['submissions'];
            echo $data['files'];
            echo "<br>";
            echo $sqlQuery;
        }
    }


    // Show 
    public function requestFileList($app_id)
    {

        $sqlQuery = "SELECT * FROM " . $this->documentsTable . " WHERE `app_id` =" . $app_id . " ORDER BY id DESC ";

        return  $this->getData($sqlQuery);
    }

    // ++++++}}}}}}}}|||||| UTILITIES ||||||||||{{{{{{{{{{{+++++++++

    // SMTP


    public function updateSMTP($site, $data)
    {
        $sqlQuery = "
        UPDATE " . $this->portalTable . " 
        SET 
            smtp_host = '" . $data['smtp_host'] . "',
            smtp_user = '" . $data['smtp_user'] . "',
            smtp_password = '" . $data['smtp_password'] . "',
            smtp_port = '" . $data['smtp_port'] . "'
        WHERE site_key  LIKE '" . $site . "'";

        // mysqli_query($this->dbConnect, $sqlInsert);
        if (mysqli_query($this->dbConnect, $sqlQuery)) {
            return true;
        } 
    }
    public function getOptions($site)
    {
        
        $sqlQuery = "SELECT * FROM " . $this->portalTable . " WHERE `site_key` LIKE '" . $site . "'";
 

        return  $this->getData($sqlQuery);
    }



    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    // -------- Conditional Rendering ------
    public function appStatus($status)
    {
        if ($status == 'approved') {
            echo '<span class="fw-bold px-3 py-2 rounded-pill bg-soft-success text-success"> ' . $status . '</span> ';
        }
        if ($status == 'processing') {
            echo '<span class="fw-bold px-3 py-2 rounded-pill bg-soft-success text-success"> ' . $status . '</span> ';
        }
        if ($status == 'pending') {
            echo '<span class="fw-bold px-3 py-2 rounded-pill bg-soft-warning text-warning"> ' . $status . '</span> ';
        }
        if ($status == 'rejected') {
            echo '<span class="fw-bold px-3 py-2 rounded-pill bg-soft-danger text-danger"> ' . $status . '</span> ';
        }
    }

    public  function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        // $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        // $text = preg_replace('~[^-\w]+~', '', $text);

        //Remove Whitespaces
        $text = preg_replace('~[^-\S]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
