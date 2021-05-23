<?php
require_once '../../boot.php';

header('Content-Type: application/json');

$resp = array();
if (isset($_REQUEST['testid']) && isset($_REQUEST['testid'])) {
    $test = new Test(intval($_REQUEST['testid']));
    if ($test->id >0) {
        $resp['status']= true;
        $test->date_start = date('d.m.y', $test->stamp_start);
        $test->date_end = date('d.m.y', $test->stamp_end);
        $resp['test']= $test;

        $resp['geo']['country_code'] = 'FRDEP';
        $resp['geo']['country_name'] = 'France';
        $resp['geo']['dep'] = [];

        $questions = Question::getStackTest($test->id, false);
        $nbquestions = sizeof($questions);

        $participants = Participation::getStack($test->id);
        $nbparticipants = sizeof($participants);

        $codes = Code::getStackTest($test->id);
        $nbcodes = sizeof($codes);

        $nbdrop = 0;
        $nbpipi = 0;
        $nbjecraque = 0;
        $nbh = $nbf = $nbnan = 0;
        $nb0 = $nb015 = $nb1525 = $nb2535 = $nb3545 = $nb45100 = 0;

        if ($participants && !empty($participants)) {
            $resp['nbparticipants'] = $nbparticipants;

            foreach($participants as $participant) {
                // number of participant by day
                $day = date('d-m-Y', $participant['stamp']);
                $partbyday[$day] = (!isset($partbyday[$day]) ) ? 1 : $partbyday[$day] + 1;

                // genre by pourcent
                $user = new User($participant['user_id']);
                if ($user && $user->genre == User::Genre_H) $nbh++; else if ($user && $user->genre == User::Genre_F) $nbf++; else $nbnan++;

                // age range
                if ($user && $user->age == 0) $nb0++;
                else if ($user && $user->age > 15 && $user->age <= 25) $nb1525++;
                else if ($user && $user->age > 0 && $user->age <= 15) $nb1525++;
                else if ($user && $user->age > 25 && $user->age <= 35) $nb2535++;
                else if ($user && $user->age > 35 && $user->age <= 45) $nb3545++;
                else if ($user && $user->age > 45) $nb45100++;

                // geoloc dep of the user
                if (($user && $user->dep > 0)) {
                    if ($user->dep == '2A') $user->dep = 96; // temporarly
                    else if ($user->dep == '2B') $user->dep = 20;

                    $geoloc[$user->dep] = (isset($geoloc[$user->dep])) ? ($geoloc[$user->dep] + 1) : 1;
                }
                
                // drop rate
                $responses = Response::getStack($participant['id']);
                $nbresponses = sizeof($responses);
                if ($nbresponses < $nbquestions) $nbdrop++;

                // pipi rate
                if ($participant['pause'] == 1) $nbpipi++;

                // jecraque + time by response + answers
                if ($nbresponses >0) {
                    foreach ($responses as $response) {
                        if ($response['jecraque'] == 1) {
                            $nbjecraque++;
                            $jecraquebyq[$response['question_id']] = (isset($jecraquebyq[$response['question_id']])) ? $jecraquebyq[$response['question_id']] + 1 : 1;
                        }

                        $timeanswerbyq[$response['question_id']] = (isset($timeanswerbyq[$response['question_id']])) ? $timeanswerbyq[$response['question_id']] + $response['time'] : $response['time'];

                        if ($response['choice_id'] > 0) {
                            $answers[$response['question_id']][$response['choice_id']] = (isset($answers[$response['question_id']][$response['choice_id']])) ? ($answers[$response['question_id']][$response['choice_id']] + 1) : 1;
                        } else if ($response['response'] != '') {
                            $answers[$response['question_id']][$response['response']] = (isset($answers[$response['question_id']][$response['response']])) ? ($answers[$response['question_id']][$response['response']]+1) : 1;
                        }
                    }
                }
                unset($nbresponses);
            }

            // set results
            if (!empty($partbyday)) {
                $idx = 0;
                for ($stamp = $test->stamp_start; $stamp <= $test->stamp_end; $stamp += 86400) {
                    $daystr = date('d-m-Y', $stamp);
                    $resp['partbyday'][$idx]['day'] = $daystr;
                    $resp['partbyday'][$idx]['nbparticipants'] = (isset($partbyday[$daystr])) ? $partbyday[$daystr] : 0;
                    $idx++;
                }
            } else {
                $resp['partbyday'] = [];
            }
            $resp['droprate'] = ($nbdrop > 0) ? round(($nbdrop / $nbparticipants)*100) : 0;

            $resp['pipirate'] = ($nbpipi > 0) ? round(($nbpipi / $nbparticipants)*100) : 0;

            // time to answer
            $idx = 0;
            $resp['choices'][0] = 'noanswer';
            $resp['labels'][0] = 'Pas de réponse';
            $typechoices = array(2,3,4); // Bof/Sympa - Déteste/Adore - Oui/Non
            foreach ($questions as $question) {
                $resp['jecraquebyq'][$idx]['jecraquequestion'] = $question['text'];//$question['text'];
                $resp['jecraquebyq'][$idx]['nbjecraque'] = (isset($jecraquebyq[$question['id']])) ? $jecraquebyq[$question['id']] : 0;

                $resp['timeanswerbyq'][$idx]['question'] = $question['text'];//$question['text'];
                $resp['timeanswerbyq'][$idx]['timesec'] = (isset($timeanswerbyq[$question['id']])) ? round(($timeanswerbyq[$question['id']] / $nbparticipants),2) : 0;

                $resp['questions'][$question['id']] = $question['text'];

                if (isset($answers[$question['id']])) {
                    //$resp['answers'][$question['id']] = $answers[$question['id']];
                    $noanswerrate = 100;
                    foreach($answers[$question['id']] as $answerresponse => $nbanswers) {
                        $rate = ($nbanswers > 0) ? round(($nbanswers / $nbparticipants)*100) : 0;
                        $noanswerrate -= $rate;

                        if (!in_array($answerresponse, $resp['choices'])) {
                            if (!in_array($question['type_id'], $typechoices)) { // answer typed by user (ABCD, calc, ...)
                                if ($question['type_id'] == 6 || $question['type_id'] == 7) { // A ou B - A ou b ou C ou D
                                    $resp['choices'][] = $idx.$answerresponse;
                                    $resp['labels'][] = (!empty($question['choice'.strtolower(trim($answerresponse))])) ? $question['choice'.strtolower(trim($answerresponse))].' ' : $answerresponse.' ';
                                    $resp['answers'][$idx][$idx.$answerresponse] = $rate;
                                } else {
                                    $resp['choices'][] = $answerresponse;
                                    $resp['labels'][] = $answerresponse.' ';
                                    $resp['answers'][$idx][$answerresponse] = $rate;
                                }
                            } else { // answer prédéfinie
                                $choice = new Choice(intval($answerresponse));
                                $resp['choices'][] = $answerresponse;
                                $resp['labels'][] = $choice->text.' ';
                                $resp['answers'][$idx][$answerresponse] = $rate;
                            }
                        }
                    }
                    $resp['answers'][$idx]['noanswer'] = $noanswerrate;
                    $resp['answers'][$idx]['y'] = $question['text'];
                }

                $idx++;
            }

            $resp['genre'][User::Genre_H] = ($nbh > 0) ? round(($nbh / $nbparticipants)*100) : 0;
            $resp['genre'][User::Genre_F] = ($nbf > 0) ? round(($nbf / $nbparticipants)*100) : 0;
            $resp['genre'][User::Genre_Nan] = ($nbnan > 0) ? round(($nbnan / $nbparticipants)*100) : 0;

            $resp['age']['nan'] = ($nb0 > 0) ? round(($nb0 / $nbparticipants)*100) : 0;
            $resp['age']['0-15'] = ($nb015 > 0) ? round(($nb015 / $nbparticipants)*100) : 0;
            $resp['age']['15-25'] = ($nb1525 > 0) ? round(($nb1525 / $nbparticipants)*100) : 0;
            $resp['age']['25-35'] = ($nb2535 > 0) ? round(($nb2535 / $nbparticipants)*100) : 0;
            $resp['age']['35-45'] = ($nb3545 > 0) ? round(($nb3545 / $nbparticipants)*100) : 0;
            $resp['age']['45-100'] = ($nb45100 > 0) ? round(($nb45100 / $nbparticipants)*100) : 0;

            for ($dep = 1; $dep <= 96; $dep++) {
                if ($dep == 96) $idx = 19;
                else if ($dep == 20) $idx = 20;
                else if ($dep >= 21) $idx = $dep;
                else if ($dep <= 19) $idx = $dep-1;

                $resp['geo']['dep'][$idx] = (isset($geoloc[$dep])) ? $geoloc[$dep] : 0;
            }

        } else {
            $resp['nbparticipants'] = 0;
        }
        $resp['nbcodes'] = $nbcodes;
        $resp['jecraque'] = $nbjecraque;

    } else {
        $resp['status']= false;
    }
} else {
    $resp['status']= false;
}

echo json_encode($resp);