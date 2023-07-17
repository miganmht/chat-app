<?php
session_start();

// Check if the username is set in the session
if (isset($_SESSION['username'])) {
    $usernameh = $_SESSION['username'];
} else {
    // Redirect to the login page or perform any other action
    header("Location: login.php");
    exit();
}
$usernamec = $_GET["user"];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Chat Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@chatscope/chat-ui-kit/dist/main.css" />
</head>

<body>
    <?php include("template/header.php"); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mt-4">Chat</h2>
                <div id="messageList" class="chat-container">
                    <!-- Messages will be dynamically added here -->
                </div>
                <div class="input-group mt-4">
                    <input type="text" id="messageInput" class="form-control" placeholder="Type your message...">
                    <button id="sendMessageButton" class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>

    <?php include("template/footer.php"); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@chatscope/chat-ui-kit/dist/main.js"></script>
    <script>
        // Define the ChatMessage class
        class ChatMessage {
            constructor({
                text,
                sender,
                direction
            }) {
                this.text = text;
                this.sender = sender;
                this.direction = direction;
            }

            render() {
                // Render the chat message HTML
                // Replace this with your own rendering logic
                return `<div>${this.text}</div>`;
            }
        }

        // Assign PHP variables to JavaScript variables
        const usernameh = "<?php echo $usernameh; ?>";
        const usernamec = "<?php echo $usernamec; ?>";

        // Function to load past messages
        function loadMessages() {
            // Make an AJAX request to the controller
            $.ajax({
                url: 'get_messages.php',
                type: 'GET',
                data: {
                    sender: usernameh,
                    receiver: usernamec
                },
                dataType: 'json', // Add this line to specify the expected response type
                success: function(response) {
                    // Clear the message list
                    $('#messageList').empty();

                    // Loop through the messages and add them to the message list
                    response.forEach(function(message) {
                        const chatMessage = new ChatMessage({
                            text: message.message,
                            sender: message.usernamesender,
                            direction: message.usernamesender === usernameh ? 'outgoing' : 'incoming'
                        });
                        $('#messageList').append(chatMessage.render());
                    });

                    // Scroll to the bottom of the message list
                    $('#messageList').scrollTop($('#messageList')[0].scrollHeight);
                },
                error: function(xhr, status, error) {
                    console.log(error); // Handle the error
                }
            });
        }

        // Function to send a new message
        function sendMessage() {
            // Get the message input value
            const messageText = $('#messageInput').val().trim();

            // Send an AJAX request to the controller to save the message
            $.ajax({
                url: 'save_message.php',
                type: 'POST',
                data: {
                    sender: usernameh,
                    receiver: usernamec,
                    message: messageText
                },
                success: function(response) {
                    // Clear the message input
                    $('#messageInput').val('');

                    // Load the updated message list
                    loadMessages();
                },
                error: function(xhr, status, error) {
                    console.log(error); // Handle the error
                }
            });
        }

        // Attach an event listener to the send message button
        $('#sendMessageButton').on('click', sendMessage);

        // Load the initial message list
        loadMessages();
    </script>
</body>

</html>