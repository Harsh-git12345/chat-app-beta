<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.1.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.1.2/firebase-database.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyBXqyMpCL1msG6q1sdE1dG4H7x6OfVtspg",
    authDomain: "test-c9497.firebaseapp.com",
    projectId: "test-c9497",
    storageBucket: "test-c9497.appspot.com",
    messagingSenderId: "932281466751",
    appId: "1:932281466751:web:5e9e51907d5ef4faf3e44a"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);

  var myName = prompt(" Enter Your Name ");
  function sendMessage() {
      var message = document.getElementById("message").value;
      firebase.database().ref("messages").push().set({
          "sender": myName,
          "message": message
      });
      return false;
  }
  firebase.database().ref("messages").on("child_added", function (snapshot) {
    var html = "";
    html += "<li id='message-" + snapshot.key + "'>"
        if(snapshot.val().sender == myName) {
            html += "<button data-id='" + snapshot.key + "' onclick='deleteMessage(this);'>"
                html += "Delete"
            html += "</button>"
        }
        html += snapshot.val().sender + ": " + snapshot.val().message;
    html += "</li>"

    document.getElementById("messages").innerHTML += html;
  })
  function deleteMessage(self) {
      var messageId = self.getAttribute("data-id")
      firebase.database().ref("messages").child(messageId).remove();
  }
  firebase.database().ref("messages").on("child_removed", function (snapshot){
    document.getElementById("message-" + snapshot.key).innerHTML = "This Message Has Been Deleted"
  })
</script>

<form onsubmit="return sendMessage();">
  <input id="message" placeholder="Enter Message" autocomplete="off">
  <input type="submit">
</form>

<ul id="messages"></ul>