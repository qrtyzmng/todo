<?php

namespace App\Controller;

use App\Command\AddTaskCommand;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskFormType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Query\TaskQuery;

class TaskController extends BaseController {
    
    /**
     * @Route("/task", name="task_index")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        return $this->render(
            'task/index.html.twig'
        );
    }
    
    /**
     * @Route("/task/add", name="task_add")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function add(Request $request): Response
    {
        $form = $this->createForm(TaskFormType::class);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $taskCommand = new AddTaskCommand(
                $data[TaskFormType::NAME]  
            );

            $this->handleMessage($taskCommand);
 
        }

        return $this->render(
            'task/add.html.twig',
            ['form' => $form->createView()]
        );
    }
    
    /**
     * @Route("/task/show/{id}", name="task_show", requirements={"id":"\d+"})
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        $taskQuery = new TaskQuery($id);

        $task = $this->handleMessage($taskQuery);

        return $this->render(
            'task/show.html.twig',
            ['task' => $task]
        );
    }
}
