<?php
require_once APPPATH . "third_party/api_init.php";
global $apiConfig;
global $client;

class Demo extends CI_Controller {
    public function index(){
            global $client;
            global $plus;
                $session_token = $this->session->userdata('token');
                if (isset($session_token)) {
                        $client->setAccessToken($session_token);
                        if($client->getAccessToken()){
                           $me = $plus->people->get('me');
                            
                           $url = filter_var($me->url, FILTER_VALIDATE_URL);
                            $img = filter_var($me->image->url, FILTER_VALIDATE_URL);
                            $name = filter_var($me->displayName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                            $personMarkup = "<a rel='me' href='$url'>$name</a><div><img src='$img'></div>";
                            
                            $optParams = array('maxResults' => 100);
                            $activities = $plus->activities->listActivities('me', 'public', $optParams);
                            $activityMarkup = '';
                            
                            foreach($activities->items as $activity) {
                                // These fields are currently filtered through the PHP sanitize filters.
                                // See http://www.php.net/manual/en/filter.filters.sanitize.php
                                $url = filter_var($activity->url, FILTER_VALIDATE_URL);
                                $title = filter_var($activity->title, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                                $content = filter_var($activity->object->content, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                                $activityMarkup .= "<div class='activity'><a href='$url'>$title</a><div>$content</div></div>";
                              }
                            
                              
                              if(isset($personMarkup)){
                                echo '<div class="me">'.$personMarkup.'</div>';
                               }
                               
                             if(isset($activityMarkup)){
                                echo '<div class="activities">Your Activities: '.$activityMarkup.'</div>';
                            }
                        }
//                        $v_data['layout'] = 'dashboard_v';
//                        $this->load->view('layout/layout', $v_data);
                }
            }
}