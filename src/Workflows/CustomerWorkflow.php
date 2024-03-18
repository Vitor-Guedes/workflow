<?php

namespace App\Workflows;

use App\Models\Workflow;
use App\Workflows\Listeners\OnHold;
use App\Workflows\Listeners\Confirm;
use App\Workflows\Listeners\Complete;
use App\Workflows\Listeners\Invalidate;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Workflow\Workflow as WorkflowWorkflow;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;

class CustomerWorkflow extends Workflow
{
    protected $subject;
    
    protected $transition;

    protected $workflow;

    public $labels = [
        'confirm' => 'Confirmar',
        'invalidate' => 'Invalidar',
        'complete' => 'Completar'
    ];

    protected $listeners = [
        'workflow.customer.transition.on_hold' => OnHold::class,
        'workflow.customer.transition.confirm' => Confirm::class,
        'workflow.customer.transition.invalidate' => Invalidate::class,
        'workflow.customer.transition.complete' => Complete::class
    ];

    public $flow = [
        'on_hold',
        'confirm',
        'invalidate',
        'complete'
    ];

    public function __construct($subject = null, $transition = null)
    {
        if ($subject) {
            $this->setSubject($subject);
        }

        if ($transition) {
            $this->setTransition($transition);
        }
    }

    /**
     * @param 
     * 
     * @return $this
     */
    public function setWorkflow($workflow)
    {
        $this->workflow = $workflow;
        return $this;
    }

    /**
     * @return 
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * @param object $subject
     * 
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return object
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $transition
     * 
     * @return $this
     */
    public function setTransition(string $transition)
    {
        $this->transition = $transition;
        return $this;
    }

    /**
     * @return string 
     */
    public function getTransition()
    {
        return $this->transition;
    }

    /**
     * @return void
     */
    public function create()
    {
        $this->template();

        $this->name = 'customer';
        $this->status = 'new';
        $this->subject_class = get_class($this->getSubject());
        $this->subject_id = $this->getSubject()->id;

        $this->getWorkflow()->apply($this, $this->getTransition());

        $this->save();
    }

    /**
     * @return $this
     */
    public function template()
    {
        $places = ['new', 'pending', 'confirmed', 'completed', 'invalidated'];
        
        $transitions = [];
        $transitions[] = new Transition('on_hold', 'new', 'pending');
        $transitions[] = new Transition('confirm', 'pending', 'confirmed');
        $transitions[] = new Transition('invalidate', 'pending', 'invalidated');
        $transitions[] = new Transition('complete', 'confirmed', 'completed');
        $transitions[] = new Transition('complete', 'invalidated', 'completed');
        $definition = new Definition($places, $transitions);

        $marking = new MethodMarkingStore(true, 'status');
        $dispatcher = new EventDispatcher();

        foreach ($this->listeners as $event => $listener) {
            $dispatcher->addListener($event, is_callable($listener) ? $listener : new $listener);
        }

        $this->setWorkflow(new WorkflowWorkflow($definition, $marking, $dispatcher, 'customer'));

        return $this;
    }

    /**
     * @return void
     */
    public function save()
    {
        parent::save();
    }

    /**
     * @param string $transition
     * 
     * @return bool
     */
    public function can(string $transition)
    {
        return $this->getWorkflow()->can($this, $transition);
    }

    /**
     * @param string $transition
     * 
     * @return mixed
     */
    public function apply(string $transition)
    {
        return $this->getWorkflow()->apply($this, $transition);
    }

    /**
     * 
     * @return object
     */
    public function loadSubject()
    {
        return (new $this->subject_class)->find($this->subject_id);
    }
}