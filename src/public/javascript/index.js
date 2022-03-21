$(document).ready(function () {
  if (sessionStorage.getItem("login") == 1) {
    $(".authButton").html("SignOut");
    displayForm();
    getPosts();
  } else {
    $(".authButton").html("SignIn");
  }
  $(".profile").html(
    `<a class="btn  profile text-dark fw-bold " href="profile/?id=${sessionStorage.getItem(
      "user_id"
    )}">Profile</a>`
  );
  $(".authButton").click(function () {
    if (sessionStorage.getItem("login") == 1) {
      sessionStorage.removeItem("login");
    }
    location.replace("/login");
  });

  $(".btnSearch").click(function () {
    $.ajax({
      url: "/index/operation",
      method: "post",
      data: { action: "getUser", value: $("#searchInput").val() },
      dataType: "JSON",
    }).done((data) => {
      var html = "";
      if (data.length > 0) {
        $(".result").show();
        console.log(data);
        for (let i = 0; i < data.length; i++) {
          html += `<div class='col-7 mx-auto px-4 py-2 '><a class='btn text-muted' href='/profile?id=${data[i].user_id}'>
          ${data[i].name},-----address---${data[i].city}, ${data[i].country}----------user_id-----------#${data[i].username}
         </a>
          </div>`;
        }
        $(".result").html(html);
      } else {
        $(".result").show();
        $(".result").html(
          '<div class="col-12 text-center">No user found!!!</div>'
        );
      }
    });
  });

  $(".postBtn").click(function () {
    console.log($(".inpFIle").files);
  });

  $(".viewOption").click(function () {
    console.log($(this).data("feed"));

    if ($(this).data("feed") == "my") {
      $.ajax({
        url: "/index/operation",
        method: "post",
        data: {
          action: "getUserPost",
          user_id: sessionStorage.getItem("user_id"),
        },
        dataType: "JSON",
      }).done(function (data) {
        displayPosts(data);
      });
    } else {
      $.ajax({
        url: "/index/operation",
        method: "post",
        data: {
          action: "getOtherPosts",
          user_id: sessionStorage.getItem("user_id"),
        },
        dataType: "JSON",
      }).done(function (response) {
        $.ajax({
          url: "/index/operation",
          method: "post",
          data: {
            action: "getCircle",
            user_id: sessionStorage.getItem("user_id"),
          },
          dataType: "JSON",
        }).done(function (data) {
          var friends = JSON.parse(data[0].circle);
          console.log(friends);
          console.log(response);
          var friendsPost = response.filter((x) =>
            friends.friends.includes(x.user_id)
          );
          console.log(friendsPost);
          displayPosts(friendsPost);
        });
      });
    }
  });
});

function displayForm() {
  $(".formPost").html(`
      <form action="/index/post?id=${sessionStorage.getItem(
        "user_id"
      )}&name=${sessionStorage.getItem(
    "name"
  )}" method="post" enctype="multipart/form-data" >
        <div class='row '>
            <div class='col-8 mx-auto border'>
                <div class='row' style='border:1px solid rgb(194, 214, 214);'>
                    <textarea name="postText" id="postText" style='border-style: none; 
                      border-color: Transparent;' placeholder='Create Post'></textarea>
                </div>
                <div class='row'>
                   <label for="fileToUpload" class="btn fw-bold">
                        <input type="file" accept="video/*|image/*" name="fileToUpload" id="fileToUpload"  required>
                    </label>
                    <input type="submit" value="POST" class="btn btn-secondary fw-bold " name="submit">
                </div>
           </div>
        </div>   
      </form>
  `);
}
function getPosts() {
  $.ajax({
    url: "/index/operation",
    method: "post",
    data: { action: "getUserPost", user_id: sessionStorage.getItem("user_id") },
    dataType: "JSON",
  }).done(function (data) {
    console.log("posts display");
    displayPosts(data, 0);
  });
}

function displayPosts(data) {
  var html = "";
  for (var i = 0; i < data.length; i++) {
    html += `
       <div class="col-6 mx-auto">
       <a href="/post?id=${data[i].post_id}">
        <div class="card p-4 " style="width: 30rem;">
            <img  src="${data[i].file}" class="card-img-top" alt="...">
            <video  height="240" controls style='display:${
              !data[i].file.includes(".mp4") && "none"
            }; '>
  <source src="${data[i].file}" alt='.' >
  
  Your browser does not support the video tag.
</video>
            <div class="card-body">
                <h5 class="card-title text-dark">${data[i].name}</h5>
                <p class="card-text text-dark">${data[i].post_body}</p>
            </div>
            </div>
       </a>
    </div>

    
      `;
  }
  $(".feeds").html(html);
}
