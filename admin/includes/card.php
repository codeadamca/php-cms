<?php

function content_card(
    $id,
    $type,
    $title,
    $subtitle,
    $thumbnail,
    $content,
    $lnk_edit,
    $lnk_delete)
{

    ?>
        <div class="card">
        <div class="card-thumbnail">
            <img  class="card-image" src="<?=$thumbnail?>">
        </div>
        <div class="card-header">
            <h3 class="card-title">
            <?=$id.". ".$title?>
            </h3>
            <?php
                if(isset($subtitle))
                {
                    ?>
                    <p class="card-subtitle">
                    <?=$subtitle?>
                    </p>
                    <?php
                }
            ?>
            

        </div>
        <div class="card-body">
            <p class="card-content">
            <?php
                $text = substr($content,0, 200);
                echo $text;
            ?>
            </p>
        </div>
        <div class="card-footer">
            <div class="card-btn-group">
            <div class="card-btn">
                <a href="<?=$lnk_edit?>" class="txt-primary">
                    Edit
                </a>
            </div>
            <div class="card-btn">
                <a href="<?=$lnk_delete?>" class="txt-danger">
                    Delete
                </a>
            </div>
            </div>
        </div>
        </div>
    <?php

}