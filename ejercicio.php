<?php
class GitHubRepos {
    private $db;
    private $repos = array();
    private $perPage = 10;
    private $page = 1;
    private $totalPages;
    private $ownerFilter = '';
    private $sortField = 'updated_at';
    private $sortOrder = 'DESC';

    public function __construct($dbHost, $dbUser, $dbPass, $dbName) {
        // Connect to the database
        $this->db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }

        // Create the table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS repos (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            repo_id INT(11) NOT NULL,
            name VARCHAR(255) NOT NULL,
            full_name VARCHAR(255) NOT NULL,
            description TEXT,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            owner_login VARCHAR(255) NOT NULL,
            owner_avatar_url TEXT NOT NULL,
            is_new TINYINT(1) NOT NULL DEFAULT 0
        )";
        if ($this->db->query($sql) === FALSE) {
            die("Error creating table: " . $this->db->error);
        }
    }

    public function queryAPIs() {
        // Query the specified APIs
        $urls = array(
            'https://api.github.com/users/PimpTrizkit/repos',
            'https://api.github.com/users/majimboo/repos'
        );
        foreach ($urls as $url) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
            $result = curl_exec($ch);
            curl_close($ch);

            // Save the data to the database
            if ($result !== FALSE) {
                $data = json_decode($result);
                foreach ($data as $repo) {
                    // Check if the repo already exists in the database
                    $stmt = $this->db->prepare("SELECT * FROM repos WHERE repo_id=?");
                    $stmt->bind_param("i", $repo->id);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->fetch() === NULL) {
                        // Insert the new repo into the database
                        $stmt = $this->db->prepare("INSERT INTO repos (repo_id, name, full_name, description, created_at, updated_at, owner_login, owner_avatar_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("isssssss", 
                            $repo->id,
                            $repo->name,
                            $repo->full_name,
                            $repo->description,
                            date('Y-m-d H:i:s', strtotime($repo->created_at)),
                            date('Y-m-d H:i:s', strtotime($repo->updated_at)),
                            $repo->owner->login,
                            $repo->owner->avatar_url
                        );
                        if ($stmt->execute() === FALSE) {
                            die("Error inserting repo: " . $stmt->error);
                        }
                    }
                }
            }
        }
    }

    public function setPerPage($perPage) {
        // Set the number of records per page
        if (is_numeric($perPage)) {
            $this->perPage = (int)$perPage;
        }
    }

    public function setPage($page) {
        // Set the current page number
        if (is_numeric($page)) {
            $this->page = (int)$page;
        }
    }

    public function setOwnerFilter($ownerFilter) {
        // Set the owner filter
        if (is_string($ownerFilter)) {
            $this->ownerFilter = trim($ownerFilter);
        }
    }

    public function setSortField($sortField) {
        // Set the sort field
        if (in_array($sortField, array('id', 'name', 'full_name', 'description', 'created_at', 'updated_at', 'owner_login'))) {
            $this->sortField = trim($sortField);
        }
    }

    public function setSortOrder($sortOrder) {
        // Set the sort order
        if (in_array(strtoupper($sortOrder), array('ASC', 'DESC'))) {
            $this->sortOrder = strtoupper($sortOrder);
        }
    }

    public function getRepos() {
        // Get the repos from the database
        $sql = "SELECT * FROM repos";
        if (!empty($this->ownerFilter)) {
            $sql .= " WHERE owner_login='" . $this->db->real_escape_string($this->ownerFilter) . "'";
        }
        $sql .= " ORDER BY " . $this->sortField . " " . $this->sortOrder;
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die("Error getting repos: " . $this->db->error);
        }

        // Calculate the total number of pages
        $this->totalPages = ceil($result->num_rows / $this->perPage);

        // Get the repos for the current page
        $start = ($this->page - 1) * $this->perPage;
        $sql .= " LIMIT " . $start . ", " . $this->perPage;
        $result = $this->db->query($sql);
        if ($result === FALSE) {
            die("Error getting repos: " . $this->db->error);
        }
        while ($row = $result->fetch_assoc()) {
            $this->repos[] = array(
                'id' => (int)$row['id'],
                'repo_id' => (int)$row['repo_id'],
                'name' => htmlspecialchars($row['name']),
                'full_name' => htmlspecialchars($row['full_name']),
                'description' => htmlspecialchars($row['description']),
                'created_at' => htmlspecialchars($row['created_at']),
                'updated_at' => htmlspecialchars($row['updated_at']),
                'owner_login' => htmlspecialchars($row['owner_login']),
                'owner_avatar_url' => htmlspecialchars($row['owner_avatar_url']),
                'is_new' => (bool)$row['is_new']
            );
        }
    }

    public function displayRepos() {
        // Display the repos in a paginated list
        echo '<table class="table table-striped">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Name</th>';
        echo '<th>Full Name</th>';
        echo '<th>Description</th>';
        echo '<th>Created At</th>';
        echo '<th>Updated At</th>';
        echo '<th>Owner Login</th>';
        echo '<th>Owner Avatar</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        foreach ($this->repos as $repo) {
            // Set the background color based on the owner login
            if ($repo['owner_login'] == 'PimpTrizkit') {
                $bgColor = '#f2dede';
            } else if ($repo['owner_login'] == 'majimboo') {
                $bgColor = '#d9edf7';
            } else {
                $bgColor = '#dff0d8';
            }

            // Display the repo data
            echo '<tr style="background-color:' . $bgColor . '">';
            echo '<td>' . $repo['id'] . '</td>';
            echo '<td>' . $repo['name'] . '</td>';
            echo '<td>' . $repo['full_name'] . '</td>';
            echo '<td>' . nl2br($repo['description']) . '</td>';
            echo '<td>' . date('Y-m-d H:i:s', strtotime($repo['created_at'])) . '</td>';
            echo '<td>' . date('Y-m-d H:i:s', strtotime($repo['updated_at'])) . '</td>';
            echo '<td>' . $repo['owner_login'] . '</td>';
            echo '<td><img src="' . $repo['owner_avatar_url'] . '" alt="' . htmlspecialchars($repo['owner_login']) . '" width="32" height="32"></td>';

            // Display edit and delete buttons for new records
            if ($repo['is_new']) {
                // Display an indicator for new records
                echo '<td><span class="label label-success">New</span></td>';

                // Display edit and delete buttons
                echo '<td><a href="?action=edit&id=' .
                    urlencode($repo['id']) .
                    '&page=' .
                    urlencode($this->page) .
                    '&perPage=' .
                    urlencode($this->perPage) .
                    '&ownerFilter=' .
                    urlencode($this->ownerFilter) .
                    '&sortField=' .
                    urlencode($this->sortField) .
                    '&sortOrder=' .
                    urlencode($this->sortOrder) .
                    '" class="btn btn-default">Edit</a> ';
                echo '<a href="?action=delete&id=' .
                    urlencode($repo['id']) .
                    '&page=' .
                    urlencode($this->page) .
                    '&perPage=' .
                    urlencode($this->perPage) .
                    '&ownerFilter=' .
                    urlencode($this->ownerFilter) .
                    '&sortField=' .
                    urlencode($this->sortField) .
                    '&sortOrder=' .
                    urlencode($this->sortOrder) .
                    '" class="btn btn-danger">Delete</a></td>';
            } else {
                echo '<td></td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';

        // Display pagination links
        if ($this->totalPages > 1) {
            for ($i = 1; $i <= $this->totalPages; ++$i) {
                if ($i == $this->page) {
                    echo '<span class="btn btn-default disabled">' . $i . '</span> ';
                } else {
                    echo '<a href="?page=' . urlencode($i) .
                        '&perPage=' . urlencode($this->perPage) .
                        '&ownerFilter=' . urlencode($this->ownerFilter) .
                        '&sortField=' . urlencode($this->sortField) .
                        '&sortOrder=' . urlencode($this->sortOrder) .
                        '" class="btn btn-default">' . $i . '</a> ';
                }
            }
        }

        // Display add new record form
        echo '<h3>Add New Record</h3>';
        echo '<form method="post" action="?action=add&page=' .
            urlencode($this->page) .
            '&perPage=' .
            urlencode($this->perPage) .
            '&ownerFilter=' .
            urlencode($this->ownerFilter) .
            '&sortField=' .
            urlencode($this->sortField) .
            '&sortOrder=' .
            urlencode($this->sortOrder) .
            '">';
            echo '<div class="form-group">';
            echo '<label for="name">Name:</label>';
            echo '<input type="text" class="form-control" name="name" id="name" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="full_name">Full Name:</label>';
            echo '<input type="text" class="form-control" name="full_name" id="full_name" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="description">Description:</label>';
            echo '<textarea class="form-control" name="description" id="description"></textarea>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="created_at">Created At:</label>';
            echo '<input type="datetime-local" class="form-control" name="created_at" id="created_at" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="updated_at">Updated At:</label>';
            echo '<input type="datetime-local" class="form-control" name="updated_at" id="updated_at" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="owner_login">Owner Login:</label>';
        echo '<input type="text" class="form-control" name="owner_login" id="owner_login" required>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '<label for="owner_avatar_url">Owner Avatar URL:</label>';
        echo '<input type="url" class="form-control" name="owner_avatar_url" id="owner_avatar_url" required>';
        echo '</div>';
        echo '<button type="submit" class="btn btn-primary">Add Record</button>';
        echo '</form>';

        // Display edit record form
        if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
            $stmt = $this->db->prepare("SELECT * FROM repos WHERE id=?");
            $stmt->bind_param("i", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                if ($row['is_new']) {
                    echo '<h3>Edit Record</h3>';
                    echo '<form method="post" action="?action=update&id=' .
                        urlencode($row['id']) .
                        '&page=' .
                        urlencode($this->page) .
                        '&perPage=' .
                        urlencode($this->perPage) .
                        '&ownerFilter=' .
                        urlencode($this->ownerFilter) .
                        '&sortField=' .
                        urlencode($this->sortField) .
                        '&sortOrder=' .
                        urlencode($this->sortOrder) .
                        '">';
                    echo '<div class="form-group">';
                    echo '<label for="name">Name:</label>';
                    echo '<input type="text" class="form-control" name="name" id="name" value="' . htmlspecialchars($row['name']) . '" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="full_name">Full Name:</label>';
                    echo '<input type="text" class="form-control" name="full_name" id="full_name" value="' . htmlspecialchars($row['full_name']) . '" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="description">Description:</label>';
                    echo '<textarea class="form-control" name="description" id="description">' . htmlspecialchars($row['description']) . '</textarea>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="created_at">Created At:</label>';
                    echo '<input type="datetime-local" class="form-control" name="created_at" id="created_at" value="' . date('Y-m-d\TH:i:s', strtotime($row['created_at'])) . '" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="updated_at">Updated At:</label>';
                    echo '<input type="datetime-local" class="form-control" name="updated_at" id="updated_at" value="' . date('Y-m-d\TH:i:s', strtotime($row['updated_at'])) . '" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="owner_login">Owner Login:</label>';
                    echo '<input type="text" class="form-control" name="owner_login" id="owner_login" value="' . htmlspecialchars($row['owner_login']) . '" required>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<label for="owner_avatar_url">Owner Avatar URL:</label>';
                    echo '<input type="url" class="form-control" name="owner_avatar_url" id="owner_avatar_url" value="' . htmlspecialchars($row['owner_avatar_url']) . '" required>';
                    echo '</div>';
                    echo '<button type="submit" class="btn btn-primary">Update Record</button> ';
                    echo '<a href="?page=' .
                        urlencode($this->page) .
                        '&perPage=' .
                        urlencode($this->perPage) .
                        '&ownerFilter=' .
                        urlencode($this->ownerFilter) .
                        '&sortField=' .
                        urlencode($this->sortField) .
                        '&sortOrder=' .
                        urlencode($this->sortOrder) .
                        '" class="btn btn-default">Cancel</a>';
                    echo '</form>';
                }
            }
        }
    }

    public function addRepo($name, $full_name, $description, $created_at, $updated_at, $owner_login, $owner_avatar_url) {
        // Add a new repo to the database
        $stmt = $this->db->prepare("INSERT INTO repos (name, full_name, description, created_at, updated_at, owner_login, owner_avatar_url, is_new) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("sssssss", 
            $name,
            $full_name,
            $description,
            $created_at,
            $updated_at,
            $owner_login,
            $owner_avatar_url
        );
        if ($stmt->execute() === FALSE) {
            die("Error inserting repo: " . $stmt->error);
        }
    }

    public function editRepo($id, $name, $full_name, $description, $created_at, $updated_at, $owner_login, $owner_avatar_url) {
        // Edit an existing repo in the database
        $stmt = $this->db->prepare("UPDATE repos SET name=?, full_name=?, description=?, created_at=?, updated_at=?, owner_login=?, owner_avatar_url=? WHERE id=?");
        $stmt->bind_param("sssssssi", 
            $name,
            $full_name,
            $description,
            date('Y-m-d H:i:s', strtotime($created_at)),
            date('Y-m-d H:i:s', strtotime($updated_at)),
            $owner_login,
            $owner_avatar_url,
            (int)$id
        );
        if ($stmt->execute() === FALSE) {
            die("Error updating repo: " . $stmt->error);
        }
    }

    public function deleteRepo($id) {
        // Delete an existing repo from the database
        $stmt = $this->db->prepare("DELETE FROM repos WHERE id=?");
        $id = (int)$id;
        $stmt->bind_param("i", $id);
        if ($stmt->execute() === FALSE) {
            die("Error deleting repo: " . $stmt->error);
        }
    }
}

    // Set the database connection details
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'repositories';

    // Create a new instance of the GitHubRepos class
    $ghRepos = new GitHubRepos($dbHost, $dbUser, $dbPass, $dbName);

    // Handle form submissions
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'add' && isset($_POST['name'])) {
            // Add a new repo to the database
            $ghRepos->addRepo(
                $_POST['name'],
                $_POST['full_name'],
                $_POST['description'],
                $_POST['created_at'],
                $_POST['updated_at'],
                $_POST['owner_login'],
                $_POST['owner_avatar_url']
            );
        } else if ($_GET['action'] == 'update' && isset($_GET['id']) && isset($_POST['name'])) {
            // Update an existing repo in the database
            $ghRepos->editRepo(
                $_GET['id'],
                $_POST['name'],
                $_POST['full_name'],
                $_POST['description'],
                $_POST['created_at'],
                $_POST['updated_at'],
                $_POST['owner_login'],
                $_POST['owner_avatar_url']
            );
        } else if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
            // Delete an existing repo from the database
            $ghRepos->deleteRepo($_GET['id']);
        }
    }

    // Query the specified APIs and save the data to the database
    $ghRepos->queryAPIs();

    // Set the number of records per page
    if (isset($_GET['perPage'])) {
        $ghRepos->setPerPage($_GET['perPage']);
    }

    // Set the current page number
    if (isset($_GET['page'])) {
        $ghRepos->setPage($_GET['page']);
    }

    // Set the owner filter
    if (isset($_GET['ownerFilter'])) {
        $ghRepos->setOwnerFilter($_GET['ownerFilter']);
    }

    // Set the sort field and order
    if (isset($_GET['sortField'])) {
        $ghRepos->setSortField($_GET['sortField']);
    }
    if (isset($_GET['sortOrder'])) {
        $ghRepos->setSortOrder($_GET['sortOrder']);
    }

    // Get the repos from the database
    $ghRepos->getRepos();

    // Display the repos in a paginated list
    $ghRepos->displayRepos();
?>