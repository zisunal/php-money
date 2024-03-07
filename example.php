<?php
//This are examples of using Money Class
require_once 'vendor/autoload.php';
use Zisunal\Money;

date_default_timezone_set('Asia/Dhaka');

$taka = new Money('Bangladeshi Taka', 'BDT', '৳', 0.0091);
$taka->add_transaction(500, true) . "<br>";
$taka->add_transaction(300, false) . "<br>";
$taka->add_transaction(300, false) . "<br>";

$rupee = new Money('Indian Rupee', 'INR', '₹', 0.012);
$rupee->add_transaction(500, true) . "<br>";
$rupee->add_transaction(300, false) . "<br>";
$rupee->add_transaction(100, true) . "<br>";
$rupee->add_transaction(300, false) . "<br>";
$rupee->add_transaction(100, true) . "<br>";

$sl_rupee = new Money('Sri Lankan Rupee', 'LKR', 'Rs', 0.0033);
$sl_rupee->add_transaction(500, true) . "<br>";
$sl_rupee->add_transaction(300, false) . "<br>";
$sl_rupee->add_transaction(300, false) . "<br>";

$dirham = new Money('UAE dirham', 'AED', 'Dh', 0.27);
$dirham->add_transaction(500, true) . "<br>";
$dirham->add_transaction(300, false) . "<br>";
$dirham->add_transaction(175, true) . "<br>";

$riyal = new Money('Qatari Riyal', 'QAR', 'QR', 0.27);
$riyal->add_transaction(500, true) . "<br>";
$riyal->add_transaction(265, false) . "<br>";
$riyal->add_transaction(175, true) . "<br>";

$my_accounts = [
    $taka,
    $rupee,
    $sl_rupee,
    $dirham,
    $riyal
];

foreach ($my_accounts as $account) {
    echo "<h3>Transaction History of " . $account->get_iso() . " account: </h3>";
    $histories = $account->get_transactions();
    ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #000;
            color: #fff;
        }
    </style>
    <table>
        <thead>
            <tr>
                <th>Trx ID</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($histories as $history) {
        ?>
            <tr>
                <td><?php echo $history['id']; ?></td>
                <td><?php echo $history['amount']; ?></td>
                <td><?php echo ucfirst($history['type']); ?></td>
                <td><?php echo date('M d, Y @ h:i A', strtotime($history['date'])); ?></td>
            </tr>
        <?php 
        } 
        ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Balance</th>
                <td colspan="3"><?php echo $account->balance() . " " . $account->get_symbol(); ?></td>
            </tr>
        </tfoot>
    </table>
    <hr>
<?php
}
foreach ($my_accounts as $account) {
    $balance = 0;
    foreach ($my_accounts as $acc) {
        $balance += $acc->convert_to($account, $acc->balance());
    }
?>
<h4>Total Balance converts in <?= $account->get_name() ?>: <?= $balance . ' ' . $account->get_symbol() ?></h4>
<?php
}
?>