<?php

// ---------------------------------
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

include 'layouts/config.php';





// -----------------------------------
// ---------------end PHP mailer  
class DbClass
{
    private $host  = DB_SERVER;
    private $user  = DB_USERNAME;
    private $password   = DB_PASSWORD;
    private $database  = DB_NAME;
    // Tables 
    private $usersTable = 'users';
    private $userMetaTable = 'user_meta';
    private $countryTable = 'country';
    private $applicationTable = 'application';
    private $documentsTable = 'documents';
    private $portalTable = 'portal_option';

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

    // COUNT ALL 
    public function countApplications( $status = "none")
    {
        if ($status === "none") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . " ");
        }
        if ($status === "pending") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `status` LIKE 'pending'");
        }
        if ($status === "approved") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `status` LIKE 'approved'");
        }
        if ($status === "processing") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `status` LIKE 'processing'");
        }
        if ($status === "rejected") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `status` LIKE 'rejected'");
        }

    }
    // COUNT Users Applicaitions
    public function countUserApplications($email, $status = "all")
    {
        if ($status === "all") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `useremail` LIKE '".$email."' ");
        }
        if ($status === "pending") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `useremail` LIKE  '".$email."' AND `status` LIKE 'pending'");
        }
        if ($status === "approved") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `useremail` LIKE  '".$email."' AND `status` LIKE 'approved'");
        }
        if ($status === "processing") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `useremail` LIKE  '".$email."' AND `status` LIKE 'processing'");
        }
        if ($status === "rejected") {
            return $this->getNumRows("SELECT * FROM " . $this->applicationTable . "  WHERE `useremail` LIKE  '".$email."' AND `status` LIKE 'rejected'");
        }
    }

    public function countApplicant ($role){
        return $this -> getNumRows("SELECT * FROM " . $this->usersTable . "    WHERE `role` = ".$role."");
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



    // ||||||||||||  MAILING ||||||||||||||||||

    public function sendMail($recipient, $subject, $body)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        $portalOption = $this->getData("SELECT * FROM " . $this->portalTable . " WHERE `site_key` LIKE '2d58745e5af8524a5c0f9366ab25d493f98b160f'")[0];



        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $portalOption['smtp_host'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $portalOption['smtp_user'];                     //SMTP username
            $mail->Password   = $portalOption['smtp_password'];                              //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $portalOption['smtp_port'];                                     //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($portalOption['smtp_user'], 'Priequity Portal');
            // $mail->addAddress('arifuzzamantusar50@gmail.com', 'Joe User');     //Add a recipient
            $mail->addAddress($recipient);               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = 'Your Browser doesnt support the email';

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }












    // ------------------------------------------



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



    // =======|||| EXTRAS ||||=======
    // -------Country Data
    public function countryData()
    {
        $sqlQuery = "SELECT * FROM " . $this->countryTable . " ";
        return  $this->getData($sqlQuery);
    }
}
