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
    public function newAppNotification($data, $id)
    {
        if ($_SERVER['HTTP_HOST'] == "localhost") {
            $siteurl = "http://localhost/priequity-portal/";
        } else {
            $siteurl = "https://portal.priequity.com/";
        }
        $template = '
        <center>
            <div style="background:#F5EEDC; padding:80px 10px; ">
                <div style="width:600px; border-radius: 12px; background:red; overflow:hidden">
    
                    <div style="background:#A45716; padding:20px 0px; ">
                        <img width="200px" src="https://res.cloudinary.com/tusar/image/upload/v1662381540/SocialIcons/priequity-logo.png" alt="locally Logo">
                    </div>
                    <div style="background:#FFFFEBD6; padding:20px 20px;">
                        <h4>New Application From, ' . $data['username'] . '</h4>
                        
                        <br>
                        <br>
                        <table>
                            <tr><td>Full Name: </td>' . $data['first_name'] . $data['last_name'] . '</tr>
                            <tr><td>Phone: </td>' . $data['phone'] . '</tr>
                            <tr><td>Company Name: </td>' . $data['company_name'] . '</tr>
                            <tr><td>Position: </td>' . $data['position'] . '</tr>
                            <tr><td>Business Address: </td>' . $data['business_address'] . '</tr>
                            <tr><td>Address: </td>' . $data['city'] . ", " . $data['state'] . "-" . $data['zip_code'] . ", " . $data['country'] . '</tr>
                            <tr><td>Capital Uses: </td>' . $data['capital_uses'] . '</tr>
                            <tr><td>Capital Need: </td>' . $data['capital_need'] . '</tr>
                            <tr><td>Experience: </td>' . $data['experience'] . '</tr>
                            <tr><td>Letter: </td>' . $data['letter'] . '</tr>
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
