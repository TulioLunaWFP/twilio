<?php
                    
                    use Twilio\Rest\Client;
                    $sid='ACc5ef012c3dc524648c786fa493ab7633';
                    $token ='2e899684e160e6aa0afc9ce9a1b49164';
                    $client = new Client($sid,$token);
                    $people = [];
                        foreach($customers as $customer)
                        {
                          $people[] = array(
                            'full_name' => $user['FirstName'].' '. $user['LastName'],
                            'phone_no' => $user['CellularPhone'],
                          );
                        }


                        foreach ($people as $one) {

                            $name = $one['full_name'];
                            $phone = $one['phone_no'];

                            $sms = $client->account->messages->create(
                                $phone,

                                array(
                                    'from' => "14099084850", 
                                    'body' => "Hello $name, this is alert cityhall!",
                                    "mediaUrl" => array("https://c1.staticflickr.com/3/2899/14341091933_1e92e62d12_b.jpg")
                                )
                            );
                            echo "Sent message to $name";
                         }



                    
                    
                    ?>
