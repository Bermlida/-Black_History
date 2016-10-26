<?php

namespace Vista\TinyRouter\Tests;

class TestHandler
{
    public function process()
    {
        return 'correct';
    }

    public function processWithParams($sort, $top)
    {
        if ($sort == 111 && $top == 222) {
            return 'correct';
        } else {
            return 'error in TestHandler::processWithParams';
        }
    }
    
    public function processWithModel(TestRouteModel $model)
    {
        if ($model->paragraph == 3 && $model->default == 'this is brief sample') {
            return 'correct';
        } else {
            return 'error in TestHandler::processWithModel';
        }
    }
}
