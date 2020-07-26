<?php 

class TaskCrudCest
{
    function _before(AcceptanceTester $I)
    {
        // will be executed at the beginning of each test
        $I->amOnPage('/api/v1/books');
    }

    function createTask(AcceptanceTester $I)
    {
       // todo: write test
    }

    function viewTask(AcceptanceTester $I)
    {
       // todo: write test
    }

    function updateTask(AcceptanceTester $I)
    {
        // todo: write test
    }

    function deleteTask(AcceptanceTester $I)
    {
       // todo: write test
    }
}