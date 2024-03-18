<?php

namespace App\Models;

use App\Traits\DB;

class Workflow
{
    use DB;

    protected $table = 'workflows';

    public $id;

    public $name;

    public $status;

    public $subject_class;

    public $subject_id;

    protected $fillable = [
        'name',
        'status',
        'subject_class',
        'subject_id'
    ];

    /**
     * @return array
     */
    public function getAttributes()
    {
        return array_merge(['id'], $this->fillable);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'subject_class' => $this->subject_class,
            'subject_id' => $this->subject_id,
        ];
    }

    /**
     * @param string $transition
     * 
     * @return string
     */
    public function getUrlTransition(string $transition)
    {
        return "/workflows/{$this->id}/transitions/$transition";
    }

    /**
     * @param int $id
     * 
     * @return Workflow
     */
    public function load($id)
    {
        $workflow = $this->find($id);
        $subject = new $workflow->subject_class;
        $customWorkflow = $subject->workflow;
        return (new $customWorkflow)->makeInstance($workflow->toArray())->template();
    }

    /**
     * @return array
     */
    public function getAvaiableTransitions()
    {
        $transitions = $this->getWorkflow()->getEnabledTransitions($this, $this->status);
        if ($transitions) {
            return array_map(function ($transition) {
                return $transition->getName();
            }, $transitions);
        }
        return [];
    }

    /**
     * @param string
     */
    public function statusFormat()
    {
        $map = [
            'pending' => 'Aguardando',
            'confirmed' => 'Confirmado',
            'completed' => 'Completo',
            'invalidated' => 'Invalido'
        ];
        return $map[$this->status];
    }

    public function subject_classFormat()
    {
        $subject = $this->loadSubject();
        return $subject->email;
    }
}