<?php

namespace App\Controller;

use App\Command\AddTaskCommand;
use App\Command\UpdateTaskCommand;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TaskFormType;
use App\Form\TaskEditFormType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Query\TaskQuery;
use App\Entity\Task;
use App\Query\PagingTasksQuery;
use App\Query\TasksCountQuery;

class TaskController extends BaseController {
    
    /**
     * @Route("/task/{page}", name="task_index", requirements={"page" = "\d+"}, defaults={"page" = 1})
     *
     * @param int $page
     *
     * @return Response
     */
    public function index(int $page): Response
    {
        $query = new PagingTasksQuery($page, Task::NUM_ITEMS);
        $tasksCount = $this->handleMessage(new TasksCountQuery());
        $maxPages = ceil($tasksCount / Task::NUM_ITEMS);
        $tasks = $this->handleMessage($query);
        
        return $this->render(
            'task/index.html.twig',
            [
                'tasks' => $tasks,
                'maxPages' => $maxPages,
                'currentPage' => $page,
            ]
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
    
    /**
     * @Route("/edit/{id}", name="task_edit", requirements={"id":"\d+"})
     *
     * @param string  $id
     * @param Request $request
     *
     * @return Response
     */
    public function edit(int $id, Request $request)
    {
        $taskQuery = new TaskQuery($id);

        /** @var Task $task */
        $task = $this->handleMessage($taskQuery);

        $form = $this->createForm(TaskEditFormType::class, 
                [
                    TaskEditFormType::NAME => $task->getName(),
                    TaskEditFormType::DONE_NAME => $task->getIsDone()
                ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $updateCommand = new UpdateTaskCommand(
                $task->getId(),    
                $data[TaskEditFormType::NAME],
                $data[TaskEditFormType::DONE_NAME]  
            );

            $this->handleMessage($updateCommand);

            return $this->redirectToRoute('task_show', ['id' => $task->getId()]);
        }

        return $this->render(
            'task/edit.html.twig',
            ['form' => $form->createView()]
        );
    }
}
