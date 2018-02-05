<?php

namespace ARK\Form\Extension\DataCollector;

use Symfony\Component\Form\Extension\DataCollector\FormDataCollectorInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class FormDataCollector extends DataCollector implements FormDataCollectorInterface
{
    public function collect(Request $request, Response $response, \Exception $exception = null) : void
    {
        $this->reset();
    }

    public function reset() : void
    {
        $this->data = [
            'forms' => [],
            'forms_by_hash' => [],
            'nb_errors' => 0,
        ];
    }

    public function associateFormWithView(FormInterface $form, FormView $view) : void
    {
    }

    public function collectConfiguration(FormInterface $form) : void
    {
    }

    public function collectDefaultData(FormInterface $form) : void
    {
    }

    public function collectSubmittedData(FormInterface $form) : void
    {
    }

    public function collectViewVariables(FormView $view) : void
    {
    }

    public function buildPreliminaryFormTree(FormInterface $form) : void
    {
    }

    public function buildFinalFormTree(FormInterface $form, FormView $view) : void
    {
    }

    public function getName()
    {
        return 'form';
    }

    public function getData()
    {
        return $this->data;
    }
}
