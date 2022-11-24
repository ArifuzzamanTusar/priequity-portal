<?php
include '_file_lists.php';


?>
<table class="table">

    <tbody>
        <?php
        foreach ($required_files as $key => $files) {

            $document_name = $files[0];
            $application_id = $singledata['id'];
            $current_user = $getuser[0]['username'];
        ?>
            <tr>
                <td><?php echo $files[1] ?></td>
                <td>
                    <?php
                    if ($portal->checkDocumentExists($application_id, $document_name) > 0) {
                        echo '<span class="badge bg-success fs-6">Uploaded</span> ';
                    } else {
                        echo '<span class="badge bg-warning fs-6">Not Uploaded</span> ';
                    }
                    ?>
                </td>

                <?php
                if (isAdmin) {
                    if ($portal->checkDocumentExists($application_id, $document_name) > 0) {
                ?>
                        <td>
                            <a target="_BLANK" href="_uploads/<?php echo $portal->GetDocument($application_id, $document_name)[0]['file_name'] ?>" class="text-success"><i class=" bx bx-download  fs-5"></i></a>
                        </td>

                <?php
                    } else {
                        echo "<td>-</td>";
                    }
                }

                ?>


            </tr>
        <?php
        }
        ?>


    </tbody>
</table>