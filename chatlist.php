<!DOCTYPE html>
<html>

<head>
    <title>Chat Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <?php include("template/header.php"); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mt-4">Search Users to Chat</h2>
                <div class="input-group mb-3">
                    <input type="text" id="searchInput" class="form-control" placeholder="Enter username to search">
                    <div class="input-group-append">
                        <button id="searchButton" class="btn btn-primary" type="button">Search</button>
                    </div>
                </div>

                <h2 class="text-center mt-4">List of Users</h2>
                <ul id="chatList" class="list-group">
                    <!-- Chats will be dynamically added here -->
                </ul>
            </div>
        </div>
    </div>

    <?php include("template/footer.php"); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        // Function to fetch users and update the chat list
        function fetchUsers() {
            // Get the search input value
            const searchTerm = document.getElementById('searchInput').value;

            // Send an AJAX request to the controller
            $.ajax({
                url: 'fetchuser.php',
                type: 'GET',
                data: {
                    search: searchTerm
                },
                success: function(response) {
                    // Clear the chat list
                    document.getElementById('chatList').innerHTML = '';

                    // Loop through the users and add them to the chat list
                    response.forEach(function(user) {
                        const chatItem = document.createElement('li');
                        chatItem.classList.add('list-group-item');
                        const userLink = document.createElement('a');
                        userLink.href = 'chat.php?user=' + encodeURIComponent(user.username);
                        userLink.innerText = user.username;
                        chatItem.appendChild(userLink);
                        document.getElementById('chatList').appendChild(chatItem);
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error); // Handle the error
                }
            });
        }

        // Attach an event listener to the search button
        document.getElementById('searchButton').addEventListener('click', fetchUsers);
    </script>
</body>

</html>
