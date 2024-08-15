<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="<?= base_url(); ?>assets/css/app.css" rel="stylesheet" type="text/css" />
</head>

<body class="bg-light">
    <div class="container">
        <!-- Status message -->
        <?php if (!empty($statusMsg)) { ?>
            <div class="alert alert-<?php echo $status; ?> alert-dismissible fade show" role="alert">
                <?php echo $statusMsg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        <div class="py-1 text-center">
            <h2><?=$title;?></h2>
        </div>
        <div class="row">
            <?php
            if ($session->has('google_access_token')) {
                ?>
                <div class="col-md-6 pb-4">
                    <form id="disconnectForm" action="<?= base_url() . 'disconnect'; ?>" method="post" class="pull-right">
                        <input type="hidden" name="disconnect" value="1">
                        <input type="submit" class="btn btn-danger" value="Disconnect">
                    </form>
                </div>
            <?php
            }
            ?>
        </div>