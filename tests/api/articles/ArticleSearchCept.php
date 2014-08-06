<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 06/08/14
 * Time: 19:08
 */

$specialWord = uniqid();


$body  = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. '.$specialWord.' .Ut in dolor sed neque auctor rutrum. Fusce vestibulum bibendum eros vel dapibus. Vestibulum erat tortor, venenatis vel porttitor ut, fermentum eu ligula. Cras feugiat, lorem eu feugiat viverra, eros arcu viverra metus, a tincidunt eros dui quis nisl. Proin mollis faucibus metus, aliquet tincidunt orci pellentesque sit amet. Nam eleifend nunc eget leo porttitor, ac ullamcorper risus adipiscing. Phasellus eros diam, varius quis metus quis, molestie euismod arcu. Mauris scelerisque faucibus enim consequat bibendum. Aliquam suscipit auctor lacus sed sollicitudin. In quis odio nec ante luctus fringilla vitae varius diam. Mauris et tortor mi. Mauris id arcu eleifend, pretium neque in, consectetur lectus. Vestibulum luctus dapibus eros ornare laoreet.';
$title = 'Lorem ipsum dolor sit amet '.rand(1, 100000);

$I = new Ninja($scenario);
$I->wantTo('Create an article');
$I->call('articles', 'POST', array(
    'author_id'   => 1,
    'category_id' => 1,
    'title'       => $title,
    'url'         => 'http://lahaxe.fr',
    'slug'        => 'search-' . rand(),
    'indexable'   => $body,
    'body'        => $body,
), 201);

$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);
});

sleep(2);

$I->wantTo('I search the word ' . $specialWord);
$I->call('articles/search', 'GET', array(
    'query' => $specialWord
));
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) use ($title){
    $api->isType('result', 'ARRAY', $response);
    $api->isEquals('result', count($response), 1);
    $result = current($response);
    $api->isEquals('title', $result['title'], $title);
});


