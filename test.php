<html>
*********************************LOGIN*************************************************************
    <form method="post" action="user.php?action=login">
        <input type = "text" name = "action" value = "login"><br>
        username:<input type = "text" name = "username"><br/>
        password:<input type = "text" name = "password">
        <button type = "submit">Login</button>
    </form>
***********************************SIGNUP***********************************************************
      <form method="post" action="user.php?action=signup" enctype="multipart/form-data">
          <input type = "text" name = "action" value = "signup">
          <br>
          <input type="file" name="fileToUpload" id="fileToUpload"><br/>
          schoolId:<input type = "text" name = "schoolId"><br/>
        username:<input type = "text" name = "username"><br/>
        password:<input type = "text" name = "password"><br/>
        email:<input type = "text" name = "email"><br/>
        birthdate:<input type = "text" name = "birthdate"><br/>
        programId:<input type = "text" name = "programId"><br/>
        fullname:<input type = "text" name = "full_name"><br/>

        <button type = "submit">Sign Up</button>
    </form>
*****************************POST*****************************************************************
     <form method="POST" action="post.php">
        <input type = "text" name = "action" value = "new"><br>
        ownerId:<input type = "text" name = "ownerId"><br/>
        description:<input type = "text" name = "description"><br/>
        tags:<input type = "text" name = "tags"><br/>
        type:<input type = "text" name = "type"><br/>

        <button type = "submit">Post</button>
    </form>
****************************FEEDS******************************************************************
    <form method="POST" action="post.php?action=feed">
        <input type = "text" name = "ownerId" value = "121-122">
        <button type = "submit">Feed</button>
    </form>
    <form method="POST" action="post.php?action=getPost">
        <input type = "text" name = "postId" value = "">
        <button type = "submit">GET POST</button>
    </form>

**************************SEARCH********************************************************************
        <form method="GET" action="search.php">
          <input type = "text" name = "imo" value = "121-122" >
        <input type = "text" name = "action" >
        <input type = "text" name = "queries" >
        <button type = "submit">Search</button>
    </form>
      </form>
*****************************FOLLOW*****************************************************************
        <form method="POST" action="user.php?action=addfollowing">
        <input type = "text" name = "imo" >
        <input type = "text" name = "iya" >
        <button type = "submit">Follow</button>
    </form>
*****************************UNFOLLOW*****************************************************************
        <form method="POST" action="user.php?action=unfollow">
            <input type = "text" name = "imo" >
            <input type = "text" name = "iya" >
            <button type = "submit">Follow</button>
        </form>
****************************COMMENT********************************************************************
    <form method="POST" action="comment.php?action=getcomments">
        <input type = "text" name = "postId" >
        <button type = "submit">View comment</button>
    </form>
****************************Event********************************************************************
    <form method="POST" action="events.php?action=getEvent">
        <input type = "text" name = "edate" >
        <button type = "submit">Get Event</button>
    </form>
***************************ACTIVITY*******************************************************************
  <form method="POST" action="activity.php?action=getActivities">
      <input type = "text" name = "ownerId" >
      <button type = "submit">Follow</button>
  </form>
</html>
