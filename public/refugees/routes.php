<?php
  function call($controller, $action) {
    // require the file that matches the controller name
    require_once('controllers/' . $controller . '_controller.php');

    // create a new instance of the needed controller
    switch($controller) {
      case 'pages':
        $controller = new PagesController();
        break;
      case 'questions':
        $controller = new QuestionsController();
        break;
      case 'topic':
        $controller = new TopicController();
        break;
   
    }

    // call the action
    $controller->{ $action }();
  }

  // just a list of the controllers we have and their actions
  // we consider those "allowed" values
  $controllers = array('pages' => ['home', 'error'],
                      'questions' => ['access', 'add'],
                      'topic' => ['read']
                      );

  // check that the requested controller and action are both allowed
  // if someone tries to access something else he will be redirected to the error action of the pages controller
  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
//http://api.ipinfodb.com/v3/ip-city/?key=d3538c354ba668e3937fa471bb1dfd0eb50a5df91bc625b706298622fcbc80ac&ip=74.125.45.100
?>
