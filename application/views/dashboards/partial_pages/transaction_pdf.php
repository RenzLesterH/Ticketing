<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction No. <?= $client_transaction[0]['transaction_code'] ?></title>
</head>
<body>
    <?php
        $client_name = $client_transaction[0]['firstname'] . " " . $client_transaction[0]['middlename'] . " " . $client_transaction[0]['lastname'];
        $received_by = json_decode($client_transaction[0]['received_at']);
        $transaction_status_at = json_decode($client_transaction[0]['received_at']);
    ?>
    <header>
        <h1>Office of the Municipal Assesors</h1>
        <h2>Municipality of Tagudin</h2>
    </header>
    <section>
        <div id="trasaction_info">
            <h3>Transaction by:</h3>
            <label>Name: <?= $client_name  ?></label>
            <br><label>Transaction Monitoring form No: <b><?= $client_transaction[0]['transaction_code'] ?></b></label>
            <br><label>Contact Number: <?= $client_transaction[0]['contacts'] ?></label>
        </div>
        <div id="received_info">
            <h3>Received Info</h3>
            <label>For Approval: <input type="checkbox"></label> 
            <br><label>Date: </label>
            <br><label>Claim by: </label>
            <br><label>Date: </label>
        </div>
        <table> 
            <tbody>
                <tr>
                    <td style="width: 150px;">Received</td>
                    <td>Date:</td>
                    <td style="border: none; width: 20px;"></td>
                    <td style="padding-top: 0px;">Lacking/Corrective Action:</td>
                </tr>
                <tr>
                    <td style="width: 150px;">Prepared</td>
                    <td>Date:</td>
                    <td style="border: none; width: 20px;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 150px;">Verified</td>
                    <td>Date:</td>
                    <td style="border: none; width: 20px;"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </section>
    <main>
        <h3>Office of the Municipal Assesors - Tagudin</h3>
        <div>
            <label>Date: <?= date("F j, Y", strtotime($transaction_status_at[1])); ?></label>
            <br><label>Transaction No: <b><?= $client_transaction[0]['transaction_code'] ?></b></label>
            <br><label>Name: <?= $client_name  ?></label>
        </div>
        <div id="info_2"> 
            <label>Transaction: <?= $client_transaction[0]['transaction'] ?> </label>
            <br><label>Received by: <?= $received_by[0] ?></label>
        </div>
    </main>
</body>
</html>