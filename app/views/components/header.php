<?php 

// Models
if(isset($_SESSION["user_id"])){
  require 'config/db.php';
  $stmt=$db->prepare("SELECT id,content,isRead,date FROM notifications WHERE to_id = ? ORDER BY date DESC");
  $stmt->execute([$_SESSION["user_id"]]);
  $notifications = $stmt->get_result();
  $notifications->fetch_all();
  // print_r($notifications);
}

?>

<header>
    <nav>
      <!-- <div class="logo">Katen<span>.</span></div> -->
      <a href="?action=" class="logo">
        <img src="./public/assets/min.png" />
        <p>WessBlog</p>
      </a>
      <div class="sec">
        <ul>
          <li class="active"><a href="?action=">Home</a></li>
          <?php if(isset($_SESSION["user_id"])): ?>
            <li class="active"><a href="?action=for-you">Following</a></li>
          <?php endif; ?>
          <li class="ds">
              <form class="search_bar" action="?action=search" enctype="multipart/form-data" method="POST">
                <input type="text" required placeholder="Search..." name="keywords" />
                <button>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                </button>
              </form>
          </li>
        </ul>
        <?php if(isset($_SESSION['user_id'])): ?>
          <div class="btns">
            <a class="lk dr" href="?action=add-post">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z"/></svg>
              Add New Post
            </a>
            <div class="notifications">
              <div class="icon">
                <span class="new"></span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/></svg>
              </div>
              <ul class="content">
                <?php if($notifications->num_rows): ?>
                  <?php foreach($notifications as $notif): ?>
                    <li class="<?php echo $notif["isRead"] ?"" :"unread" ?>" data-id="<?php echo $notif['id']; ?>" onclick="readNotification(<?php echo $notif['id'] ?>)">
                      <?php echo $notif["content"]; ?>
                      <span class="date"><?php
                        $date = new DateTime($notif["date"]);
                        echo $date->format('F j, Y');
                      ?></span>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li><p class="nothing">Nothing yet</p></li>
                <?php endif; ?>
              </ul>
            </div>
            <div class="profile_down">
                <img src="<?php echo $_SESSION['user_photo']; ?>" alt="Avatar" class="avatar" onclick="toggleProfile()">
                <div id="dropdown-menu" class="dropdown-menu">
                    <a href="?action=my-profile">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                      My Profile
                    </a>
                    <a href="?action=settings">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                      Settings
                    </a>
                    <hr>
                    <a href="?action=logout">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"/></svg>
                      Logout
                    </a>
                </div>
            </div>
          </div>
        <?php else: ?>
          <div class="btns">
            <a class="lk" href="?action=login">Sign in</a>
            <a class="lk" href="?action=register">Sign up</a>
          </div>
        <?php endif; ?>
      </div>
      <div class="menu" onclick="toggleMenu()">
        <svg class="iconMenu" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path class="pathIcon" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>
      </div>
    </nav>
</header>
<script>
  function toggleProfile() {
    const dropdownMenu = document.getElementById("dropdown-menu");
    if (dropdownMenu.style.display === "block") {
        dropdownMenu.style.display = "none";
    } else {
        dropdownMenu.style.display = "block";
    }
  }
  function toggleMenu() {
    const menu = document.querySelector(".sec");
    if (menu.style.display === "flex") {
      menu.style.display = "none";
    } else {
      menu.style.display = "flex";
    }
  }
  window.onclick = function(event) {
      if (!event.target.matches('.avatar')) {
          const dropdowns = document.getElementsByClassName("dropdown-menu");
          for (let i = 0; i < dropdowns.length; i++) {
              const openDropdown = dropdowns[i];
              if (openDropdown.style.display === "block") {
                  openDropdown.style.display = "none";
              }
          }
      }
  }
  // Notifications
  let notificationsUnread = document.querySelectorAll(".notifications .unread");
  let newNotif = document.querySelector(".notifications .new");
  if(notificationsUnread.length > 0){
    newNotif.classList.add("show");
    newNotif.textContent = notificationsUnread.length;
  }
  let openNotifBtn = document.querySelector(".notifications .icon");
  let contentNotifBtn = document.querySelector(".notifications .content");
  openNotifBtn.onclick = (e) => {
    if(contentNotifBtn.classList.contains("hide")){
      closeNotification();
    } else {
      contentNotifBtn.classList.add("hide");
      openNotifBtn.classList.add("active");
    }
  }
  function closeNotification(){
    if(contentNotifBtn.classList.contains("hide")){
      contentNotifBtn.classList.remove("hide");
      openNotifBtn.classList.remove("active");
      if(notificationsUnread.length > 0){
        notificationsUnread.forEach((elm) =>{
          if(elm.classList.contains("unread")){
            // console.log("read",elm.dataset.id);
            elm.classList.remove("unread");
            readNotification(elm.dataset.id);
          }
        });
        newNotif.classList.remove("show");
        newNotif.textContent = notificationsUnread.length;
      }
    }
  }
  document.addEventListener('click', (event) => {
      if (!contentNotifBtn.contains(event.target) && event.target !== openNotifBtn) {
        closeNotification();
      }
  });
  function readNotification(id){
    fetch("app/helpers/Notifications.php",{
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({action: "read", notif_id: id})
    })
    .then(res=>res.text())
    .then(data=>{
        if(!data){
          // console.log(id, "read done");
        } else {
          // console.log(id, "read error");
        }
    })
    .catch(err=>{
        // console.log("error", err);
    });
  }
</script>