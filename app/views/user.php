<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if($admin): ?>
        <title> My Profile - WessBlog</title>
    <?php else: ?>
        <title><?php echo $user['username']; ?> - WessBlog</title>
    <?php endif; ?>
    <?php include("components/favicon.php") ?>
<!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./public/style/main.css">
</head>
<body>
    <div class="container mx-auto px-6 py-4">
        <!-- Header -->
        <?php include __DIR__ . "/components/header.php" ?>
        <!-- Page content -->
        <div class="profile">
            <?php if ($user): ?>
                <div class="posts">
                    <h2 class="title">
                        <?php if($admin): ?>
                            My Profile
                        <?php else: ?>
                            <?php echo $user['username']; ?>'s Profile
                        <?php endif; ?>
                        <svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#5171ff"></stop>
                                    <stop offset="100%" stop-color="#5171ff"></stop>
                                </linearGradient>
                                </defs>
                            <path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
                        </svg>
                    </h2>
                    <?php $v = $posts->fetch_array(); if (isset($posts) && is_array($v) && count($v)>0): ?>
                        <?php foreach ($posts as $post): ?>
                            <article class="post">
                                <a href="?action=post&id=<?php echo $post['post_id'] ?>" class="img">
                                    <img src="<?php echo $post['img']; ?>">
                                </a>
                                <div class="post-content">
                                    <a href="?action=post&id=<?php echo $post['post_id'] ?>"><?php echo $post['title']; ?></a>
                                    <p><?php echo $post["content"] ?></p>
                                    <div class="post-meta">
                                        <span><?php $date=new DateTime($post["published_at"]); echo $date->format('F j, Y') ?></span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16"><path fill="#6B6B6B" fill-rule="evenodd" d="m3.672 10.167 2.138 2.14h-.002c1.726 1.722 4.337 2.436 5.96.81 1.472-1.45 1.806-3.68.76-5.388l-1.815-3.484c-.353-.524-.849-1.22-1.337-.958-.49.261 0 1.56 0 1.56l.78 1.932L6.43 2.866c-.837-.958-1.467-1.108-1.928-.647-.33.33-.266.856.477 1.598.501.503 1.888 1.957 1.888 1.957.17.174.083.485-.093.655a.56.56 0 0 1-.34.163.43.43 0 0 1-.317-.135s-2.4-2.469-2.803-2.87c-.344-.346-.803-.54-1.194-.15-.408.406-.273 1.065.11 1.447.345.346 2.31 2.297 2.685 2.67l.062.06c.17.175.269.628.093.8-.193.188-.453.33-.678.273a.9.9 0 0 1-.446-.273S2.501 6.84 1.892 6.23c-.407-.406-.899-.333-1.229 0-.525.524.263 1.28 1.73 2.691.384.368.814.781 1.279 1.246m8.472-7.219c.372-.29.95-.28 1.303.244V3.19l1.563 3.006.036.074c.885 1.87.346 4.093-.512 5.159l-.035.044c-.211.264-.344.43-.74.61 1.382-1.855.963-3.478-.248-5.456L11.943 3.88l-.002-.037c-.017-.3-.039-.71.203-.895" clip-rule="evenodd"></path></svg>
                                            <?php echo $post["likes"] ?>
                                        </span>
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6B6B6B" viewBox="0 0 16 16"><path fill="#6B6B6B" d="M12.344 11.458A5.28 5.28 0 0 0 14 7.526C14 4.483 11.391 2 8.051 2S2 4.483 2 7.527c0 3.051 2.712 5.526 6.059 5.526a6.6 6.6 0 0 0 1.758-.236q.255.223.554.414c.784.51 1.626.768 2.512.768a.37.37 0 0 0 .355-.214.37.37 0 0 0-.03-.384 4.7 4.7 0 0 1-.857-1.958v.014z"></path></svg>
                                            0
                                        </span>
                                    </div>
                                    <div class="tags">
                                        <?php $topics = explode(',', $post['topics']);?>
                                        <?php foreach ($topics as $topic): ?>
                                            <a href="?action=topic&name=<?php echo strtolower(trim(htmlspecialchars($topic))); ?>"><?php echo $topic; ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php if($admin): ?>
                                    <div class="options">
                                        <a class="edit" href="?action=edit-post&id=<?php echo $post["post_id"]; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                                        </a>
                                        <?php 
                                            $PID = $post['post_id'];
                                            $UID = $_SESSION['user_id'];
                                            $IID = $post['img_id'];
                                        ?>
                                        <button class="delete" onclick="deletePost(<?php echo $PID; ?>,<?php echo $UID; ?>,'<?php echo $IID; ?>')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php if(isset($_SESSION["user_id"])): ?>
                            <div class="nothing">
                                <h3>You don't publish any post yet.</h3>
                                <a href="?action=add-post">Add post now</a>
                            </div>
                        <?php else: ?>
                            <div class="nothing">
                                <h3>This user don't publish any post yet.</h3>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="infos">
                    <div class="profile_sec">
                        <img src="<?php echo $user['photo']; ?>" alt="<?php echo $user['username']; ?>">
                        <p><?php echo $user['username']; ?></p>
                        <p><?php echo $user['followers']; ?> Followers</p>
                        <p><?php
                            if($user['bio']){
                                echo $user['bio'];
                            } else {
                                echo "Don't have bio yet";
                            }
                        ?></p>
                        <?php if(!isset($_SESSION["user_id"])): ?>
                            <a class="set" href="?action=login">
                                Login to follow
                            </a>
                        <?php elseif($admin): ?>
                            <a class="set" href="?action=settings">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                                Edit Profile
                            </a>
                        <?php else: ?>
                            <?php if(!$isFollow): ?>
                                <button class="set" id="follow-btn" data-user="<?php echo $user["id"] ?>" onclick="followBtn()">
                                    <svg style="position: relative; top: 3px; width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8l0-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5l0 3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20-.1-.1s0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5l0 3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2l0-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/></svg>
                                    Follow
                                </button>
                            <?php else: ?>
                                <button class="set" id="follow-btn" data-user="<?php echo $user["id"] ?>" onclick="unfollowBtn()">
                                    <svg style="position: relative; top: 3px; width: 14px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8l0-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5l0 3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20-.1-.1s0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5l0 3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2l0-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z"/></svg>
                                    Unfollow
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="following">
                        <h3>
                        Following
                        <svg width="33" height="6" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stop-color="#5171ff"></stop>
                                    <stop offset="100%" stop-color="#5171ff"></stop>
                                </linearGradient>
                                </defs>
                            <path d="M33 1c-3.3 0-3.3 4-6.598 4C23.1 5 23.1 1 19.8 1c-3.3 0-3.3 4-6.599 4-3.3 0-3.3-4-6.6-4S3.303 5 0 5" stroke="url(#gradient)" stroke-width="2" fill="none"></path>
                        </svg>
                        </h3>
                        <?php $arr=$followingUsers->fetch_array(); if(is_array($arr)&&count($arr)>0): ?>
                            <ul>
                                <?php foreach($followingUsers as $fluser): ?>
                                    <li>
                                        <img src="<?php echo $fluser["user_photo"]; ?>" />
                                        <a href="?action=user&id=<?php echo $fluser["user_id"]; ?>"><?php echo $fluser["user_name"]; ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Don't following anyone</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p>User not found.</p>
            <?php endif; ?>
        </div>
    </div>
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script lang="javascript">
    function followBtn(){
        let followedID = document.getElementById("follow-btn").dataset.user;
        fetch("app/helpers/FollowHelper.php",{
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({follow: true, followed: followedID})
        })
        .then(res=>res.text())
        .then(data=>{
            console.log("data", data);
            window.location.reload();
        })
        .catch(err=>console.log("error", err))
    }
    function unfollowBtn(){
        let followedID = document.getElementById("follow-btn").dataset.user;
        fetch("app/helpers/FollowHelper.php",{
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({follow: false, followed: followedID})
        })
        .then(res=>res.text())
        .then(data=>{
            console.log("data", data);
            window.location.reload();
        })
        .catch(err=>console.log("error", err))
    }
    function deletePost(id,auth,img_id){
        console.log(id,auth,img_id);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this post!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5171ff",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                fetch("app/helpers/DeletePost.php",{
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({postID: id, authID: auth, imgID: img_id})
                })
                .then(res=>res.text())
                .then(data=>{
                    if(data){
                        console.log("There is an error -> ", data);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong! Try Agin",
                        });
                    } else {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your Post has been deleted.",
                            icon: "success"
                        });
                        setTimeout(()=>{
                            window.location.reload();
                        },1500)
                    }
                    
                })
                .catch(err=>console.log("error", err))
            }
        });
    }
</script>
</body>
</html>