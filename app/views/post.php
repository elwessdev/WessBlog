<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($name); ?> - WessBlog</title>
    <?php include("components/favicon.php") ?>
<!-- CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./public/style/main.css">
</head>
<body class="post">
<!-- Header -->
<div class="container mx-auto px-6 py-4">
    <?php include("components/header.php") ?>
    <!-- Page content -->
    <div class="post_content">
        <h2><?php echo htmlspecialchars($post["postTitle"]) ?></h2>
        <a class="user" href="
            <?php
                if(isset($_SESSION["user_id"])&&$post["authorId"]==$_SESSION["user_id"]){
                    echo '?action=my-profile';
                } else {
                    echo "?action=user&id={$post['authorId']}";
                }
            ?>">
            <img src="<?php echo $post['authorPhoto']; ?>" />
            <p>
                <?php 
                    echo $post['authorName']; 
                    if(isset($_SESSION["user_id"])&&$post["authorId"]==$_SESSION["user_id"]){
                        echo ' (Me)';
                    }
                ?>
            </p>
        </a>
        <?php if(isset($_SESSION["user_id"]) && $_SESSION["user_id"]==$post["authorId"]): ?>
            <a href="?action=edit-post&id=<?php echo $post["postId"]; ?>" class="edit">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/></svg>
                Edit Post
            </a>
        <?php endif; ?>
        <div class="tags">
            <?php $topicsPost = explode(',', $post["topics"]);?>
            <?php foreach ($topicsPost as $topic): ?>
                <a href="?action=topic&name=<?php echo strtolower(trim($topic)); ?>"><?php echo $topic; ?></a>
            <?php endforeach; ?>
        </div>
        <div class="img">
            <img src="<?php echo $post["postCover"]; ?>" />
        </div>
        <div class="txt"><?php echo htmlspecialchars($post["postContent"]) ?></div>
        <div class="ld">
            <span class="like-btn" data-postid="<?php echo $post["postId"]; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16"><path fill="#6B6B6B" fill-rule="evenodd" d="m3.672 10.167 2.138 2.14h-.002c1.726 1.722 4.337 2.436 5.96.81 1.472-1.45 1.806-3.68.76-5.388l-1.815-3.484c-.353-.524-.849-1.22-1.337-.958-.49.261 0 1.56 0 1.56l.78 1.932L6.43 2.866c-.837-.958-1.467-1.108-1.928-.647-.33.33-.266.856.477 1.598.501.503 1.888 1.957 1.888 1.957.17.174.083.485-.093.655a.56.56 0 0 1-.34.163.43.43 0 0 1-.317-.135s-2.4-2.469-2.803-2.87c-.344-.346-.803-.54-1.194-.15-.408.406-.273 1.065.11 1.447.345.346 2.31 2.297 2.685 2.67l.062.06c.17.175.269.628.093.8-.193.188-.453.33-.678.273a.9.9 0 0 1-.446-.273S2.501 6.84 1.892 6.23c-.407-.406-.899-.333-1.229 0-.525.524.263 1.28 1.73 2.691.384.368.814.781 1.279 1.246m8.472-7.219c.372-.29.95-.28 1.303.244V3.19l1.563 3.006.036.074c.885 1.87.346 4.093-.512 5.159l-.035.044c-.211.264-.344.43-.74.61 1.382-1.855.963-3.478-.248-5.456L11.943 3.88l-.002-.037c-.017-.3-.039-.71.203-.895" clip-rule="evenodd"></path></svg>
                <span class="nums"><?php echo $post["postLikes"]; ?></span>
                <span class="like_pop">+1</span>
            </span>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6B6B6B" viewBox="0 0 16 16"><path fill="#6B6B6B" d="M12.344 11.458A5.28 5.28 0 0 0 14 7.526C14 4.483 11.391 2 8.051 2S2 4.483 2 7.527c0 3.051 2.712 5.526 6.059 5.526a6.6 6.6 0 0 0 1.758-.236q.255.223.554.414c.784.51 1.626.768 2.512.768a.37.37 0 0 0 .355-.214.37.37 0 0 0-.03-.384 4.7 4.7 0 0 1-.857-1.958v.014z"></path></svg>
                <?php echo $post["comments"] ?>
            </span>
            <p class="date"><?php $date = new DateTime($post["postDate"]); echo $date->format('F j, Y'); ?></p>
        </div>
        <!-- Comments Section -->
        <div class="comments">
            <h2 class="title">
                Comments
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
            <!-- Add Comment -->
            <?php if(isset($_SESSION["user_id"])): ?>
                <?php if($_SESSION["user_id"]!=$post["authorId"]): ?>
                    <div class="add_comment">
                        <div class="user">
                            <img src="<?php echo $_SESSION['user_photo']; ?>" />
                            <p><?php echo $_SESSION['username']; ?></p>
                        </div>
                        <textarea class="addContent" placeholder="Create your comment here..."></textarea>
                        <p class="error"></p>
                        <button class="btn" onclick="addComment(<?php echo $post['postId']; ?>,<?php echo $_SESSION['user_id']; ?>)">Post</button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <a class="loginToComment" href="?action=login">Login to add comment</a>
            <?php endif; ?>
            <!-- Comments -->
            <div class="list_comments">
                <?php if(!empty($comments)): ?>
                    <?php foreach($comments as $comment): ?>
                        <div class="comment">
                            <!-- Main comment -->
                            <div class="cm">
                                <a class="user" href="
                                    <?php
                                        if(isset($_SESSION["user_id"])&&$comment["user_id"]==$_SESSION["user_id"]){
                                            echo '?action=my-profile';
                                        } else {
                                            echo "?action=user&id={$comment['user_id']}";
                                        }
                                    ?>">
                                    <img src="<?php echo $comment['user_photo']; ?>" />
                                    <p>
                                        <?php 
                                            echo $comment['user_name']; 
                                            if(!isset($_SESSION["user_id"])&&$comment["user_id"]==$post["authorId"]){
                                                echo ' (Author)';
                                            } else if(isset($_SESSION["user_id"])&&$comment["user_id"]==$_SESSION["user_id"]){
                                                echo ' (Me)';
                                            }
                                        ?>
                                    </p>
                                </a>
                                <p><?php echo $comment['content']; ?></p>
                                <div class="edt"></div>
                                <div class="details">
                                    <div class="like-comment" onclick="likeComment(this,<?php echo $comment['comment_id']; ?>,<?php echo $post['postId']; ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 16 16"><path fill="#6B6B6B" fill-rule="evenodd" d="m3.672 10.167 2.138 2.14h-.002c1.726 1.722 4.337 2.436 5.96.81 1.472-1.45 1.806-3.68.76-5.388l-1.815-3.484c-.353-.524-.849-1.22-1.337-.958-.49.261 0 1.56 0 1.56l.78 1.932L6.43 2.866c-.837-.958-1.467-1.108-1.928-.647-.33.33-.266.856.477 1.598.501.503 1.888 1.957 1.888 1.957.17.174.083.485-.093.655a.56.56 0 0 1-.34.163.43.43 0 0 1-.317-.135s-2.4-2.469-2.803-2.87c-.344-.346-.803-.54-1.194-.15-.408.406-.273 1.065.11 1.447.345.346 2.31 2.297 2.685 2.67l.062.06c.17.175.269.628.093.8-.193.188-.453.33-.678.273a.9.9 0 0 1-.446-.273S2.501 6.84 1.892 6.23c-.407-.406-.899-.333-1.229 0-.525.524.263 1.28 1.73 2.691.384.368.814.781 1.279 1.246m8.472-7.219c.372-.29.95-.28 1.303.244V3.19l1.563 3.006.036.074c.885 1.87.346 4.093-.512 5.159l-.035.044c-.211.264-.344.43-.74.61 1.382-1.855.963-3.478-.248-5.456L11.943 3.88l-.002-.037c-.017-.3-.039-.71.203-.895" clip-rule="evenodd"></path></svg>
                                        <span class="nums"><?php echo $comment["likes"]; ?></span>
                                        <span class="like_pop">+1</span>
                                    </div>
                                    <span class="date">
                                        <?php 
                                            $date = new DateTime($comment["date"]);
                                            echo $date->format("F j, Y"); 
                                        ?>
                                    </span>
                                    <?php if(isset($_SESSION["user_id"])&&$comment["user_id"]==$_SESSION["user_id"]): ?>
                                        <div class="options">
                                            <button class="edit-op" onclick="editComment(this,<?php echo $comment['comment_id'] ?>,<?php echo $comment['user_id'] ?>,<?php echo $_SESSION['user_id'] ?>)">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"></path></svg>
                                            </button>
                                            <?php if(empty($comment["replies"])): ?>
                                                <button class="delete-op" onclick="deleteComment(<?php echo $comment['comment_id'] ?>,<?php echo $comment['user_id'] ?>,<?php echo $_SESSION['user_id'] ?>)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"></path></svg>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Replies -->
                            <?php if(!empty($comment["replies"])): ?>
                                <?php foreach($comment['replies'] as $reply): ?>
                                    <div class="cm comment-reply">
                                        <a class="user" href="
                                            <?php
                                                if(isset($_SESSION["user_id"])&&$reply["reply_user_id"]==$_SESSION["user_id"]){
                                                    echo '?action=my-profile';
                                                } else {
                                                    echo "?action=user&id={$reply['reply_user_id']}";
                                                }
                                            ?>">
                                            <img src="<?php echo $reply['reply_user_photo']; ?>" />
                                            <p>
                                                <?php 
                                                    echo $reply['reply_user_name']; 
                                                    if($reply["reply_user_id"]==$post["authorId"]){
                                                        echo ' (Author)';
                                                    }
                                                    if(isset($_SESSION["user_id"])&&$reply["reply_user_id"]==$_SESSION["user_id"]){
                                                        echo ' (Me)';
                                                    }
                                                ?>
                                            </p>
                                        </a>
                                        <p><?php echo $reply['content']; ?></p>
                                        <div class="edt"></div>
                                        <div class="details">
                                            <span class="date" style="margin-left: 0;">
                                                <?php 
                                                    $date = new DateTime($reply["date"]);
                                                    echo $date->format("F j, Y"); 
                                                ?>
                                            </span>
                                            <?php if(isset($_SESSION["user_id"])&&$reply["reply_user_id"]==$_SESSION["user_id"]): ?>
                                                <div class="options">
                                                    <button class="edit-op" onclick="editReply(this,<?php echo $reply['reply_id'] ?>,<?php echo $reply['comment_id'] ?>,<?php echo $reply['reply_user_id'] ?>,<?php echo $_SESSION['user_id'] ?>)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"></path></svg>
                                                    </button>
                                                    <button class="delete-op" onclick="deleteReply(<?php echo $reply['reply_id'] ?>,<?php echo $reply['comment_id'] ?>,<?php echo $reply['reply_user_id'] ?>,<?php echo $_SESSION['user_id'] ?>)">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"></path></svg>
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <!-- Reply section -->
                            <?php if(isset($_SESSION["user_id"])&&($post["authorId"]==$_SESSION["user_id"]||$comment["user_id"]==$_SESSION["user_id"])): ?>
                                <div class="reply">
                                    <button class="tglBtn" onclick="openReply(this)">Reply</button>
                                    <div class="reply_section">
                                        <textarea placeholder="Reply here..."></textarea>
                                        <p class="error"></p>
                                        <button class="btn" 
                                        onclick="addReply(
                                            this,
                                            <?php echo $_SESSION['user_id']; ?>,
                                            <?php echo $comment['comment_id']; ?>
                                        )"
                                        >Post</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="nothing">
                        <h3>No comment yet</h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<?php include("components/footer.php") ?>
<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Like Post
    let likePost = document.querySelector(".like-btn");
    likePost.onclick = () => {
        let postID=likePost.dataset.postid;
        // console.log(postID);
        addLike(postID);
        document.querySelector(".like-btn .like_pop").classList.add("show");
        let n = likePost.children[1];
        n.textContent = Number(n.textContent)+1;
        setTimeout(()=>{
            document.querySelector(".like-btn .like_pop").classList.remove("show");
        },200);
    }
    function addLike(id){
        fetch("app/helpers/Clap.php",{
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({postID: id})
        })
        .then(res=>res.text())
        .then(data=>{
            // console.log("data", "clap");
        })
        .catch(err=>{
            // console.log("error", err);
        })
    }
    // Like Comment
    function likeComment(e,commentID,postID){
        // console.log(commentID,postID);
        fetch("app/helpers/Comment.php",{
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action: "like",
                comment_id: commentID,
                post_id: postID,
            })
        })
        .then(res=>res.text())
        .then(data=>{
            if(data.length<1){
                let pop = e.children[2];
                pop.classList.add("show");
                let n = e.children[1];
                n.textContent = Number(n.textContent)+1;
                setTimeout(()=>{
                    pop.classList.remove("show");
                },200);
                // console.log("Add like", "done");
            } else {
                // console.log("Add like", data);
            }
        })
        .catch(err=>{
            // console.log("error", err);
        });
    }
    function openReply(a){
        a.parentElement.children[1].classList.toggle("show");
    }
    // Comment Actions
    function Alert(title,icon){
        Swal.fire({
            title: title,
            icon: icon,
        });
    }
    function addComment(postID,userID){
        let content = document.querySelector(".addContent").value;
        let commentError = document.querySelector(".add_comment .error");
        if(content.length<10){
            // console.log("Please add comment");
            commentError.innerHTML = "The comment at least 8 characters";
        } else {
            // console.log(postID,userID);
            // console.log(content);
            commentError.innerHTML=" ";
            fetch("app/helpers/Comment.php",{
                method:"POST",
                header:{
                    'Content-Type':'application/json'
                },
                body: JSON.stringify({action: "add", post_id: postID, user_id: userID, commentContent: content})
            })
            .then(res=>res.text())
            .then(data=>{
                if(!data){
                    // console.log("Add comment","done");
                    Alert("Your comment has been added 👌","success");
                    setTimeout(()=>window.location.reload(),1000);
                } else {
                    // console.log("Add comment",data);
                    Alert("Something went wrong! Try Agin 😥","error");
                }
            })
            .catch(err=>{
                // console.log("Add comment",err);
                Alert("Something went wrong! Try Agin 😥","error");
            })
        }
    }
    function editComment(e,commentID,userID,sessionID){
        // console.log(commentID,userID,sessionID);
        if(userID==sessionID){
            let oldComment = e.parentElement.parentElement.parentElement.children[1].textContent;
            Swal.fire({
                input: "textarea",
                inputValue: oldComment,
                inputAttributes: {autocapitalize: "off"},
                showCancelButton: true,
                confirmButtonText: "Post",
            }).then((result) => {
                if (result.isConfirmed) {
                    if(result.value == oldComment){
                        Alert("Your comment still the same 😎","warning");
                    } else if(result.value) {
                        let newComment = result.value;
                        fetch("app/helpers/Comment.php",{
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({action: "edit", new_comment: newComment, comment_id: commentID, user_id: userID})
                        })
                        .then(res=>res.text())
                        .then(data=>{
                            if(!data){
                                Alert("Your comment is modified 👌","success");
                                setTimeout(()=>window.location.reload(),1000);
                            } else {
                                // console.log("There is an error -> ", data);
                                Alert("Something went wrong! Try Agin 😥","error");
                            }
                        })
                        .catch(err=>{
                            // console.log("error", err);
                            Alert("Something went wrong! Try Agin 😥","error");
                        })
                    } else {
                        Alert("Don't stay modify comment empty 😎","warning");
                    }
                }
            });
        } else{
            Alert("Be aware you doing danger action 😎","error");
        }
    }
    function deleteComment(commentID,userID,sessionID){
        if(userID==sessionID){
            Swal.fire({
            title: "Are you sure?",
            // text: "You won't be able to revert this comment!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5171ff",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                fetch("app/helpers/Comment.php",{
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({action: "delete", comment_id: commentID, user_id: userID})
                })
                .then(res=>res.text())
                .then(data=>{
                    if(!data){
                        Alert("Your comment has been deleted 👌","success");
                        setTimeout(()=>window.location.reload(),1000);
                    } else {
                        // console.log("There is an error -> ", data);
                        Alert("Something went wrong! Try Agin 😥","error");
                    }
                })
                .catch(err=>{
                    // console.log("error", err);
                    Alert("Something went wrong, Try again 😥","warning");
                })
            }
        });
        } else {
            Alert("Be aware you take danger action 😎","error");
        }
    }
    // Reply actions
    function addReply(e,userID,commentID){
        // console.log(userID,commentID);
        let replyContent = e.parentElement.children[0].value;
        let replyError = e.parentElement.children[1];
        if(replyContent.length<1){
            replyError.innerHTML = "Be carful your reply is empty";
        } else {
            replyError.innerHTML="";
            fetch("app/helpers/Comment.php",{
                method:"POST",
                header:{
                    'Content-Type':'application/json'
                },
                body: JSON.stringify({action: "addReply", user_id: userID, comment_id: commentID, reply_content: replyContent})
            })
            .then(res=>res.text())
            .then(data=>{
                if(!data){
                    // console.log("Add comment","done");
                    Alert("Your reply has been added 👌","success");
                    setTimeout(()=>window.location.reload(),1000);
                } else {
                    // console.log("Add comment",data);
                    Alert("Something went wrong! Try Agin 😥","error");
                }
            })
            .catch(err=>{
                // console.log("Add comment",err);
                Alert("Something went wrong! Try Agin 😥","error");
            })
        }
    }
    function editReply(e,replyID,commentID,userID,sessionID){
        // console.log(commentID,userID,sessionID);
        if(userID==sessionID){
            let oldComment = e.parentElement.parentElement.parentElement.children[1].textContent;
            Swal.fire({
                input: "textarea",
                inputValue: oldComment,
                inputAttributes: {autocapitalize: "off"},
                showCancelButton: true,
                confirmButtonText: "Post",
            }).then((result) => {
                if (result.isConfirmed) {
                    if(result.value == oldComment){
                        Alert("Your comment still the same 😎","warning");
                    } else if(result.value) {
                        let newReply = result.value;
                        fetch("app/helpers/Comment.php",{
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({action: "editReply", new_reply: newReply, comment_id: commentID, reply_id: replyID, user_id: userID})
                        })
                        .then(res=>res.text())
                        .then(data=>{
                            if(!data){
                                Alert("Your reply is modified 👌","success");
                                setTimeout(()=>window.location.reload(),1000);
                            } else {
                                // console.log("There is an error -> ", data);
                                Alert("Something went wrong! Try Agin 😥","error");
                            }
                            
                        })
                        .catch(err=>{
                            // console.log("error", err);
                            Alert("Something went wrong! Try Agin 😥","error");
                        })
                    } else {
                        Alert("Don't stay modify reply empty 😎","warning");
                    }
                }
            });
        } else{
            Alert("Be aware you doing danger action 😎","error");
        }
    }
    function deleteReply(replyID,commentID,userID,sessionID){
        if(userID==sessionID){
            Swal.fire({
            title: "Are you sure?",
            // text: "You won't be able to revert this comment!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5171ff",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
            if (result.isConfirmed) {
                fetch("app/helpers/Comment.php",{
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({action: "deleteReply", reply_id: replyID, comment_id: commentID, user_id: userID})
                })
                .then(res=>res.text())
                .then(data=>{
                    if(!data){
                        Alert("Your reply has been deleted 👌","success");
                        setTimeout(()=>window.location.reload(),1000);
                    } else {
                        // console.log("There is an error -> ", data);
                        Alert("Something went wrong! Try Agin 😥","error");
                    }
                })
                .catch(err=>{
                    // console.log("error", err);
                    Alert("Something went wrong, Try again 😥","warning");
                })
            }
        });
        } else {
            Alert("Be aware you take danger action 😎","error");
        }
    }
</script>
<body>
</body>
</html>