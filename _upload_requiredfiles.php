<?php


include '_file_lists.php';


?>


<div class="required-files">
    <?php

    foreach ($required_files as $key => $files) {

        $document_name = $files[0];
        $application_id = $singledata['id'];
        $current_user = $getuser[0]['username'];

        if (isset($_POST[$document_name])) {
            // ------------------------------

            if (isset($_FILES["attachment"]['tmp_name']) && $_FILES["attachment"]['tmp_name'] !== '') {

                // debug($_FILES["attachment"]);

                $filepath = $_FILES['attachment']['tmp_name'];
                $fileSize = filesize($filepath);
                $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
                $filetype = finfo_file($fileinfo, $filepath);

                if ($fileSize === 0) {
                    $fileSizeError = ' <div class="bg-danger text-white p-2">File Empty</div>';
                }

                if ($fileSize > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))

                    $fileSizeError = ' <div class="bg-danger text-white p-2">File Too Big please Upload max 3M or attach drive link bellow</div>';
                }



                $filename =  $getuser[0]['username'] . "-" . $document_name . "-"  . rand(1000, 10000); // I'm using the original name here, but you can also change the name of the file here
                $extension =  pathinfo(basename($_FILES["attachment"]["name"]), PATHINFO_EXTENSION);

                if ($extension !== 'php') {
                    # code...

                    // debug($extension);
                    $targetDirectory = __DIR__ . "/_uploads"; // __DIR__ is the directory of the current PHP file

                    $newFilepath = $targetDirectory . "/" . $filename . "." . $extension;

                    if (!copy($filepath, $newFilepath)) { // Copy the file, returns false if failed
                        die("Can't move file.");
                    }
                    unlink($filepath); // Delete the temp file

                    $attachment = $filename . "." . $extension;
                } else {
                    $fileSizeError = ' <div class="bg-danger text-white p-2">Invalid File Type</div>';
                    $attachment = '';
                }
            } else {
                $attachment = '';
            }
            // --------------

            // Uploading to Database 
            $data = array(
                'username' => $current_user,
                'app_id' => $application_id,
                'document_name' => $document_name,
                'attachment' => $attachment
            );
            $portal->saveApplicationFiles($data);
        }

    ?>
        <!-- File : Income Statements -->

        <div class="card">
            <div class="card-body">
                <?php
                if ($portal->checkDocumentExists($application_id, $document_name) > 0) {
                ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="file-content d-flex align-items-center">
                            <!-- <div class="icon bg-success  text-light"><i class="bx bx-check"></i></div> -->
                            <div class="file-content p-2">
                                <div class="text-start  m-0"><label> <?php echo $files[1] ?> Document : <span class="badge bg-success fs-6">Uploaded</span> </label> </div>
                            </div>

                        </div>

                        <div class="action">
                            <!-- <a href="">Edit</a>  | <a href="_uploads/<?php echo $portal->GetDocument($application_id, $document_name)[0]['file_name'] ?>">Download</a> -->
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="add-file">
                        <label for=""><?php echo $files[1]; ?></label>
                        <form action="" enctype="multipart/form-data" method="post">
                            <div class="row">
                                <div class="col-9">
                                    <input type="file" class="form-control" name="attachment" id="" aria-describedby="fileHelpId" accept=".pdf, .docx, .doc" required>
                                    <div id="fileHelpId" class="form-text"> <?php echo $files[2] ?> </div>
                                </div>
                                <div class="col-3">
                                    <button name="<?php echo $document_name ?>" type="submit" class="btn btn-primary col-12 waves-effect btn-label waves-light"><i class=" bx bx-upload label-icon"></i> Upload</button>
                                </div>
                            </div>
                        </form>
                        <?php echo $fileSizeError ?? "" ?>
                    </div>
                <?php
                }

                ?>

            </div>
        </div>
        <!-- --------------  -->
    <?php
    }
    ?>


</div>