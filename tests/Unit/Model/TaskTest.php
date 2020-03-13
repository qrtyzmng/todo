<?php

namespace App\Tests\Unit\Model;

use PHPUnit\Framework\TestCase;
use App\Entity\Task;
use App\Command\AddTaskCommand;
use App\Model\TaskWasCreated;
use App\Model\TaskNameWasChanged;
use App\Model\TaskIsDoneWasChanged;
use App\Shared\DomainEvents;
use App\Model\TaskUpdatedAtWasChanged;
use App\Shared\DomainEventsHistory;

class TaskTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldRecordTaskWasCreatedEvent()
    {
        $addTaskCommand = new AddTaskCommand('First task');
        $task = Task::create($addTaskCommand);
        $task->recordThat(new TaskWasCreated($task->getId(), $task->getName(), $task->getIsDone(), $task->getCreatedAt(), $task->getUpdatedAt()));  
        
        $this->assertTrue(
            $this->assertEvent($task->getRecordedEvents(), TaskWasCreated::class)
        );

        $this->assertEquals('First task', $task->getName());
        $this->assertEquals(false, $task->getIsDone());
    }

    /**
     * @test
     */
    public function itShouldRecordTaskNameWasChangedEvent()
    {
        $addTaskCommand = new AddTaskCommand('First task');
        $task = Task::create($addTaskCommand);

        $task->changeName('test1');

        $this->assertTrue(
            $this->assertEvent($task->getRecordedEvents(), TaskNameWasChanged::class)
        );

        $this->assertEquals('test1', $task->getName());
    }

    /**
     * @test
     */
    public function itShouldDoNothingWhenNewNameIsTheSame()
    {
        $addTaskCommand = new AddTaskCommand('First task');
        $task = Task::create($addTaskCommand);

        $task->changeName('First task');

        $this->assertFalse(
            $this->assertEvent($task->getRecordedEvents(), TaskNameWasChanged::class)
        );

        $this->assertEquals('First task', $task->getName());
    }

    /**
     * @test
     */
    public function itShouldRecordTaskIsDoneChangedEvent()
    {
        $addTaskCommand = new AddTaskCommand('First task');
        $task = Task::create($addTaskCommand);

        $task->changeIsDone(true);

        $this->assertTrue(
            $this->assertEvent($task->getRecordedEvents(), TaskIsDoneWasChanged::class)
        );

        $this->assertEquals(true, $task->getIsDone());
    }

    /**
     * @test
     */
    public function itShouldDoNothingWhensDoneIsTheSame()
    {
        $addTaskCommand = new AddTaskCommand('First task');
        $task = Task::create($addTaskCommand);

        $task->changeIsDone(false);

        $this->assertFalse(
            $this->assertEvent($task->getRecordedEvents(), TaskIsDoneWasChanged::class)
        );

        $this->assertEquals(false, $task->getIsDone());
    }

    /**
     * @test
     */
    public function itShouldRecordTaskUpdatedAtChangedEvent()
    {
        $addTaskCommand = new AddTaskCommand('First task');
        $task = Task::create($addTaskCommand);

        $newUpdatedAt = new \DateTime('tomorrow');
        $task->changeUpdatedAt($newUpdatedAt);

        $this->assertTrue(
            $this->assertEvent($task->getRecordedEvents(), TaskUpdatedAtWasChanged::class)
        );

        $this->assertEquals($newUpdatedAt, $task->getUpdatedAt());
    }

    /**
     * @test
     */
    public function itShouldDoNothingWhenUpdatedAtIsTheSame()
    {
        $addTaskCommand = new AddTaskCommand('First task');
        $task = Task::create($addTaskCommand);
        $updatedAt = $task->getUpdatedAt();
        $task->changeUpdatedAt($updatedAt);

        $this->assertFalse(
            $this->assertEvent($task->getRecordedEvents(), TaskUpdatedAtWasChanged::class)
        );

        $this->assertEquals($updatedAt, $task->getUpdatedAt());
    }

    /**
     * @test
     */
    public function itShouldBeReconstitutedFromHistory()
    {
        $addTaskCommand = new AddTaskCommand('First task');
        $task = Task::create($addTaskCommand);
        $taskId = 1;
        $newName = 'test1';
        $tomorrow = new \DateTime('tomorrow');
        $eventsHistory = new DomainEventsHistory(
            $taskId,
            [
                new TaskWasCreated($taskId, $task->getName(), $task->getIsDone(), $task->getCreatedAt(), $task->getUpdatedAt()),
                new TaskNameWasChanged($taskId, $newName),
                new TaskIsDoneWasChanged($taskId, true),
                new TaskUpdatedAtWasChanged($taskId, $tomorrow),
            ]
        );

        $task = Task::reconstituteFromHistory($eventsHistory);

        $this->assertEquals('test1', $task->getName());
        $this->assertEquals(true, $task->getIsDone());
        $this->assertEquals($tomorrow, $task->getUpdatedAt());
    }

    private function assertEvent(DomainEvents $recodedEvents, $eventClass): bool
    {
        foreach ($recodedEvents as $event) {
            if (get_class($event) === $eventClass) {
                return true;
            }
        }

        return false;
    }
}
