<?php
require_once '../../boot.php';

header('Content-Type: application/json');

$resp = array();
if (isset($_REQUEST['order']) && isset($_REQUEST['test'])) {
    $order = explode("-", $_REQUEST['order']);
    $test_id = intval($_REQUEST['test']);

    if (!empty($order)) {
        $exec = true;
        // save order
        foreach($order as $numquestion => $idquestion) {
            $question = new Question(intval($idquestion));
            $question->order = $numquestion+1;
            $exec &= $question->save();
            var_dump($exec);var_dump($question->order);

            unset($question);
        }
        $resp['exec']= $exec;
    }
} else {
    $resp['exec']= false;
}
var_dump($resp);

echo json_encode($resp);