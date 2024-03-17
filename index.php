<?php

use App\Post;
use App\EventDispatcher as EventDispatcherMock;
use App\Transitions\Publish;
use App\Transitions\Reject;
use App\Transitions\Start;
use App\Transitions\ToReview;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\TransitionBlocker;
use Symfony\Component\Workflow\Workflow;

include './vendor/autoload.php';

// $places = ['new', 'review', 'approved', 'declined'];
$places = ['new', 'draft', 'reviewed', 'rejected', 'published'];
$transitions = [];
$transitions[] = new Transition('start', 'new', 'draft');
$transitions[] = new Transition('to_review', 'draft', 'reviewed');
$transitions[] = new Transition('publish', 'reviewed', 'published');
$transitions[] = new Transition('reject', 'reviewed', 'rejected');
$definition = new Definition($places, $transitions);

$marking = new MethodMarkingStore(true, 'status');

$dispatcher = new EventDispatcher();
$dispatcher->addListener('workflow.post.transition.start', new Start);
$dispatcher->addListener('workflow.post.transition.to_review', new ToReview);
$dispatcher->addListener('workflow.post.transition.publish', new Publish);
$dispatcher->addListener('workflow.post.transition.reject', new Reject);

$workflow = new Workflow($definition, $marking, $dispatcher, 'post');

// FLOW 
$flow = ['start', 'to_review', 'reject', 'publish'];

// foreach (range(1, 10) as $index) {
    $post = new Post(1);
    $index = 1;
    echo "Index $index \n";

    foreach ($flow as $transition) {
        if ($workflow->can($post, $transition)) {
            $workflow->apply($post, $transition);
            echo "Can $transition" . PHP_EOL;

            sleep(2);
        } else {
            sleep(5);
            echo "Not can $transition" . PHP_EOL;
        }
    }

    $_post = new Post(1);
    echo $_post->toJson() . PHP_EOL;

    // $post->setstatus('new');
    // $post->update();
// }