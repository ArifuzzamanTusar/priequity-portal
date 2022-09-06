<?php

class mailTemplate
{

    public function welcomeEmail($username)
    {

        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $siteurl = "http://localhost/priequity-portal";
        } else {
            $siteurl = "https://portal.priequity.com";
        }

        $template = '
        <center>
            <div style="background:#F5EEDC; padding:80px 10px; ">
                <div style="width:600px; border-radius: 12px; background:red; overflow:hidden">
    
                    <div style="background:#A45716; padding:20px 0px; ">
                        <img width="200px" src="https://res.cloudinary.com/tusar/image/upload/v1662381540/SocialIcons/priequity-logo.png" alt="locally Logo">
                    </div>
                    <div style="background:#FFFFEBD6; padding:20px 20px;">
                        <h4>Hi, ' . $username . '</h4>
                        <h2>Welcome to Priequity LLC</h2>
                        <p>Please login to your portal account and start applying today </p>
                       
                        <br><br>
                        <a style="padding: 20px; background:#A45716; color:#ffffff; text-decoration:none" href="' . $siteurl . "/auth-login.php" . '">Login Now</a>
                        <br><br>
                    </div>
                    <div style="background:#A45716;  padding:10px 0px;">
                        <p style="color:white;"> &copy; all right reseved Prequity</p>
                        <a href="mailto:info@priequity.com"><img width="30px" src="https://res.cloudinary.com/tusar/image/upload/v1662361864/SocialIcons/icons8_circled_envelope_480px_g89k78.png" alt=""></a>
                        <a href="http://priequity.com/"><img width="30px" src="https://res.cloudinary.com/tusar/image/upload/v1662361839/SocialIcons/icons8_globe_512px_mfraro.png" alt=""></a>
                        <a href="https://www.linkedin.com/company/priequity-llc"><img width="30px" src="https://res.cloudinary.com/tusar/image/upload/v1662361811/SocialIcons/icons8_linkedin_circled_480px_lhhfvf.png" alt=""></a>
                    </div>
                </div>
            </div>
        </center>
        
        ';
        return $template;
    }
    public function newAppNotification($data, $email)
    {
        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $siteurl = "http://localhost/priequity-portal";
        } else {
            $siteurl = "https://portal.priequity.com";
        }
        $template = '
        <center>
        <style>td{border:1px solid #000000;}</style>
            <div style="background:#F5EEDC; padding:80px 10px; ">
                <div style="width:600px; border-radius: 12px; background:red; overflow:hidden">
    
                    <div style="background:#A45716; padding:20px 0px; ">
                        <img width="200px" src="https://res.cloudinary.com/tusar/image/upload/v1662381540/SocialIcons/priequity-logo.png" alt="locally Logo">
                    </div>
                    <div style="background:#FFFFEBD6; padding:20px 20px;">
                        <h4>New Application From, ' . $data['username'] . '</h4>
                        
                        <br>
                        <br>
                        <table >
                            <tr><td>Full Name: </td> <td>' . $data['first_name'] . $data['last_name'] . '</td></tr>
                            <tr><td>Full Email: </td><td> <a href="mailto:'.$email.'">' . $email. '</a> </td></tr>
                            <tr><td>Phone: </td><td>' . $data['phone'] . '</td></tr>
                            <tr><td>Company Name: </td><td>' . $data['company_name'] . '</td></tr>
                            <tr><td>Position: </td><td>' . $data['position'] . '</td></tr>
                            <tr><td>Business Address: </td><td>' . $data['business_address'] . '</td></tr>
                            <tr><td>Address: </td><td>' . $data['city'] . ", " . $data['state'] . "-" . $data['zip_code'] . ", " . $data['country'] . '</td></tr>
                            <tr><td>Capital Uses: </td><td>' . $data['capital_uses'] . '</td></tr>
                            <tr><td>Capital Need: </td><td>' . $data['capital_need'] . '</td></tr>
                            <tr><td>Experience: </td><td>' . $data['experience'] . '</td></tr>
                            <tr><td>Letter: </td><td>' . $data['letter'] . '</td></tr>
                        </table>
                        <br>
                        
                        <br><br>
                        <a style="padding: 20px; background:#A45716; color:#ffffff; text-decoration:none" href="' . $siteurl . "/manage-application.php" . '">Manage Application</a>
                        <br><br>
                    </div>
                    <div style="background:#A45716;  padding:10px 0px;">
                        <p style="color:white;"> &copy; all right reseved Prequity</p>
                        <a href="mailto:info@priequity.com"><img width="30px" src="https://res.cloudinary.com/tusar/image/upload/v1662361864/SocialIcons/icons8_circled_envelope_480px_g89k78.png" alt=""></a>
                        <a href="http://priequity.com/"><img width="30px" src="https://res.cloudinary.com/tusar/image/upload/v1662361839/SocialIcons/icons8_globe_512px_mfraro.png" alt=""></a>
                        <a href="https://www.linkedin.com/company/priequity-llc"><img width="30px" src="https://res.cloudinary.com/tusar/image/upload/v1662361811/SocialIcons/icons8_linkedin_circled_480px_lhhfvf.png" alt=""></a>
                    </div>
                </div>
            </div>
        </center>
        
        ';
        return $template;
    }
}



?>



<?php


$email = new mailTemplate();
$email->welcomeEmail("goni"); ?>
