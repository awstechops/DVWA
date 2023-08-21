<?php
define('DVWA_WEB_PAGE_TO_ROOT', '');
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

dvwaPageStartup(array('authenticated'));

// Database configuration
define('DB_HOST', 'localhost'); // Replace 'localhost' with your MariaDB host
define('DB_USER', 'dvwa'); // Replace 'admin' with your MariaDB username
define('DB_PASSWORD', 'p@ssw0rd'); // Replace 'P@ssword1' with your MariaDB password
define('DB_NAME', 'dvwa'); // Replace 'your_database_name' with your database name (e.g., DVWA)

// Function to establish a database connection
function dbConnect()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to retrieve user account information from the 'users' table
function getUserAccounts()
{
    $conn = dbConnect();
    $sql = "SELECT first_name, checking_account_type, checking_account_number, checking_account_balance,
                   savings_account_type, savings_account_number, savings_account_balance
            FROM users
            WHERE user_id = 1"; // Replace '1' with the appropriate user_id

    $result = $conn->query($sql);
    $userData = $result->fetch_assoc();
    $conn->close();
    return $userData;
}

$page = dvwaPageNewGrab();
$page['title'] = 'Welcome' . $page['title_separator'] . $page['title'];
$page['page_id'] = 'home';

$userData = getUserAccounts();

$page['body'] .= "
<div class=\"body_padded\">
    <style>
        /* CSS Changes Start */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
        }

        .dashboard {
            background-color: #fff;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            color: #0f8231; /* Green color for 'Welcome' */
        }

        .balance {
            text-align: center;
            margin-bottom: 30px;
        }

        .balance h2 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #0f8231; /* Green color for 'Account Balance' */
        }

        .balance p {
            font-size: 18px;
            margin: 0;
            color: #888;
        }

        .account-table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        .account-table th,
        .account-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .account-table th {
            background-color: #0f8231; /* Green color for table header */
            color: #fff; /* Text color for table header */
            font-weight: bold;
        }

        .account-table td {
            text-align: center;
        }

        .dashboard-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            color: #007bff;
        }

        /* CSS Changes End */
    </style>

    <div class=\"dashboard\">
        <h1>Welcome</h1>

        <div class=\"balance\">
            <h2 style=\"color: #0f8231;\">Account Balance</h2>
            <p>Total Balance: $ " . number_format($userData['checking_account_balance'] + $userData['savings_account_balance'], 2) . "</p>
        </div>

        <table class=\"account-table\">
            <tr>
                <th style=\"background-color: #0f8231; color: #fff;\">Account Type</th>
                <th style=\"background-color: #0f8231; color: #fff;\">Account Number</th>
                <th style=\"background-color: #0f8231; color: #fff;\">Balance</th>
            </tr>
            <tr>
                <td>{$userData['checking_account_type']}</td>
                <td>{$userData['checking_account_number']}</td>
                <td>$ " . number_format($userData['checking_account_balance'], 2) . "</td>
            </tr>
            <tr>
                <td>{$userData['savings_account_type']}</td>
                <td>{$userData['savings_account_number']}</td>
                <td>$ " . number_format($userData['savings_account_balance'], 2) . "</td>
            </tr>
        </table>

        <a href=\"#\" class=\"dashboard-link\">View Transaction History</a>
    </div>
</div>";

dvwaHtmlEcho($page);
?>